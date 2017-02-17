<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

    public function index() {
        //redirect("account/info");
        redirect("account/next");
    }

    /**
     * Next Step
     */
    public function next() {
        $data = array();
        if (!$this->user->is_logged_in()) {
            redirect("/account/info");
        }
        $this->user->get_user($this->user->getMyId());
        if ($this->user->avatar == '') {
	    // Bruno: skip avatar selection
            //redirect("/account/avatar");
	    // replaced by next two lines
            $id = $this->user->update_avatar();
            redirect('account/profile_complete');
        }
        $current = $this->user->get_next_step();
        $step_route = $this->config->item('step_routes');

        // Check if new login
        if ($this->session->flashdata('newlogin')) {
            $this->session->set_flashdata('newlogin', 'newlogin');
        }

        redirect($step_route[$current]);
    }

    /**
     * User Account Info Page [logged in?]
     */
    public function info() {
        $data = array();
        if ($this->user->is_logged_in()) {

            $this->user->get_user($this->user->getMyId());
            $data['user'] = $this->user;
        }
        $this->load->view('account/account_info', $data);
    }


    /**
     * Displays the current progress and Steps done/ to be done.
     */
    public function progress() {
        $data = array();
        if (!$this->user->is_logged_in()) {
            redirect("/account/info");
        }

        $this->user->get_user($this->user->getMyId());
        $data['user'] = $this->user;
        $data['current'] = str_replace('overview', 'play', $this->user->get_next_step());
        $this->load->view('account/progress', $data);
    }


   /**
    *  Signup page
    */
    public function signup() {
        if ($this->user->is_logged_in()) {
            $this->session->set_flashdata('login', 'already_logged_in');
            redirect('account');
        }
        if ( !($this->input->post('token')) ) {
            redirect("/");
        }

        $token_check = $this->user->check_token($this->input->post('token'));

        if ($token_check != 'token_valid') {
            redirect("/token/".$this->input->post('token'));
        }

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $hidden_fields = array(
            'token'     => $this->input->post('token'),
            'account_create'    => 'create',
            'email'     => $this->input->post('email'),
        );
        $this->lang->load('signup');
        $this->lang->load('calendar');

        $data = array(
            'hidden'            => $hidden_fields,
        );
        if ($this->input->post('account_create')) {
            if ($this->form_validation->run('account/signup') === FALSE) {
                $this->load->view('account/signup', $data);

            }
            else {
                $id = $this->user->create_user();

                // Auto Log the User in.
                $this->user->get_user($id);
                $this->user->stash_user();
		
                // Bruno: skip avatar selection
                //redirect('account/avatar');
		// replaced by next two lines
                $id = $this->user->update_avatar();
                redirect('account/profile_complete');
            }
        }
        else {
            $this->load->view('account/signup', $data);
        }
    }


    /**
     * User Picks an Avatar Separately now
     */
    public function avatar() {
        $data = array();
        if (!$this->user->is_logged_in()) {
            redirect("/account/info");
        }

        $this->user->get_user($this->user->getMyId());
        $data['user'] = $this->user;

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $hidden_fields = array(
            'user_id'       => $this->user->getMyId(),
            'set_avatar'    => 'set_avatar',
        );
        $data['hidden'] = $hidden_fields;
        $data['avatars'] = $this->user->get_all_avatars();
        if ($this->input->post('set_avatar') == 'set_avatar') {
            if ($this->form_validation->run('account/avatar') === FALSE) {
                $this->load->view('account/avatar', $data);

            }
            else {
                $id = $this->user->update_avatar();
                redirect('account/profile_complete');
            }
        }
        else {
            $this->load->view('account/avatar', $data);
        }
    }

    /**
     * User Picks an Avatar Separately now
     */
    public function profile_complete() {
        $data = array();
        if (!$this->user->is_logged_in()) {
            redirect("/account/info");
        }

        $this->user->get_user($this->user->getMyId());
        $data['user'] = $this->user;

        $this->load->view('account/profile_complete', $data);
    }


   /**
    *  Sign in page
    */
    public function login() {
        if ($this->user->is_logged_in()) {
            $this->session->set_flashdata('login', 'already_logged_in');
            redirect('account/');
        }
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('account/login');

        }
        else {
            if ($this->user->login()) {
                # Bruno: disabled and conluded removed
                #if ($this->user->status == 'expired') {
                #    $this->user->logout();
                #    redirect('/account/expired', 'refresh');
                #}
                #if ($this->user->status == 'disabled') {
                #    $this->user->logout();
                #    redirect('/account/expired', 'refresh');
                #}
                #if ($this->user->study != $this->config->item('study')) {
                #    $this->user->logout();
                #    redirect('/account/concluded', 'refresh');
                #}
                $this->session->set_flashdata('newlogin', 'newlogin');
                redirect('account/next');
            }
            else {
                $this->session->set_flashdata('login', 'no_record');
                redirect('account/login');
            }

        }
    }

    /**
     * Interested page allows users to sign up to be contacted
     */
    public function interested() {
        if ($this->user->is_logged_in()) {
            $this->session->set_flashdata('login', 'already_logged_in');
            redirect('account/');
        }
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('account/login');

        }
        else {
            $this->user->save_interested();
            $this->load->view('account/thank_you');
        }
    }


    /**
     * Signout fxn
     */
    public function logout() {
        $this->user->logout();
        redirect('', 'refresh');
    }

    /**
     * Expired Page
     */
    public function expired() {
        $this->load->view('account/expired');
    }
    
    /**
     * Expired Study Page
     */
    public function concluded() {
        $this->load->view('account/concluded');
    }


    /**
     * Forcably logged out due to idleness
     */
    public function timeout() {
        $this->user->logout();
        $this->session->sess_create();
        $this->session->set_flashdata('logged_out', 'logged_out');
        redirect('', 'refresh');
    }

    /**
     * Validation function for Zip Code
     */
    public function _validate_zipcode($zip) {
        $state = $this->user->get_state_from_zip($zip);
        if ($state != '') {
            return true;
        }
        $this->form_validation->set_message('_validate_zipcode', i18n('zipcode_not_found'));
        return false;
    }

    /**
     * Validation function for IP addresses
     *
     * NOTE: Currently Disabled!!
     */
    public function _validate_ip_address($value, $field) {
        return true;
        $ip = $this->input->ip_address();
        if ($this->input->valid_ip($ip)) {
            return $this->user->is_unique_ip($ip);
        }
        return false;
    }

    //FIXME: remove before go Live
    public function restart() {
        if ($this->user->is_logged_in()) {
            $this->user->restart_player();
        }
        redirect("/account/info");
    }
}
