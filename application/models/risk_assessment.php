<?php

class Risk_Assessment extends CI_Model {
    public $picks;
    public $options;

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * Determine what round the current user is on.
     */
    public function get_round() {
        return (count($this->get_previous_picks())) ?
                    max(array_keys($this->get_previous_picks())) + 1 :
                    '1';
    }

    /**
     * Return all the current user's selections.
     */
    public function get_previous_picks($flush=false) {
        if ((is_array($this->picks)) and (!($flush))) {
            return $this->picks;
        }
        $query = $this->db->get_where('user_risk_assessment',
            array('user_id' => $this->user->getMyId(),
                  'phase'   => $this->config->item('phase')
                  )
        );
        foreach ($query->result_array() as $row) {
            $this->picks[$row['round']] = $row['answer'];
        }
        return array_reverse( (array) $this->picks, true);
    }

    /**
     * Returns the current rounds options
     */
    public function get_options() {
        if ((is_array($this->options))) {
            return $this->options;
        }
        $this->options =   array();
        for ($i=1;$i<=10;$i++) {
            $this->options[$i] = array(
                    'max'   => ($i*10),
                    'min'   => ((10-$i) * 10),
            );
        }
        return $this->options;
    }

    /**
     * Save the current users selection
     */
    public function save_pick() {
        $user_id    = $this->user->getMyId();
        $round      = $this->input->post('round');
        $answer     = $this->input->post('answer');

        if ($user_id and $round and $answer) {
            // Make sure this is the correct round:
            if (($this->get_round() == $round) and ($answer == 'A' or $answer == 'B')) {
                // Add all submitted data to db.
                $data = array(
                    'user_id'       => $user_id,
                    'phase'         => $this->config->item('phase'),
                    'round'         => $round,
                    'answer'        => $answer,
                );

                if ($this->db->insert('user_risk_assessment', $data)) {
                    return $this->db->insert_id();
                }
            }
        }
        return false;
    }

    /**
     * Return which round of the lottery to use
     */
    public function get_lottery_winner() {
        // Just a rand 1-10.
        return mt_rand(1,10);
    }
    /**
     * Return which lottery the user chose
     */
    public function get_lottery_pick($lottery) {
        $picks = $this->get_previous_picks();
        return $picks[$lottery];
    }

    /**
     * Select which of the probabilities [max/min] to use for the lottery.
     */
    public function run_lottery($lottery, $pick) {
        $array = array();
        for ($i=1;$i<=10;$i++) {
            if ($i <= $lottery) {
                $array[$i] = 'max';
            }
            else {
                $array[$i] = 'min';
            }
        }
        shuffle($array);
        return $array[mt_rand(0, count($array) - 1)];
    }

    /**
     * Quick match function to determine and save lottery winnings
     */
    public function save_winnings($lottery, $pick, $maxmin) {
        $values = $this->config->item('risk');
        $winnings = $values[strtolower($pick)][$maxmin];
        $data = array(
            'user_id'       => $this->user->getMyId(),
            'phase'         => $this->config->item('phase'),
            'winnings'      => $winnings,
            'lottery'       => $lottery,
            'pick'          => $pick,
        );
        if ($this->db->insert('user_risk_lottery', $data)) {
            return $winnings;
        }
        return false;
    }

    /**
     * Checks if it is time to run the lottery.
     *
     * @return bool true if it's time to run lottery
     */
    public function check_lottery() {
        // Must be on round 11
        if ($this->get_round() == '11') {
            $query = $this->db->get_where('user_risk_lottery',
                array(
                    'user_id'   => $this->user->getMyId(),
                    'phase'     => $this->config->item('phase'),
                )
            );
            if ($query->num_rows() == 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Grabs Lottery Results from the Database
     */
    public function get_lottery_information() {
        if ($this->get_round() == '11') {
            $query = $this->db->get_where('user_risk_lottery',
                array(
                    'user_id'   => $this->user->getMyId(),
                    'phase'     => $this->config->item('phase'),
                )
            );
            if ($query->num_rows() == 0) {
                return false;
            }
            foreach ($query->result_array() as $row) {
                $values = $this->config->item('risk');
                $maxmin = ($row['winnings'] == $values[strtolower($row['pick'])]['max']) ? 'max' : 'min';
                $data = array(
                    'options'   => $this->ra->get_options(),
                    'lottery'   => $row['lottery'],
                    'pick'      => strtolower($row['pick']),
                    'maxmin'    => $maxmin,
                    'winnings'  => $row['winnings'],
                );
                return $data;
            }
        }
        return false;
    }
}
