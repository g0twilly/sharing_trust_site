<?php

class Question extends CI_Model {
    public $id;

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
        $this->load_user_data($query->row());
    }

    /**
     * Returns random Trust question as defined in config [tise]
     */
    public function get_trust_question() {
        $questions = $this->config->item('trust_survey');
        $select = array_rand($questions);

        return array($select => $questions[$select]);
    }

    /**
     * Saves a Risk answer for the logged in user
     */
    public function save_risk($question) {
        $user_id = $this->user->getMyId();
        $answer = $this->input->post('answer');

        if ($user_id and $answer) {
            // Add all submitted data to db.
            $data = array(
                'user_id'       => $user_id,
                'phase'         => $this->config->item('phase'),
                //'question'      => $question,
                'question'      => "Risk",
                'answer'        => $answer,
            );

            if ($this->db->insert('user_questions', $data)) {
                return $this->db->insert_id();
            }
        }
        return false;
    }


    /**
     * Saves a Airbnb Survey answers for the logged in user
     */
    public function save_survey_airbnb() {
        $user_id = $this->user->getMyId();
        $host = $this->input->post('host_or_guest');

        if ($user_id) {
            // Add all submitted data to db.
            $data = array(
                'user_id'           => $user_id,
                'phase'             => $this->config->item('phase'),
                'host_or_guest'     => $this->input->post('host_or_guest') ?: '',
                'interact'          => $this->input->post('interact_with_host') ?: '',
                'first_interaction' => $this->input->post('first_interaction') ?: '',
                'hangout'           => $this->input->post('hangout') ?: '',
            );

            if ($this->db->insert('airbnb_survey', $data)) {
                return $this->db->insert_id();
            }
        }
        return false;
    }

    /**
     * Save any postgame survey answers for the logged in user
     */
    public function save_survey_postgame() {
        $user_id = $this->user->getMyId();
        $postgame_questions = array('rate_your_experience', 'trust_question');
        foreach ($postgame_questions as $question) {
            $answer = $this->input->post($question) ?: false;

            if ($user_id and $answer) {
                // Add all submitted data to db.
                $data = array(
                    'user_id'       => $user_id,
                    'phase'         => $this->config->item('phase'),
                    'question'      => $question,
                    'answer'        => $answer,
                );

                $this->db->insert('user_questions', $data);
            }
        }
        return true;
    }
}
