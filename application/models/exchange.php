<?php

class Exchange extends CI_Model {

    public $previous;

    public function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    /**
     * Gets robots for Phase 2
     */
    public function get_phase_2_robots($user) {
        if (!($user->region)) {
            $user->get_user($user->getMyId());
        }
        // Check if the robots already exist
        $query = $this->db->limit($this->config->item('robot_count'))
                          ->get_where('game_data',
        				    array(
					'user_id'   => $user->getMyId(),
					'phase'     => '1',
				    )
        );
        if ($query->num_rows() != 0) {
                foreach ($query->result_array() as $row) {
			// Checks if the user has taken too long to play
			//if ( (time() - strtotime($row['start_stamp'])) > 3600) {
			//    $user->disable_account();
			//    exit();
			//}
			//print '<br><br><br>';
			//print_r($row);
			$row['phase']= '2';
			unset($row['id']);
			unset($row['investment']);
			unset($row['end_stamp']);
			unset($row['input_stamp']);
			unset($row['robot_percentage']);
			unset($row['robot_return']);
			unset($row['robot_order']);
			
			// Insert in database
			$isthere = $this->db->get_where('game_data', $row);
			    //array(
			    //  'user_id'   => $user->getMyId(),
			    //  'phase'     => '2',
			    //)
			//);
			//print '<br><br><br>';
			//print_r($isthere);
			//print '<br><br><br> Num Rows ';
			//print($isthere->num_rows());
			if ($isthere->num_rows() == 0){
			 	//print_r($row);
				$this->db->insert('game_data', $row);
				$row['id']= $this->db->insert_id();
			}else{
                            $row['id']= $isthere->result_array()[0]['id']; 
                        }
	                $robots[] = $row;
               }
        }
        shuffle($robots);
        return $robots;
    }



        //if (count($robots) != $this->config->item('robot_count')) {
        //    $robots = array();
            // Grab Robots from Phase 1
        //    $query = $this->db->limit($this->config->item('robot_count'))->get_where('game_data',
        //        array(
        //            'user_id'   => $user->getMyId(),
        //            'phase'     => '1',
        //        )
        //    );
        //    if ($query->num_rows() != 0) {
        //        foreach ($query->result_array() as $row) {
        //            $robots[] = $this->get_similar_robot($user, $row);
        //        }
             //  }
        //}

    /**
     * Gets a robot with same world and distance 0 from supplied info
     */
    public function get_similar_robot($user, $data) {
        $robot = $this->get_robot_airbnb_vars($data['robot_world'], $data['robot_type']);
        $state = $this->get_state($data['robot_region'], $user->state, 'close');
        $total_distance = $data['robot_distance'];

        $info = array(
            'robot_age'               => $this->get_age($data['robot_age'], 'close', $data['robot_age']),
            'robot_marital_status'    => $this->get_marital_status($data['robot_marital_status'], 'close'),
            'robot_gender'            => $this->get_gender($data['robot_gender'], 'close'),
            'robot_state'             => $state,
            //'robot_avatar'            => $this->get_random_avatar($user->avatar),
            'robot_avatar'            => '/img/avatars/neutral/avatar02.jpg',
            'robot_region'            => $data['robot_region'],
            'robot_distance'          => $total_distance,
        );
        $robot = array_merge($robot, $info);
        $id = $this->save_pre_robot($user, $robot);
        if ($id) {
            $robot['id'] = $id;
            return $robot;
        }

        return $this->get_similar_robot($data);
    }


