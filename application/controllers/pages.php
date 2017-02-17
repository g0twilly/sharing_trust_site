<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/pages
	 *	- or -
	 * 		http://example.com/index.php/pages/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/pages/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index($token=null) {
        $data = array();
        $this->load->library('form_validation');
        if ($token) {
            $data['token'] = $token;
            $data['token_check'] = $this->user->check_token($token);
        }
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->lang->load('about');
		$this->load->view('main', $data);
	}


    /**
     * Welcome page is the Pre-Profile Page
     */
    public function welcome() {
        if ($this->user->is_logged_in()) {
            $this->session->set_flashdata('login', 'already_logged_in');
            redirect('account');
        }
        if ( !($this->input->post('token'))) {
            redirect("/");
        }

        $token_check = $this->user->check_token($this->input->post('token'));

        if ($token_check != 'token_valid') {
            redirect("/token/".$this->input->post('token'));
        }
        if (!($this->input->post('username'))) {
            $this->session->set_flashdata('invalid_email', 'invalid_email');
            redirect("/token/".$this->input->post('token'));
        }
        if ($this->user->get_user_by_username($this->input->post('username'))) {
            $this->session->set_flashdata('duplicate_username', 'duplicate_username');
            redirect("/token/".$this->input->post('token'));
        }

        if (!filter_var($this->input->post('username'), FILTER_VALIDATE_EMAIL) !== false) {
            $this->session->set_flashdata('invalid_email', 'invalid_email');
            redirect("/token/".$this->input->post('token'));
        }

        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run('pages/welcome') === FALSE) {
            $this->session->set_flashdata('invalid_email', 'invalid_email');
            redirect("/token/".$this->input->post('token'));
        }
        else {
            $this->user->save_email_token();
        }

        $data = array(
            'token'     => $this->input->post('token'),
            'username'  => $this->input->post('username'),
        );
        $this->load->view('welcome', $data);
    }


    /**
     * Airbnb Survey questions Controller
     *
     * Note: Skipped in Phase 1
     */
    public function survey_airbnb() {
        $this->user->check_login();
        $this->user->check_step('survey_airbnb');

        $data = array();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('question');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Skip this step if we're in Phase 1
        if ($this->config->item('phase') == 1) {
            $this->user->update_step('survey_airbnb');
            redirect('account');
        }

        if ($this->input->post('host_or_guest') != false) {
            $this->form_validation->set_rules('host_or_guest', i18n('answer_to_question'), 'trim|required');
            if ($this->input->post('host_or_guest') == 'yes') {
                $this->form_validation->set_rules('interact_with_host', i18n('answer_to_question'), 'trim|required');
                if ( ($this->input->post('interact_with_host')) and 
                     ($this->input->post('interact_with_host') == 'yes') ) {
                    $this->form_validation->set_rules('first_interaction', i18n('answer_to_question'), 'trim|required');
                    $this->form_validation->set_rules('hangout', i18n('answer_to_question'), 'trim|required');
                }
            }
        }
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('survey/airbnb', $data);
        }
        else {
            if ($this->question->save_survey_airbnb()) {
                $this->user->update_step('survey_airbnb');
                redirect('account');
            }
            else {
                $this->session->set_flashdata('save_error', 'save_error');
                $this->load->view('survey/airbnb', $data);
            }
        }
    }

    public function survey_postgame() {
        $this->user->check_login();
        $this->user->check_step('survey_postgame');

        $data = array();
        $data['trust_answers'] = array(
            'always_trusted',
            'usually_trusted',
            'usually_not_trusted',
            'always_not_trusted',
            'dont_know',
        );
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('question');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        // Skip this step if we're in Phase 1
        if ($this->config->item('phase') == 1) {
            $this->user->update_step('survey_postgame');
            redirect('account');
        }

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('survey/postgame', $data);
        }
        else {
            if ($this->question->save_survey_postgame()) {
                $this->user->update_step('survey_postgame');
                redirect('account');
            }
            else {
                $this->session->set_flashdata('save_error', 'save_error');
                $this->load->view('survey/postgame', $data);
            }
        }
    }


    /**
     * Risk Question Controller
     */
    public function risk() {
        $this->user->check_login();
        $this->user->check_step('risk');

        $data = array();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('question');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('risk/play', $data);
        }
        else {
            $question = i18n('risk_question');
            if ($this->question->save_risk($question)) {
                $this->user->update_step('risk');
                redirect('account');
            }
            else {
                $this->session->set_flashdata('save_error', 'save_error');
                $this->load->view('risk/play', $data);
            }
        }
    }

    /**
     * Risk Question Controller Take 2
     */
    public function risk2() {
        $this->user->check_login();
        $this->user->check_step('risk2');

        $data = array();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('question');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('risk/play2', $data);
        }
        else {
            $question = i18n('risk_question2');
            if ($this->question->save_risk($question)) {
                $this->user->update_step('risk2');
                redirect('account');
            }
            else {
                $this->session->set_flashdata('save_error', 'save_error');
                $this->load->view('risk/play2', $data);
            }
        }
    }


	public function complete() {
		// Verify Login
		$this->user->check_login();
		$this->user->check_step('phase_complete');
		$this->user->get_user($this->user->getMyId());
		$data = $this->user->get_complete_data();
		$data['user'] = $this->user;
			$this->load->view('complete', $data);
	}

	public function phase_2() {
		// Verify Login
		$this->user->check_login();
		$this->user->get_user($this->user->getMyId());
		$data = array();
                $this->user->update_step('phase_2');
	        $this->load->view('survey/phase_2', $data);
	}
    /**
     * Form validation functionality
     */
}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */
