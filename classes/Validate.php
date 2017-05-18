<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 12/9/2016
 * Time: 7:08 AM
 */

namespace MerryPayout;

require_once "config.php";

/**
 * Class Validate
 * @package KikShare
 * @author Asiegbu Stanley
 * @Description : This class is for universal validation of data for all classes that require input/output validation
 */

class Validate {

    /**
     * @param $email
     * @return mixed
     */
    static public function Email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * String validator function
     * @param $string
     * @return bool
     */
    static public function String($string) {
        $safeString = strip_tags($string);
        if (preg_match("/[^a-zA-Z0-9|_|.|(|)|-|!|\s]+/", $string) || preg_match('/^_$/', $string)) {
            return false;
        }
        else {
            if ($string != $safeString || trim($string) == '') {
                return false;
            }
            else {
                return true;
            }
        }
    }

    /**
     * Password validator
     * @param $password
     * @return bool
     */
    static public function Password($password) {
        if (trim($password) == '' || mb_strlen(trim($password)) < VALID_PASSWORD_MIN_LENGTH) {
            return false;
        }
        return true;
    }

    public static function Number($number) {
        return is_numeric($number);
    }

    public static function AccountNumber($number) {
        return trim($number != '') && mb_strlen($number) == 10;
    }

    public static function PhoneNumber($number) {
        return trim($number != '') && mb_strlen($number) == 11;
    }
    /**
     * Audio validator
     * @param $file
     * @return bool
     */
    static public function Audio($file) {
        $supported_audio_types = array("audio/mp3", "audio/wav", "audio/mp4");
        return (in_array($file['type'], $supported_audio_types)) ? true : false;
    }

    /**
     * Image validator
     * @param $file
     * @return bool
     */
    static public function Image($file) {
        $supported_img_types = array("image/jpeg", "image/png", "image/gif");
        return (in_array($file['type'], $supported_img_types)) ? true : false;
    }

}