    /**
     * Get the collection of robots for the given user
     * // FIXME: Requires an update for Phase 2 to guarantee same robots.
     */
    public function get_robots($user) {
        // Phase 2 robots match phase 1 robots.
        if ($this->config->item('phase') > 1) {
            return $this->get_phase_2_robots($user);
        }

        $robots = array();
        if (!($user->region)) {
            $user->get_user($user->getMyId());
        }

        $query = $this->db->limit($this->config->item('robot_count'))->get_where('game_data',
            array(
                'user_id'   => $user->getMyId(),
                'phase'     => $this->config->item('phase'),
            )
        );
        if ($query->num_rows() != 0) {
            foreach ($query->result_array() as $row) {
                // Checks if the user has taken too long to play
                //if ( (time() - strtotime($row['start_stamp'])) > 3600) {
                //    $user->disable_account();
                //    exit();
                //}
                $robots[] = $row;
            }
        }

       /* Generate Robots
        * Robot 1 - Distance 0 World N
        * Robot 2 - Distance 1 World N
        * Robot 3 - Distance 2 World N
        * Robot 4 - Distance 4 World N
        * Robot 5 - Distance 4 World N-1
        */

        // Choose Worlds
        $world = $this->get_world();
        // This world differs from $world by 1 attribute.
        $worlds = $this->config->item('robot_worlds');
        $picked = $worlds[$world];
        $new_world = $picked;
        $w_attribute = array_rand($picked);
        $new_world[$w_attribute] = ($picked[$w_attribute] == 'high') ? 'low' : 'high';
        $other_world = $this->get_world_from_attributes($new_world);

        // Choose Homophily attributes
        $attrs = $this->config->item('attributes');
        $attr_keys = array_rand($attrs, 4);
        shuffle($attr_keys);
        $h_attribute_1 = $attrs[$attr_keys[0]];
        $h_attribute_2 = $attrs[$attr_keys[1]];
        $h_attribute_3 = $attrs[$attr_keys[2]];
        $h_attribute_4 = $attrs[$attr_keys[3]];

        if (count($robots) != $this->config->item('robot_count')) {
            $robots = array();
            $homophily = array(
                $h_attribute_1 => 'close',
                $h_attribute_2 => 'close',
                $h_attribute_3 => 'close',
                $h_attribute_4 => 'close',
            );
            // Save these in the DB as well.
            $picked_attributes = array(
                'homophily_random_1'    => $h_attribute_1,
                'homophily_random_2'    => $h_attribute_2,
                'world_random_1'        => $w_attribute,
            );

            /* Seed data is used to assure consistency across robots */

            // Select a seed age that doesn't match the 18-32 / 33-79 young/old block
            $seed_age = $user->age;
            $age_range = $this->get_bounded_dissimilar_age_range($user->age);

            while (in_array($seed_age, $age_range)) {
                $seed_age = ($user->airbnb_type == 'guest') ? $this->get_guest_age() : $this->get_host_age();
            }

            // Select quartile seed for member since
            //$member_since_low   = 'q'.mt_rand(4,4);
            //$member_since_high  = 'q'.mt_rand(1,1);

            // Select quartile seed for number of reviews
            $reviews_low   = 'q'.mt_rand(1,3);
            $reviews_high  = $reviews_low;
	    while($reviews_high <= $reviews_low){
            	$reviews_high   = 'q'.mt_rand(2,4);
            }

            $reviews_seed = null;

            // Set boundaries for q4 high reviews
            if ($reviews_high == 'q4') {
                $reviews_seed = ($user->airbnb_type == 'guest') ?
                    $this->get_guest_reviews($reviews_high) :
                    $this->get_host_reviews($reviews_high);
            }

            $seeds = array(
                'age'               => $seed_age,
                //'member_since_low'  => $member_since_low,
                //'member_since_high' => $member_since_high,
                'reviews_low'       => $reviews_low,
                'reviews_high'      => $reviews_high,
                'reviews_seed'      => $reviews_seed,
            );

            // Robot 1 - Distance 0 World N
            $robots[1] = $this->get_robot($user, $homophily, $world, $picked_attributes, $seeds);

            // Robot 2 - Distance 1 World N
            $homophily[$h_attribute_1] = 'far';
            $robots[2] = $this->get_robot($user, $homophily, $world, $picked_attributes, $seeds);

            // Robot 3 - Distance 2 World N
            $homophily[$h_attribute_2] = 'far';
            $robots[3] = $this->get_robot($user, $homophily, $world, $picked_attributes, $seeds);

            // Robot 4 - Distance 4 World N
            $homophily[$h_attribute_3] = 'far';
            $homophily[$h_attribute_4] = 'far';
            $robots[4] = $this->get_robot($user, $homophily, $world, $picked_attributes, $seeds);

            // Robot 5 - Distance 4 World N-1
            $robots[5] = $this->get_robot($user, $homophily, $other_world, $picked_attributes, $seeds);
        }
        shuffle($robots);
        return $robots;
    }


