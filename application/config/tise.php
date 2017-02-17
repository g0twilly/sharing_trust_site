<?php
/**
 * CONFIGURATION OPTIONS
 */

// Site Variables

// email
// This is the address emails are sent From/Replied To.
$config['email'] = 'airbnb_stanford@stanford.edu';
$config['contact_email'] = 'airbnb_stanford@stanford.edu';

// Whitelisted IP addresses
$config['whitelisted_ips'] = array(
	'171.66.221.130',
	'171.66.209.4',
	'76.21.8.197',
	'171.66.208.10',
	'169.229.121.63',
);

// URLs to external Survey pages to be linked at the end of the Phase 
$config['phase_1_postgame_survey_url'] = 'https://stanforduniversity.qualtrics.com/SE/?SID=SV_d5PefSHHg1kgbBj&token=';
$config['phase_2_postgame_survey_url'] = 'https://stanforduniversity.qualtrics.com/SE/?SID=SV_e3F0hQ8y3JWTH6Z&info=';


/** 
 * User Idleness check for Login
 *
 * This setting defines how long a user can have between their last action and a new login.
 * Currently set to 30 minutes, meaning a user who performed an action, then left for more
 * than a half-hour will be marked as ineligible, and will no longer be allowed to log in.
 * This may require updated functionality for upcoming phases
 * 30 minutes in seconds = 1800
 */

$config['idleness_check']   = '1800';

// Game Variables
$config['study']            = '2016_April';    // The current Study [must be unique!]
$config['phase']            = '1';              // Current game phase. Either 1 or 2
$config['credits']          = '100';            // Starting Sum (Credits)
$config['multiplier']       = '3';              // Multiplier for the Game



/**
 * Site Activities Key:
 * Sign Up / User Information - automatically first if not logged in
 * 'survey_airbnb'      - User questions about Airbnb interactions [Automatically skipped in Phase 1]
 * 'risk'               - The First risk question
 * 'risk2'              - The Second risk question
 * 'game_overview'      - Provides instructions for game play
 * 'game_play'          - The Exchange Game
 * 'game_results'       - The Will You Come Back Page [Automatically skipped in Phase 2]
 * 'survey_postgame'    - The Post Game Trust questions [Automatically skipped in Phase 1]
 * 'phase_complete'     - End of the Phase / Come Back message.
 */


if ($config['phase'] == '1'){
	$config['order'] = array(
	    '2' => 'risk2',
	    '3' => 'game_overview',
	    '4' => 'game_play',
	    '5' => 'survey_postgame',
	    '6' => 'game_results',
	    '7' => 'phase_complete',
	);
}else{
	// Order of Site Activities
	$config['order'] = array(
	    '1' => 'phase_2',
	    '2' => 'survey_airbnb',
	    '3' => 'game_overview',
	    '4' => 'game_play',
	    '5' => 'survey_postgame',
	//    '6' => 'game_results',
	    '7' => 'phase_complete',
	);
}


// This should be an array with Group 1 and Group 2 [Group 2 skips the game in Phase 1]
// The account creation will randomly choose from the array, so to make Group 2 a 10%, 
// there should be 9 "1"s and 1 "2"s.
// How the array is generated is not important, but is shown in long form here for clarity.
//$config['grouping_probabilities'] = array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2);
$config['grouping_probabilities'] = array_merge( array_fill(0, 99, 1),array(1 => 1));

// Age Boundary. How close to my age must a close user be ?
$config['age_boundary'] = '7'; // in years + or -


/**
 * This defines the attributes being used to determine distance scores for a user/robot
 */
$config['attributes'] = array('gender', 'marital_status', 'location', 'age');

/**
 * This defines the number of robots to be matched with
 */
$config['robot_count'] = '5';

/**
 * This configuration establishes the various worlds for the robots
 */
$config['robot_worlds'] = array(
    'LL'     => array('rating' => 'low', 'reviews' => 'low'),
    'LH'     => array('rating' => 'low', 'reviews' => 'high'),
    'HL'     => array('rating' => 'high','reviews' => 'low'),
    'HH'     => array('rating' => 'high','reviews' => 'high'),
);

/**
 * This configuration defines the average values for robot attributes.
 * "high" and "low" require range arrays [even on single values]
 */
$config['robot_attributes'] = array(
    'rating' => array(
        'low'   => range(4,4),
        'high'  => range(5,5),
    ),
    'reviews_guest' => array(
        'low'   => range(0,1),
        'high'  => range(1,3),
    ),
    'reviews_host' => array(
        'low'   => range(0,6),
        'high'  => range(6,20),
    ),
    'member_since' => array(
        'low'   => range(2013,2015),
        'high'  => range(2008,2013),
    ),
    'interactions_guest' => array(
        'low'   => range(0,1),
        'high'  => range(1,5),
    ),
    'interactions_host' => array(
        'low'   => range(0,6),
        'high'  => range(6,30),
    ),
);


// Phase Start Dates
$config['start_phase_2'] = 'Oct 1, 2015';  // this year will be changed to 2014

// Email Reminder Times (in days)
//$config['reminder_1'] = '999'; // start + 999 days (code for OFF, remember to FIX)
//$config['reminder_2'] = '999'; // start + 999 days (code for OFF, remember to FIX)
//$config['reminder_3'] = '999'; // start + 999 days (code for OFF, remember to FIX)
//$config['reminder_4'] = '999'; // start + 999 days (code for OFF, remember to FIX)

/**
 * SYSTEM VARIABLES
 *
 * THESE VALUES SHOULD NOT BE CHANGED!
 */

// System Variables
$config['basedir']       = '/var/www/sharing_airbnb/public';

// Avatar directory [Trailing Slash!]
$config['avatar_url']       = '/img/avatars/neutral/';
$config['avatar_default']   = 'default_avatar.png';

// Routes used for "next step" functionality

if ($config['phase'] == '1'){
	$config['step_routes'] = array(
	    'risk2'           => '/risk2',
	    'game_overview'   => '/game/overview',
	    'game_play'       => '/game/play',
	    'survey_postgame' => '/survey/postgame',
	    'game_results'    => '/game/results',
            'play_complete'   => '/game/complete',
	//    'phase_complete'  => '/complete',
        );
}else{
	$config['step_routes'] = array(
	    'phase_2'   => '/survey/phase_2',
	    'survey_airbnb'   => '/survey/airbnb',
	    'game_overview'   => '/game/overview',
	    'game_play'       => '/game/play',
	    'survey_postgame' => '/survey/postgame',
	    'game_results'    => '/game/results',
	    'play_complete'   => '/game/complete',
	    'phase_complete'  => '/complete',
        );
}
