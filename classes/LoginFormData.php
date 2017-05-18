<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/13/2017
 * Time: 9:31 AM
 */

namespace MerryPayout;


class LoginFormData {

    public $username;
    public $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }
}