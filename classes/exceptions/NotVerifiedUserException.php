<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/14/2017
 * Time: 2:25 PM
 */
namespace MerryPayout\exceptions;

class NotVerifiedUserException extends \Exception {

    public function __construct($message, $code = null, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}