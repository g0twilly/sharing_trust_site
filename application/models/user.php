<?php

class User extends CI_Model {
    public $id;
    public $username;
    public $first_name;
    public $last_name;
    public $email;
    public $gender;
    public $age;
    public $zip;
    public $state;
    public $region;
    public $marital_status;
    public $type;
    public $grouping;
    public $avatar;
    public $step;
    public $airbnb_type;
    public $ip_address;
    public $status;
    public $study;
    public $will_return;
    public $last_action;
    public $token;

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     *  Get a User from their ID
     */
    public function get_user($id) {
        $query = $this->db->get_where('users',
            array('id' => $id)
        );
        if ($query->num_rows() == 0) {
            return false;
        }
        $result = $query->result_array();
        $this->load_user_data($result[0]);
    }

    public function gettoken() {
        if ($this->token) {
            return $this->token;
        }
        else {
            $this->get_user($this->getMyId());
            return $this->token;
        }
    }

    /**
     * Get a User from their unique username
     */
    public function get_user_by_username($username) {
        $query = $this->db->get_where('users',
            array('username' => $username)
        );
        if ($query->num_rows() == 0) {
            return false;
        }
        $result = $query->result_array();
        $this->load_user_data($result[0]);
        return $this->user_id;
    }

    /**
     * Get a User from their Email
     */
    public function get_user_by_email($email) {
        $query = $this->db->get_where('users',
            array('email' => $email)
        );
        if ($query->num_rows() == 0) {
            return false;
        }
        $result = $query->result_array();
        $this->load_user_data($result[0]);
        return $this->user_id;
    }

    public function get_user_by_email_passwd($email, $passwd) {
        $query = $this->db->get_where('users',
            array('token' => $email,
		  'passwd' => $passwd,
            )
        );
        if ($query->num_rows() == 0) {
            return false;
        }
        $result = $query->result_array();
        $this->load_user_data($result[0]);
        return $this->user_id;
    }

    public function load_user_data($data) {
        $this->user_id =    $data['id'];
        $this->username =   $data['username'];
        $this->first_name = $data['first_name'];
        $this->last_name =  $data['last_name'];
        $this->email =      $data['email'];
        $this->age =        $data['age'];
        $this->zip =        $data['zip'];
        $this->region =     $data['region'];
        $this->state =      $data['state'];
        $this->gender =     $data['gender'];
        $this->marital_status =     $data['marital_status'];
        $this->grouping =   $data['grouping'];
        $this->step =       $data['step'];
        $this->ip_address = $data['ip_address'];
        $this->status     = $data['status'];
        $this->avatar     = $data['avatar'];
        $this->study      = $data['study'];
        $this->airbnb_type  = $data['airbnb_type'];
        $this->will_return  = $data['will_return'];
        $this->last_action = $data['last_action'];
        $this->token       = $data['token'];
    }


    /**
     * Loads user details into session
     */
    public function stash_user() {
        $user_data =
        $this->session->set_userdata(array(
                            'user_id'   => $this->user_id,
                            'username'  => $this->username,
                            'email'     => $this->email,
                            )
                        );
    }

