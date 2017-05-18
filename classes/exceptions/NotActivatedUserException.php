<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/15/2017
 * Time: 10:45 PM
 */

namespace MerryPayout\exceptions;



class NotActivatedUserException extends \Exception {

    public function __construct($message, $code = null, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}