    /**
     * Based on the current user, return a robot
     */
    public function get_robot(&$user, $homophily, $world, $picked_attributes, $seeds) {
        $robot = $this->get_robot_airbnb_vars($world, $user->airbnb_type, $seeds);
        $state = $this->get_state($user->region, $user->state, $homophily['location']);
        $distance_array = array_count_values($homophily);
        $total_distance = (isset($distance_array['far'])) ? $distance_array['far'] : '0';

        $info = array(
            'robot_age'               => $this->get_age($user->age, $homophily['age'], $seeds['age']),
            'robot_marital_status'    => $this->get_marital_status($user->marital_status, $homophily['marital_status']),
            'robot_gender'            => $this->get_gender($user->gender, $homophily['gender']),
            'robot_state'             => $state,
            //'robot_avatar'            => $this->get_random_avatar($user->avatar),
            'robot_avatar'            => '/img/avatars/neutral/avatar02.jpg',
            'robot_region'            => $user->get_region_from_state($state),
            'robot_distance'          => $total_distance,
        );

        $robot = array_merge($robot, $info, $picked_attributes);

        // Sanity check on Age and Member since
        //if ( ($robot['robot_age'] - (date('Y') - $robot['robot_member_since'])) < 18) {
        //    $robot['robot_age'] = 18 + (date('Y') - $robot['robot_member_since']);
        //}

        $id = $this->save_pre_robot($user, $robot);
        if ($id) {
            $robot['id'] = $id;
            return $robot;
        }

        return $this->get_robot($user, $homophily, $world, $picked_attributes, $seeds);
    }