    /**
     * Attempts to Log a User in.
     */
    public function login() {
        if ($this->get_user_by_email_passwd($this->input->post('login'), 
                                            $this->input->post('passwd'))) {
            // Idleness Check: Has this user waited too long to continue playing?
            //$check_time = strtotime($this->last_action) + $this->config->item('idleness_check');
            //if ( (is_numeric($check_time)) and ($check_time > $this->config->item('idleness_check')) and ($check_time < strtotime("now")) ) {
            //    $this->disable_account();
            //}
            // IF they've seen the game this phase, they can't log in.
            //elseif ($this->check_game_already_started()) {
            //    $this->disable_account();
            //}

            $this->stash_user();
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Quick check if robots exist for this phase for this user
     */
    public function check_game_already_started() {
        if (!$this->getId()) {
            return false;
        }
        $query = $this->db->get_where('game_data', array(
            'user_id' => $this->getId(),
            'phase'   => $this->config->item('phase'),
        ));
        if ($query->num_rows() == 0) {
            return false;
        }
        return true;
    }


    /**
     * Log out
     */
    public function logout() {
        $this->session->sess_destroy();
    }

    /**
     * Check if a user is currently logged in.
     */
    public function is_logged_in() {
        return $this->session->userdata('user_id');
    }


    public function getId() {
        return $this->user_id;
    }

    /**
     * GetMyId returns the loggd in user_id. This is a helper function.
     */
    public function getMyId() {
        return $this->session->userdata('user_id');
    }

    /**
     * Saves just email, token, and IP
     */
    public function save_email_token() {
        // Check that user doesn't exist.
        if ($this->get_user_by_email($this->input->post('username'))) {
            return false;
        }
        // Add all submitted data to db.
        $data = array(
           'email'          => $this->input->post('username'), // Email is username
           'ip_address'     => $this->input->ip_address(),
           'token'          => $this->input->post('token'),
        );

        if ($this->db->insert('user_signups', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }


    /**
     * Saves user demographic information
     */
    public function create_user() {
        // Check that user doesn't exist.
        if ($this->get_user_by_email($this->input->post('email'))) {
            return false;
        }
        // Add all submitted data to db.
        $data = array(
           'email'          => $this->input->post('email'),
           'first_name'     => $this->input->post('first_name'),
           'last_name'      => $this->input->post('last_name'),
           'age'            => $this->input->post('age'),
           'gender'         => $this->input->post('gender'),
           'marital_status' => $this->input->post('marital_status'),
           'zip'            => $this->input->post('zip'),
           'grouping'       => $this->set_user_grouping(),
           'study'          => $this->config->item('study'),
           'region'         => $this->get_region_from_zip($this->input->post('zip')),
           'state'          => $this->get_state_from_zip($this->input->post('zip')),
           'airbnb_type'    => $this->get_airbnb_type($this->input->post('token')),
           'username'       => $this->input->post('email'), // Email is username
           'ip_address'     => $this->input->ip_address(),
           'token'          => $this->input->post('token'),
           'status'         => 'unverified',
           'stamp'          => date("Y-m-d H:i:s"),
        );

        if ($this->db->insert('users', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function update_avatar() {
        //$update = array('avatar' => $this->input->post('avatar'));
        $update = array('avatar' => '/img/avatars/neutral/avatar03.jpg'); 
        $this->db->update('users', $update, array('id' => $this->getMyId()));
    }


    public function set_user_grouping() {
        $group = $this->config->item('grouping_probabilities');
        return $group[array_rand($group)];
    }

    public function get_avatar() {
        if (isset($this->avatar)) {
            return $this->avatar;
        }
        return $this->config->item('avatar_url').$this->config->item('avatar_default');
    }

    public function get_all_avatars() {
        $return = array();
        $loc = $this->config->item('basedir').$this->config->item('avatar_url');
        foreach (glob($loc."*.jpg") as $img) {
            if (!strpos('default', $img)) {
                $return[] = str_replace($this->config->item('basedir'), '', $img);
            }
        }
        return $return;
    }


    public function get_airbnb_type($token) {
        $query = $this->db->get_where('tokens', array('token' => $token));
        // No Token. Should have errored already.
        if ($query->num_rows() == 0) {
            return 'guest';
        }
        $row = $query->row();
        // Over 10 is "Guest"
        if ($row->airbnb_type > "10") {
            return 'host';
        }
        return 'guest';
    }

    public function get_region_from_zip($zip) {
        $this->db->select('region')
                    ->from('locations')
                    ->where('zip', $zip)
                    ->limit(1);
        $query = $this->db->get();

        // No Token
        if ($query->num_rows() == 0) {
            return '';
        }
        $row = $query->row();
        return $row->region;
    }


    public function get_region_from_state($state) {
        $this->db->select('region')
                    ->from('locations')
                    ->where('state', $state)
                    ->limit(1);
        $query = $this->db->get();

        // No Token
        if ($query->num_rows() == 0) {
            return '';
        }
        $row = $query->row();
        return $row->region;
    }


    public function get_state_from_zip($zip) {
        $this->db->select('state')
                ->from('locations')
                ->where('zip', $zip)
                ->limit(1);
        $query = $this->db->get();

        // No Token
        if ($query->num_rows() == 0) {
            return '';
        }
        $row = $query->row();
        return $row->state;
    }


    /**
     * Checks if user is logged in, and if not, redirects to the Account page.
     */
    public function check_login($location=null) {
        if (!$this->is_logged_in()) {
            if ($location) {
                redirect($location);
            }
            else {
                redirect('account/');
            }
        }
    }

    /**
     * Checks if the supplied token is valid and unused
     */
    public function check_token($token) {
        if (!$token) {
            return 'token_missing';
        }
        $this->db->select('tokens.token, users.id as user_id')
                    ->from('tokens')
                    ->join('users', 'tokens.token = users.token', 'left')
                    ->where('tokens.token', $token);
        $query = $this->db->get();

        // No Token
        if ($query->num_rows() == 0) {
            return 'token_invalid';
        }
        $row = $query->row();
        if (is_numeric($row->user_id)) {
            return 'token_used';
        }
        return 'token_valid';
    }


   /**
     * Updates user record when a step is completed.
     */
    public function update_step($step) {
        $update = array('step' => $step);
        $this->db->update('users', $update, array('id' => $this->getMyId()));
    }

    /**
     * Checks if a user is allowed to be at a given page based on phase/grouping/progress
     */
    public function check_step($page) {
        $current = $this->get_next_step();
        $current = str_replace('overview', 'play', $current);
        if ($page != $current) {
            redirect("/account/next");
        }
    }

    /**
     * Checks if a given step is already completed
     */
    public function step_is_complete($step) {
        $this->get_user($this->getMyId());
        $current = $this->get_next_step();
        $order = $this->config->item('order');
        ksort($order);
        return (array_search($current, $order) > array_search($step, $order));
    }


    /**
     * Creates a list of the steps this user will actually perform this phase
     */
    public function get_my_steps() {
        $steps = array();
        $phase_2 = array('survey_airbnb', 'survey_postgame');
        $order = $this->config->item('order');
        // If it's phase one, let them know they already completed account creation
        if ($this->config->item('phase') == 1) {
            $steps[] = 'account_create';
        }
        foreach ($order as $item) {
            // Some Players might not play the game
            // Phase 1: Only 1
            // Phase 2: 1 and 2
            if ( ($this->config->item('phase') == 1) and ($this->grouping != '1') ) {
                if (preg_match("/^game_/", $item)) {
                    continue;
                }
            }
            // Overview pages don't need to be displayed
            if (strpos($item, 'overview')) {
                continue;
            }
            // skip these items in phase 1
            if ( ($this->config->item('phase') == 1) and (in_array($item, $phase_2)) ) {
                continue;
            }

            $steps[] = $item;
        }
        return $steps;
    }


    /**
     * Determines the next step for the user
     */
    public function get_next_step() {
        $this->get_user($this->getMyId());
        $current = $this->step;
        $steps = array();
        $prev = null;
        $order = $this->config->item('order');
        ksort($order);
        if ($current == '') {
            return array_shift(array_values($order));
        }
        foreach ($order as $item) {
            // Some Players might not play the game
            // Phase 1: Only 1
            // Phase 2: 1 and 2
            if ( ($this->config->item('phase') == 1) and ($this->grouping != '1') ) {
                if (preg_match("/^game_/", $item)) {
                    continue;
                }
            }
            if (isset($prev)) {
                $steps[$prev] = $item;
            }
            $prev = $item;
        }
        return $steps[$current];
    }

    /** Bruno disabled this
     * Sets an account to disabled, logs them out, and redirects to expired page
    public function disable_account() {
        $data = array(
            'status'      => 'disabled',
        );
        $this->db->where('id', $this->getId());
        $this->db->update('users', $data);
        $this->logout();
        redirect("/account/expired/");
    }
    */

    /**
     * Resets the player to the starting spot
     * FOR DEBUGGING ONLY
     */
    public function restart_player() {
        // Safety Net!
        if (!is_devel($this->getMyId())) {
            return false;
        }

        $where = array('user_id' => $this->getMyId());

        // Risk Survey
        $this->db->delete('user_questions', $where);

        // Phase 2 Survey
        $this->db->delete('airbnb_survey', $where);

        // Game Data
        $this->db->delete('game_data', $where);

        // Final Data
        $this->db->delete('user_final_data', $where);

        $this->db->update('users', array('step' => ''), array('id' => $this->getMyId()));
        return true;
    }

    /**
     * Checks if an ip address is already in the database
     */
    public function is_unique_ip($ip) {
        if (in_array($ip, $this->config->item('whitelisted_ips'))) {
        return true;
    }

    $count = $this->db->get_where('users', array(
            'ip_address' => $ip,
            )
        );

        return ($count->num_rows() == 0);
    }


    /**
     * Returns the score from the Investment game
    public function get_my_game_score() {
        $query = $this->db->limit('1')->order_by('round', 'desc')->get_where('user_game_data', array(
            'phase'     => $this->config->item('phase'),
            'user_id'   => $this->getMyId(),
        ));
        if ($query->num_rows() == 0) {
            return false;
        }
        $result = $query->result_array();
        return $result[0]['final_sum'];
    } */

    /**
     * Returns the Phase complete data
     */
    public function get_complete_data() {
        $query = $this->db->get_where('user_final_data', array(
            'user_id'   => $this->getMyId(),
            'phase'     => $this->config->item('phase'),
            )
        );
        if ($query->num_rows() == 0) {
            $this->set_my_final_data();
            return $this->get_complete_data();
        }
        $result = $query->result_array();
        return $result[0];
    }


    /**
     * Sets data in the user_final_data table
     */
    public function set_my_final_data() {
        $data = array(
                'user_id'       => $this->getMyId(),
                'phase'         => $this->config->item('phase'),
                'score'         => $this->get_my_final_score(),
            );
        if ($this->db->insert('user_final_data', $data)) {
            return $this->db->insert_id();
        }
    }

    /**
     *  Saves is the user plans to return
     */
    public function save_will_return() {
        $answer = $this->input->post('answer');
        $data = array(
            'will_return'      => (strtolower($answer) == 'yes') ? true : false,
        );
        $id = $this->getMyId();
        $this->db->where('id', $id);
        $this->db->update('users', $data);
    }

    /**
     * Returns the users final score, regardless of Grouping
     */
    public function get_my_final_score() {
        $query = $this->db->select_sum('robot_return')->select_sum('investment')->order_by('end_stamp', 'desc')->get_where('game_data', array(
            'phase'     => $this->config->item('phase'),
            'user_id'   => $this->getMyId(),
        ));
        if ($query->num_rows() == 0) {
            return '0';
        }
        $result = $query->result_array();
        $invested = intval($result[0]['investment']);
        $saved = intval($this->config->item('credits') - $invested);
        return $result[0]['robot_return'] + $saved;
    }


    /* Admin User Group Functions */

    /**
     * Grabs a full collection of users who need to be paid or have been paid.
     */
    public function get_completed_players($current=false) {
        $current_sql = ($current) ? ' AND u.study = "'.$this->config->item('study').'" ' : '';
        $query = 'SELECT u.username,
                         u.email,
                         u.first_name,
                         u.last_name,
                         u.id,
                         u.will_return,
                         u.study,
                         f.phase,
                         u.grouping,
                         f.score,
                         f.stamp,
                         f.contacted,
                         f.rewarded,
                         u.study,
                         f.id as game_id
                    FROM users u,
                         user_final_data f
                   WHERE u.id = f.user_id'.$current_sql.'
                ORDER BY f.stamp';
        $results = $this->db->query($query);
        return $results->result_array();
    }

    /**
     * Updates user_final_data to indicate payment
     */
    private function update_final_data($id, $link) {
        $data = array(
            'paid'      => true,
        );
        $this->db->where('id', $id);
        $this->db->update('user_final_data', $data);
    }

    /**
     * Returns all the data the Admin area needs for a given user
     * based on their game id
     */
    public function get_user_game_info($game_id) {
        $query = $this->db->join('users', 'user_final_data.user_id = users.id')->get_where('user_final_data', array('user_final_data.id' => $game_id));
        if ($query->num_rows() == 0) {
            return false;
        }
        $result = $query->result_array();
        return $result[0];
    }

    /**
     * Set user as having been invited to the next Phase
     */
    public function set_as_invited($id) {
        $this->db->where('id', $id);
        $query = $this->db->update('user_final_data', array('contacted' => true));
    }


    /**
     * Returns array of users set to receive reminder email
     */
    public function get_reminder_group($phase) {
        $query = 'SELECT a.*,
                         u.username,
                         u.email
                    FROM users u,
                         user_final_data a
         LEFT OUTER JOIN user_final_data b
                      ON (a.user_id = b.user_id
                     AND a.phase = (b.phase - 1))
                   WHERE b.phase IS NULL
                      AND a.phase = ?
                      AND a.user_id = u.id
                      AND u.status != "duplicate"
                      AND u.status != "expired"
                      AND u.status != "disabled"
                      AND u.study = "'.$this->config->item('study').'"';

        $results = $this->db->query($query, ($phase - 1));
        return $results->result_array();
    }

    /**
     * Records that a reminder email was sent
     */
    public function log_reminder($user_id, $email, $reminder) {
        $data = array(
            'user_id'   => $user_id,
            'email'     => $email,
            'reminder'  => $reminder,
            'phase'     => $this->config->item('phase'),
            'study'     => $this->config->item('study'),
        );
        $this->db->insert('reminder_log', $data);

    }

    /**
     * Saves the email address of a user interested in joining
     */
    public function save_interested() {
        $data = array(
            'email' => $this->input->post('email'),
        );
        $this->db->insert('interested', $data);
    }

    /**
     * Grabs all Reminder Logs
     */
    public function get_reminder_log($current=false) {
        if ($current) {
            $query = $this->db->get_where('reminder_log', array('study' => $this->config->item('study')));
        }
        else {
            $query = $this->db->get('reminder_log');
        }
        return $query->result_array();
    }


    /**
     * Returns the amount invested in phase.
     */
    public function get_my_investment($phase) {
        $query = $this->db->select_sum('investment')->order_by('end_stamp', 'desc')->get_where('game_data', array(
            'phase'     => $phase,
            'user_id'   => $this->getMyId(),
        ));
        if ($query->num_rows() == 0) {
            return '0';
        }
        $result = $query->result_array();
        return $result[0]['investment'];
    }

    /**
     * Returns the amount returned in phase.
     */
    public function get_my_return($phase) {
        $query = $this->db->select_sum('robot_return')->order_by('end_stamp', 'desc')->get_where('game_data', array(
            'phase'     => $phase,
            'user_id'   => $this->getMyId(),
        ));
        if ($query->num_rows() == 0) {
            return '0';
        }
        $result = $query->result_array();
        return $result[0]['robot_return'];
    }
    
    public function get_my_game_score($phase) {
        $query = $this->db->limit('1')->get_where('user_final_data', array(
            'phase'     => $phase,
            'user_id'   => $this->getMyId(),
        ));
        if ($query->num_rows() == 0) {
            return '0';
        }
        $result = $query->result_array();
        return $result[0]['score'];
    }


    /**
     * Returns the score of the winner
     */
    public function get_top_score($phase) {
        $query = $this->db->limit('1')->order_by('score', 'desc')->get_where('user_final_data', array(
            'phase'     => $phase,
        ));
        if ($query->num_rows() == 0) {
            return '0';
        }
        $result = $query->result_array();
        return $result[0]['score'];
    }

    /**
     * Returns the score of the bottom 25%
     */
    public function get_bottom_score($phase) {
        $query = $this->db->select('*')->order_by('score', 'desc')->limit('100')->get_where('user_final_data', array('phase'=>$phase));
        $total_count = $query->num_rows();
        if ($total_count == 0) {
            return '0';
        }
        $result = $query->result_array();
        return end($result)['score'];
     }
}
