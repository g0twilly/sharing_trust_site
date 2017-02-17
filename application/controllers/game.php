<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game extends CI_Controller {

    /**
     * Index Page for this controller.
     */
    public function index() {
        redirect("/game/overview");
    }

    /**
     * Display an overview of the game
     */
    public function overview() {
        $data = array();
        $this->load->view('game/overview', $data);
    }

    /**
     * Displays instructions for the game and lazily requires an I understand click.
     */
    public function instructions() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->input->post()) {
            if ($this->form_validation->run() !== FALSE) {
                redirect("/game/play");
            }
        }
        $data = array();
        $this->load->view('game/instructions', $data);
    }

    /**
     * Run the Game
     */
    public function play() {
        // Verify Login
        $this->user->check_login();
        $this->user->check_step('game_play');
        $this->user->get_user($this->user->getMyId());
        $this->load->model('exchange');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $round = null;
        $summary = false;

        $data = array();
        $data['robot_count'] = $this->config->item('robot_count');

        if ($this->input->post()) {
            foreach (range(1,$data['robot_count']) as $id) {
                $requirements = array('required', 
                                      'trim',
                                      'is_natural',
                                      'less_than['.($this->config->item('credits') + 1).']',
                                      'greater_than[-1]',
                                );

                $this->form_validation->set_rules('investment['.$id.']', i18n('investment'), join("|", $requirements));
                $this->form_validation->set_rules('game_id['.$id.']', i18n('game_id'), 'required|is_natural_no_zero|callback__validate_gameid');
            }
            $this->form_validation->set_rules('investment_sum', i18n('investment'), 'callback__validate_investment_sum');
            if ($this->form_validation->run() !== FALSE) {
                $this->exchange->save_investments($this->user);
                $this->user->update_step('game_play');
                redirect("/account/");
            }
        }
        $data['current_holdings'] = $this->config->item('credits');
        $data['user'] = $this->user;
        $data['robots'] = $this->exchange->get_robots($this->user);

        $this->load->view('game/play', $data);
    }

    /**
     * Final Results
     */
    public function results() {
        // Verify Login
        $this->user->check_login();
        $this->user->check_step('game_results');
        $data = array();
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->load->model('exchange');
        $this->load->view('game/results', $data);
    }

    /**
     * Completes the game and sends them to Phase complete
     */
    public function complete() {
        // Verify Login
        $this->user->check_login();
        $this->user->check_step('game_results');
        $this->user->get_user($this->user->getMyId());
        if ($this->config->item('phase') > 1) {
            $this->user->update_step('game_results');
        }
        else {
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            if ($this->form_validation->run() !== FALSE) {
                    $this->user->save_will_return();
                    $this->user->update_step('game_results');
            }
        }
        redirect("/account/");
    }

    /* VALIDATION FUNCTIONALITY */

    /**
     * Verify game_id matches for user
     */
    public function _validate_gameid($game_id) {
        $this->user->get_user($this->user->getMyId());
        $robots = $this->exchange->get_robots($this->user);
        foreach($robots as $r) {
            if ($game_id == $r['id']) {
                return true;
            }
        }
        $this->form_validation->set_message('_validate_gameid', 'The %s field can not be altered.');
        return false;
    }

    /**
     * Make sure total investment doesn't exceed amount allowed
     */
    public function _validate_investment_sum() {
        $investments = $this->input->post('investment');
        $max = $this->config->item('credits');
        if (array_sum($investments) > $max) {
            $this->form_validation->set_message('_validate_investment_sum', i18n('investment_over_max'));
            return false;
        }
        return true;

    }
}