    /**
     * Saves Robot information for the user before gameplay
     */
    private function save_pre_robot($user, $robot) {
        $data = array(
            'user_id'   => $user->getMyId(),
            'phase'     => $this->config->item('phase'),
        );
        $data = array_merge($data, $robot);

        if ($this->db->insert('game_data', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    /**
     * Save All the Robot investment information for the user
     */
    public function save_investments($user) {
        $game_ids = $this->input->post('game_id');
        foreach (range(1, $this->config->item('robot_count')) as $i) {
            $this->save_post_robot($user, $i, $game_ids[$i]);
        }
    }


    /**
     * Saves Robot and Investment information for the user after gameplay
     */
    private function save_post_robot($user, $id, $game_id) {
        $investments = $this->input->post('investment');
        $timestamps = $this->input->post('investment_stamp');
        $percentage = $this->get_robot_return();
        $data = array(
            'investment'        => $investments[$id],
            'end_stamp'         => date('Y-m-d H:i:s'),
            'input_stamp'       => $timestamps[$id],
            'robot_percentage'  => $percentage,
            'robot_return'      => $this->get_total_return($investments[$id], $percentage),
            'robot_order'       => intval($id + 1),
        );

        $this->db->where('id', $game_id);
        $this->db->where('user_id', $user->getMyId());
        $this->db->where('phase', $this->config->item('phase'));
        $this->db->update('game_data', $data);
    }

    /**
     * Returns the total amount returned
     */
    private function get_total_return($investment, $percentage) {
        $total_investment = $investment * $this->config->item('multiplier');
        $earned = $total_investment * $percentage;
        return round($earned);
    }

    /**
     * Returns the percentage the Robot will return
     */
    public function get_robot_return() {
        return $this->generate_investment_percentage();
    }


    public function get_robot_airbnb_vars($world_name, $type, $seeds) {
        $worlds = $this->config->item('robot_worlds');
        $world = $worlds[$world_name];
        $robot_rating        = $this->get_rating($world);
        $robot_reviews       = $this->get_reviews($world, $type, $seeds);
        //$robot_member_since  = $this->get_member_since($world, $type, $seeds);

        // Check to verify Reviews 0 with Rating doesn't occur
        if ($robot_reviews == '0') {
                $robot_rating = 'not_available';
        }

        return array(
            'robot_world'         => $world_name,
            'robot_type'          => $type,
            'robot_rating'        => $robot_rating,
            'robot_reviews'       => $robot_reviews,
            //'robot_member_since'  => $robot_member_since,
        );
    }


    /**
     * Returns a State based on close/far form user
     */
    public function get_state($region, $state,  $distance) {
        switch($distance) {
            case 'close':
                //$query = $this->db->limit(1)
                // ->order_by("id", "random")
		// ->where('state !=', "Alaska")
                // ->where('state !=', "Hawaii")
                // ->get_where('locations', array('region' => $region)
                //);
                //if ($query->num_rows() == 0) {
                //    return false;
                //}
                return $state;
                break;
            case 'far':
                $this->db->select('*')->from('locations')
                                      ->where('region !=', $region)
                                      ->where('state !=', "Alaska")
                                      ->where('state !=', "Hawaii")
                                      ->limit(1)
                                      ->order_by("id", "random");
                $query = $this->db->get();
                if ($query->num_rows() == 0) {
                    return false;
                }
		$row = $query->row();
		return $row->state;
                break;
        }
    }

    /**
     * Returns the age of the robot
     */
    public function get_age($age, $distance, $seed_age) {
        switch($distance) {
            case 'close':
                $return = $this->get_bounded_similar_age($age);
                break;
            case 'far':
                $return = $this->get_similar_robot_age($seed_age, $age);
                break;
        }
        return $return;
    }

    /**
     * Get bounded similar age
     *
     * returns an age within the range specified.
     * special handling of teenagers
     */
    public function get_bounded_similar_age_range($age) {
        $bound = $this->config->item('age_boundary');

        $min = max(18, ($age-$bound));
        $max = min(80, ($age+$bound));

        $ages = range($min, $max);
        return $ages;
    }


    /**
     * Get bounded dissimilar age
     *
     * returns an age within the range specified.
     * special handling of teenagers
     */
    public function get_bounded_dissimilar_age_range($age) {
        $bound = $this->config->item('age_boundary') + 7;

        $min = max(18, ($age-$bound));
        $max = min(80, ($age+$bound));

        $ages = range($min, $max);
        return $ages;
    }


    public function get_bounded_similar_age($age) {
        $ages = $this->get_bounded_similar_age_range($age);
        return array_mt_rand($ages);
    }


    /**
     * Get similar age
     *
     * returns an age in the same decade.
     * special handling of teenagers
     * Age does not appear in range around user's age.
     */
    public function get_similar_robot_age($age, $user_age) {
        $range = $this->get_bounded_similar_age_range($user_age);
        $ages = array();
        if ($age < 20) {
            $ages = range(18,19);
        }
        else {
            $decade = intval($age/10) * 10;
            $ages = range($decade, ($decade + 9));
        }
        $ages = array_diff($ages, $range);
        shuffle($ages);

        return array_mt_rand($ages);
    }


    /**
     * Gets a random age for a guest robot
     */
    public function get_guest_age() {
        $guest_age = array(
                '18' => 303307,
                '19' => 596822,
                '20' => 914237,
                '21' => 1342810,
                '22' => 1850670,
                '23' => 2430269,
                '24' => 3073144,
                '25' => 3774572,
                '26' => 4483497,
                '27' => 5193040,
                '28' => 5876270,
                '29' => 6542604,
                '30' => 7181929,
                '31' => 7764193,
                '32' => 8310056,
                '33' => 8814834,
                '34' => 9279735,
                '35' => 9717640,
                '36' => 10094572,
                '37' => 10439418,
                '38' => 10761102,
                '39' => 11057874,
                '40' => 11345179,
                '41' => 11607887,
                '42' => 11856539,
                '43' => 12097307,
                '44' => 12334596,
                '45' => 12564465,
                '46' => 12772833,
                '47' => 12967985,
                '48' => 13153971,
                '49' => 13336859,
                '50' => 13519489,
                '51' => 13693080,
                '52' => 13856023,
                '53' => 14008814,
                '54' => 14155758,
                '55' => 14297370,
                '56' => 14423363,
                '57' => 14539975,
                '58' => 14647855,
                '59' => 14747941,
                '60' => 14842261,
                '61' => 14926619,
                '62' => 15004114,
                '63' => 15074484,
                '64' => 15139021,
                '65' => 15199481,
                '66' => 15251898,
                '67' => 15298697,
                '68' => 15341883,
                '69' => 15373458,
                '70' => 15398829,
                '71' => 15420048,
                '72' => 15438132,
                '73' => 15451724,
                '74' => 15462612,
                '75' => 15471447,
                '76' => 15478377,
                '77' => 15483966,
                '78' => 15488215,
                '79' => 15491593,
            );

            $rand = mt_rand(0,15491592);
            foreach ($guest_age as $age => $ppl) {
                if ($rand < $ppl) {
                    return "$age";
                }
            }
    }

    /**
     * Gets a random age for a host robot
     */
    public function get_host_age() {
        $guest_age = array(
                    '18' => 16284,
                    '19' => 29943,
                    '20' => 33744,
                    '21' => 39659,
                    '22' => 48241,
                    '23' => 60627,
                    '24' => 77075,
                    '25' => 98376,
                    '26' => 122927,
                    '27' => 150619,
                    '28' => 179603,
                    '29' => 210244,
                    '30' => 241652,
                    '31' => 272752,
                    '32' => 303829,
                    '33' => 334199,
                    '34' => 363606,
                    '35' => 392824,
                    '36' => 419223,
                    '37' => 444123,
                    '38' => 468335,
                    '39' => 491289,
                    '40' => 513959,
                    '41' => 535474,
                    '42' => 556287,
                    '43' => 576821,
                    '44' => 597058,
                    '45' => 617169,
                    '46' => 635957,
                    '47' => 653866,
                    '48' => 671341,
                    '49' => 688653,
                    '50' => 706318,
                    '51' => 723645,
                    '52' => 740371,
                    '53' => 756406,
                    '54' => 772083,
                    '55' => 787354,
                    '56' => 801756,
                    '57' => 815404,
                    '58' => 828180,
                    '59' => 840294,
                    '60' => 851580,
                    '61' => 862110,
                    '62' => 872012,
                    '63' => 880943,
                    '64' => 889300,
                    '65' => 897106,
                    '66' => 903958,
                    '67' => 910060,
                    '68' => 915661,
                    '69' => 919823,
                    '70' => 923212,
                    '71' => 926081,
                    '72' => 928513,
                    '73' => 930411,
                    '74' => 931936,
                    '75' => 933185,
                    '76' => 934138,
                    '77' => 934903,
                    '78' => 935475,
                    '79' => 935966,
            );

            $rand = mt_rand(0,935965);
            foreach ($guest_age as $age => $ppl) {
                if ($rand < $ppl) {
                    return "$age";
                }
            }
    }


    /**
     * Returns Marital Status of the robot
     */
    public function get_marital_status($marital_status, $distance) {
        switch($distance) {
            case 'close':
                return $marital_status;
                break;
            case 'far':
                $vars = array('single', 'married');
                return array_pop(array_diff($vars, array($marital_status)));
                break;
        }
    }

    /**
     * Return Gender of the robot
     */
    public function get_gender($gender, $distance) {
        switch($distance) {
            case 'close':
                return $gender;
                break;
            case 'far':
                $vars = array('male', 'female');
                return array_pop(array_diff($vars, array($gender)));
                break;
        }
    }

    public function get_random_avatar($players) {
        $return = array();
        $loc = $this->config->item('basedir').$this->config->item('avatar_url');
        foreach (glob($loc."*.jpg") as $img) {
            if (!strpos('default', $img)) {
                $return[] = str_replace($this->config->item('basedir'), '', $img);
            }
	    $chosen=array_rand($return);
	    while(!strcmp($chosen, $players)){
	       $chosen= array_rand($return);
            }
        }
        return $return[$chosen];
    }

    /**
     * This Defines the various "Worlds" a Robot may exist in.
     * Insist On/Prioritize the Main 5 Worlds
     */
    public function get_world() {
        // If only the 5 Prioritized Worlds should be chose, use this function.
        //$rand_key = rand(0,4);
        //return array_keys($this->config->item('robot_worlds'))[$rand_key];

        // If any of the 8 Worlds should be chosen, use this function instead.
        return array_rand($this->config->item('robot_worlds'));
    }


    /**
     * This grabs a world different from the supplied world by 1 attribute.
     */
    public function get_other_world($world) {
        $worlds = $this->config->item('robot_worlds');
        $picked = $worlds[$world];
        $new_world = $picked;
        $w_attribute = array_rand($picked);
        $new_world[$w_attribute] = ($picked[$w_attribute] == 'high') ? 'low' : 'high';
        return $this->get_world_from_attributes($new_world);
    }


    /**
     * Determines the world based on the attributes given
     */
    private function get_world_from_attributes($world) {
        foreach ($this->config->item('robot_worlds') as $name => $vals) {
            if ( ($vals['rating'] == $world['rating']) and
                 ($vals['reviews'] == $world['reviews']) ){
		//and ($vals['member_since'] == $world['member_since']) ) {
                return $name;
            }
        }
    }

    /**
     * This returns rating for a given world
     */
    public function get_rating($world) {
        $hilo = $world['rating'];
        return $this->config->item('robot_attributes')['rating'][$hilo][array_rand($this->config->item('robot_attributes')['rating'][$hilo])];
    }

    /**
     * This returns reviews for a given world
     */
    public function get_reviews($world, $type, $seeds) {
        $hilo = $world['reviews'];
        if ($hilo == 'low') {
            $quartile = $seeds['reviews_low'];
        }
        else {
            $quartile = $seeds['reviews_high'];
        }

        if ($quartile == 'q4') {
            return $this->get_reviews_bounded($type, $seeds['reviews_seed']);
        } else {
            if ($type == 'guest') {
                return $this->get_guest_reviews($quartile);
            }
            else {
                return $this->get_host_reviews($quartile);
            }
        }
    }

    /**
     * Gets a review number based on airbnb type and a seeded value
     */
    public function get_reviews_bounded($type, $seed) {
        $threshold = 20;
        if ($type == 'guest') {
            $base = max(11, ($seed - $threshold));
            $ceil = min(50, ($seed + $threshold));
        }
        else {
            $base = max(11, ($seed - $threshold));
            $ceil = min(50, ($seed + $threshold));
        }
        $vars = range($base, $ceil);
        return array_mt_rand($vars);
    }


    /**
     * This returns member_since for a given world
     */
    public function get_member_since($world, $type, $seeds) {
        $hilo = $world['member_since'];
        if ($hilo == 'low') {
            $quartile = $seeds['member_since_low'];
        }
        else {
            $quartile = $seeds['member_since_high'];
        }
        if ($type == 'guest') {
            return $this->get_guest_member_since($quartile);
        }
        else {
            return $this->get_host_member_since($quartile);
        }
    }

    /**
     * This randomly determines the quartile for guest member since
     *
     * Quartile calculations created ahead of time based on Method 1:
     * https://en.wikipedia.org/wiki/Quartile
     *
     * Calculations based on supplied data:
     * Q1:  2014
     * Q2:  2014
     * Q3:  2015
     */
    public function get_guest_member_since($quartile) {
        $data = array(
            'q1' => array(
                '2008' => 1,
                '2009' => 2,
                '2010' => 5,
                '2011' => 9,
            ),
            'q2' => array(
                '2008' => 1,
                '2009' => 2,
                '2010' => 5,
                '2011' => 9,
            ),
            'q3' => array(
                '2014' => 1,
                '2015' => 3,
            ),
            'q4' => array(
                '2014' => 1,
                '2015' => 3,
            ),
        );

        $vals = $data[$quartile];
        $rand = mt_rand(1, max($vals));
        foreach ($vals as $year => $ppl) {
            if ($rand <= $ppl) {
                return $year;
            }
        }
    }

    /**
     * This randomly determines the quartile for host member since
     *
     * Quartile calculations created ahead of time based on Method 1:
     * https://en.wikipedia.org/wiki/Quartile
     *
     * Calculations based on supplied data:
     * Q1:  2013
     * Q2:  2014
     * Q3:  2015
     */
    public function get_host_member_since($quartile) {
        $data = array(
            'q1' => array(
                '2008' => '1',
                '2009' => '2',
                '2010' => '5',
                '2011' => '9',
            ),
            'q2' => array(
                '2008' => '1',
                '2009' => '2',
                '2010' => '5',
                '2011' => '9',
            ),
            'q3' => array(
                '2014' => 1,
                '2015' => 3,
            ),
            'q4' => array(
                '2014' => 1,
                '2015' => 3,
            ),
        );

        $vals = $data[$quartile];
        $rand = mt_rand(0, max($vals));
        foreach ($vals as $year => $ppl) {
            if ($rand <= $ppl) {
                return $year;
            }
        }
    }

    /**
     * This randomly determines the quartile reviews data for hosts
     *
     * Quartile calculations created ahead of time based on :
     * http://www.vias.org/tmdatanaleng/cc_quartile.html
     * using function :
     * http://forums.phpfreaks.com/topic/44573-quartiles-function/?p=216491
     *

     * Q1:  0
     * Q2:  2
     * Q3:  10
     */
    public function get_host_reviews($quartile) {
        $data = array(
            'q4' => array(
                '11' => '13046',
                '12' => '24876',
                '13' => '35776',
                '14' => '45590',
                '15' => '54619',
                '16' => '62801',
                '17' => '70507',
                '18' => '77449',
                '19' => '83607',
                '20' => '89706',
                '21' => '95260',
                '22' => '100614',
                '23' => '105499',
                '24' => '110087',
                '25' => '114276',
                '26' => '118407',
                '27' => '122171',
                '28' => '125893',
                '29' => '129484',
                '30' => '132723',
                '31' => '135849',
                '32' => '138790',
                '33' => '141533',
                '34' => '144148',
                '35' => '146748',
                '36' => '149109',
                '37' => '151394',
                '38' => '153603',
                '39' => '155752',
                '40' => '157793',
                '41' => '159757',
                '42' => '161570',
                '43' => '163361',
                '44' => '165093',
                '45' => '166821',
                '46' => '168397',
                '47' => '169918',
                '48' => '171354',
                '49' => '172786',
                '50' => '174113',
            ),
            'q3' => array(
                '2' => '2',
                '3' => '3',
            ),
            'q2' => array(
                '1' => '1',
            ),
            'q1' => array(
                '0' => 1,
            ),
        );

        $vals = $data[$quartile];
        $rand = mt_rand(0, max($vals));
        foreach ($vals as $year => $ppl) {
            if ($rand <= $ppl) {
                return $year;
            }
        }
    }

 /**
     * This randomly determines the quartile reviews data for guests
     *
     * Quartile calculations created ahead of time based on :
     * http://www.vias.org/tmdatanaleng/cc_quartile.html
     * using function :
     * http://forums.phpfreaks.com/topic/44573-quartiles-function/?p=216491
     *
     * Calculations based on supplied data:
     * Q1:  0
     * Q2:  0
     * Q3:  1
     */
    public function get_guest_reviews($quartile) {
        $data = array(
            'q4' => array(
                '11' => '13046',
                '12' => '24876',
                '13' => '35776',
                '14' => '45590',
                '15' => '54619',
                '16' => '62801',
                '17' => '70507',
                '18' => '77449',
                '19' => '83607',
                '20' => '89706',
                '21' => '95260',
                '22' => '100614',
                '23' => '105499',
                '24' => '110087',
                '25' => '114276',
                '26' => '118407',
                '27' => '122171',
                '28' => '125893',
                '29' => '129484',
                '30' => '132723',
                '31' => '135849',
                '32' => '138790',
                '33' => '141533',
                '34' => '144148',
                '35' => '146748',
                '36' => '149109',
                '37' => '151394',
                '38' => '153603',
                '39' => '155752',
                '40' => '157793',
                '41' => '159757',
                '42' => '161570',
                '43' => '163361',
                '44' => '165093',
                '45' => '166821',
                '46' => '168397',
                '47' => '169918',
                '48' => '171354',
                '49' => '172786',
                '50' => '174113',
            ),
            'q3' => array(
                '2' => '2',
                '3' => '3',
            ),
            'q2' => array(
                '1' => '1',
            ),
            'q1' => array(
                '0' => '1',
            ),
        );

        $vals = $data[$quartile];
        $rand = mt_rand(0, max($vals));
        foreach ($vals as $year => $ppl) {
            if ($rand <= $ppl) {
                return $year;
            }
        }
    }

    /**
     * Based on Purebell() function found here:
     * http://www.eboodevelopment.com/php-random-number-generator-with-normal-distribution-bell-curve/
     */
    private function purebell($min, $max, $std_deviation, $mean=null) {
        $high = $max;
        $low = $min;
        if (is_numeric($mean)) {
            $maxdiff = $max - $mean;
            $mindiff = $mean - $min;
            if ($maxdiff > $mindiff) {
                $min = $min - ($maxdiff - $mindiff);
            }
            elseif ($maxdiff < $mindiff) {
                $max = $max + ($mindiff - $maxdiff);
            }
        }

        $rand1 = (float)rand()/(float)getrandmax();
        $rand2 = (float)rand()/(float)getrandmax();
        $number = sqrt(-2 * log($rand1)) * cos(2 * M_PI * $rand2);
        $half = ($max - $min + 1) / 2;
        $middle = $min + $half - 1;
        $number = intval($middle + ($number * $half / $std_deviation));
        if ($number < $low || $number > $high) {
            $number = $this->purebell($low, $high, $std_deviation, $mean);
        }
        return intval($number);
    }

    /**
     * Constructs investement return array based on preseeded values
     */
    private function generate_investment_percentage() {
        $return_array = array();
        // 0 - 2 by 0.05 increments.
        $seed_vals = array(91, 36, 23, 33, 10, 15, 11, 19, 15, 10, 18, 17, 16, 16, 16, 8, 9, 11, 8, 4, 4, 0, 4, 3, 2, 4, 2, 3, 0, 3, 2, 2, 0, 3, 1, 5, 0, 0, 0, 1);
        foreach (range(0, 2, 0.05) as $i) {
            $count = array_shift($seed_vals);
            foreach (range(1,$count) as $j) {
                $return_array[] = $i;
            }
        }
        $key = array_mt_rand($return_array);
        return ($key/2);
    }
 }
