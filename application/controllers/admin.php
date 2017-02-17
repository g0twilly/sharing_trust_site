<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

    /**
     * Index Page for this controller.
     */
    public function index() {
        $data = array();
        $data['show_toggle'] = $this->session->userdata('admin_showtoggle');
        $data['userlist'] = $this->user->get_completed_players();
        $this->load->view('admin/dashboard', $data);
    }

    /**
     * Handles Cron script for sending Reminder Emails
     */
    public function sendreminders() {
        $reminder = reminder_check();
        if(!$this->input->is_cli_request()) {
            echo "This function can only be accessed from the command line.";
            return;
        }
        $sent = $sms_sent = 0;
        $reminder = reminder_check();
        if ($reminder) {
	        $users = $this->user->get_reminder_group($this->config->item('phase'));
            $this->lang->load('admin');
            $this->load->library('email');

            if ($reminder == 'first' || $reminder == 'second') {
                $config['wordwrap'] = TRUE;
                $this->email->initialize($config);

                foreach ($users as $user) {
                    // From
                    $from = $this->config->item('email');
                    $this->email->from($from, i18n('the_exchange'));

                    // To
                    $this->email->to($user['email']);

                    // Subject
                    $subject = i18n('reminder_subject_'.$reminder);
                    $this->email->subject($subject);

                    // Body
                    $msg= i18n('reminder_body', $user['username']);
                    $this->email->message($msg);

                    if ($this->email->send()) {
                        $sent++;
                        $this->user->log_reminder($user['user_id'], $user['email'], $reminder);
                    }
                    else {
                        echo $this->email->print_debugger();
                    }
                }
            }
        }
        if ($sent >= 1) {
            echo "Email Reminders sent: $sent." . PHP_EOL;
        }
    }

    /**
     * Test functionality sending Reminder Emails
     */
    public function testreminders() {
        $reminder = reminder_check();
        if(!$this->input->is_cli_request()) {
            echo "This function can only be accessed from the command line.";
            return;
        }
        $sent = $sms_sent = 0;
        $reminder = reminder_check();
        if ($reminder) {
            echo "Reminder: '$reminder'\n";
            $users = $this->user->get_reminder_group($this->config->item('phase'));
            $this->lang->load('admin');

            if ($reminder == 'first' || $reminder == 'second') {
                foreach ($users as $user) {
                    // From
                    $from = $this->config->item('email');

                    // To
                    $this->email->to($user['email']);

                    // Subject
                    $subject = i18n('reminder_subject_'.$reminder);

                    // Body
                    $msg= i18n('reminder_body', $user['username']);
                    echo "Email: $to\n";
                    $sent++;
                }
            }
            else {
                foreach ($users as $user) {
                    if (isset($user['phone_carrier']) && isset($user['phone'])) {
                        // From
                        $from = $this->config->item('email');

                        // To
                        $to = '';
                        foreach ($this->config->item('mobile_carriers') as $key => $value) {
                            if ($user['phone_carrier'] == 'tracfone') {
                                $to .= str_replace('%s', $user['phone'], $value['gateway']).",";
                            }
                            elseif ($user['phone_carrier'] == $key) {
                                $to = str_replace('%s', $user['phone'], $value['gateway']);
                            }
                        }

                        // Subject
                        $subject = '';

                        // Body
                        $msg = i18n('sms_reminder');
                        echo "SMS: $to\n";
                        $sms_sent++;
                        $this->user->log_reminder($user['user_id'], $to, $reminder);
                    }
                }
            }
        }
        if ($sent >= 1) {
            echo "Email Reminders sent: $sent." . PHP_EOL;
        }
        if ($sms_sent >= 1) {
            echo "SMS Reminders sent: $sms_sent." . PHP_EOL;
        }
    }

    /**
     * Display Email reminders sent
     */
    public function reminders() {
        $data = array();
        $data['show_toggle'] = $this->session->userdata('admin_showtoggle');
        $data['reminders'] = $this->user->get_reminder_log($data['show_toggle'] == 'show_current');
        $this->load->view('admin/reminders', $data);
    }

    /**
     * Sets view toggle session variable and returns to current page
     */
    public function showtoggle() {
        $toggle = $this->input->post('show_toggle');
        $this->session->set_userdata('admin_showtoggle', $toggle);
        $url = $this->input->post('return_url');
        if (!strlen($url)) {
            $url = '/admin/';
        }
        redirect($url);
    }


    /** AJAX FUNCTIONS **/

	/**
	 * Sends an Invitation to return to the Game
	 */
	public function send() {
		if (! $this->input->is_ajax_request()) {
            redirect('404');
        }
        $id = $this->input->post('sendid');
        $game_info = $this->user->get_user_game_info($id);
        if ($game_info) {
            if ($game_info['contacted'] == 1) {
                echo "<span class='error'>Records indicate user for Game id: '$id' already Invited.</error>";
            }
            else {
                $email = $this->send_invitation($game_info['email']);
                if ($email) {
                    $this->user->set_as_invited($id);
                    echo "<span title='Invited' class='glyphicon glyphicon-ok green'></span>";
                }
                else {
                    echo '<span class="error">Problem sending Email.</span>';
                }
            }
        }
        else {
                echo '<span class="error">User Info Not Found</span>';
        }
    }

    /**
    * Email User the gift card link.
    */
    public function send_invitation($email) {
        $this->load->library('email');
        $this->lang->load('admin');
        $config['wordwrap'] = FALSE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);

        // From
        $from = $this->config->item('email');
        $this->email->from($from, i18n('the_exchange'));

        // To
        $this->email->to($email);

        // Subject
        $subject = i18n('invitation_subject');
        $this->email->subject($subject);

        // Body
        $template = i18n('invitation_body_template');
        $msg = $this->load->view($template, array(
        ), TRUE);
        $this->email->message($msg);

        if ($this->email->send()) {

            return $email;
        }
        else {
            error_log($this->email->print_debugger());
            return false;
        }
    }


    /**
     * Loads just the Payout Table
     */
    public function payout_table() {
    	if (! $this->input->is_ajax_request()) {
            redirect('404');
        }
    	$data = array();
        $data['payouts'] = $this->user->get_payout_players();
        $this->load->view('admin/payouts_table', $data);
    }

    /**
     * Loads just the Gift Card Status Table
     */
    public function gift_card_status() {
        if (! $this->input->is_ajax_request()) {
            redirect('404');
        }
        $data = array();
        $data['gift_cards'] = $this->user->get_gift_card_status();
        $this->load->view('admin/gift_card_status', $data);
    }
}
