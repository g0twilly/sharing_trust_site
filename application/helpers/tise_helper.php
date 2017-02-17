<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('i18n')) {
    /**
     * Uses CI lang() helper with optional string replacement and array of strings replacement
     */
    function i18n($name, $str='') {
        if (is_array($str)) {
            return vsprintf( lang($name), $str);
        }
        return sprintf( lang($name), $str);
    }
}
    /**
     * Returns the opposite of the given role
     */
    function role_toggle($role) {
        return ($role == 'recipient') ? 'investor' : 'recipient';
    }

    /**
     * Determines if the user is a developer
     */
    function is_devel($id) {
        if (in_array($id, array('1', '14', '44'))) {
            return true;
        }
        return false;
    }

    /**
     * Generates a fairly simplistic key for verifying game player requests
     */
    function get_key($id, $email) {
        return md5($id.$email);
    }

    /**
     * A very brief delay [copied for expediency]
     */
    function get_brief_delay($very=false) {
        $delay = ($very) ? '1' : config_item('brief_delay');
        sleep($delay);
        return true;
    }

    /**
     * Checks if it's a day we send reminder emails
     */
    function reminder_check() {
        $phase = config_item('phase');

        $reminder_array = array(
            '1' => 'first',
            '2' => 'second',
            '3' => 'third',
            '4' => 'fourth',
            '5' => 'fifth',
            '6' => 'sixth',
            '7' => 'seventh',
            '8' => 'eighth',
            '9' => 'ninth');

        if ($phase > 1) {
            $start_date = strtotime(config_item('start_phase_'.$phase));
            foreach ($reminder_array as $num => $name) {
                if (is_numeric(config_item('reminder_'.$num))) {
                    $$name =  date('Ymd', strtotime("+ ".config_item('reminder_'.$num).' days', $start_date));
                }
            }
            $today  = date('Ymd');

            foreach ($reminder_array as $name) {
                if (isset($$name) and $today == $$name) {
                    return $name;
                }
            }
        }
        return false;
    }

    /**
     * Takes a pretty formatted phone number and strips it of all but numbers
     */
    function clean_phone_number($number) {
        return preg_replace("/[^\d]/", '', $number);
    }

    /**
     * Determines if signups are currently allowed.
     * @return bool
     */
    function can_signup() {
        // Users must have a token to sign up.
        return false;
        $phase = config_item('phase');
        return ($phase === '1');
    }

    /**
     * Fancy Random array_rand()
     */
    function array_mt_rand( Array $array ){
        $count = count( $array ) ;
        if (!$count) {
            return null;
        }
        $key = mt_rand(0, ($count - 1));
        return $array[$key] ;
    }