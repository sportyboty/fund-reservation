<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/17/2017
 * Time: 12:27 AM
 */

namespace MerryPayout;


class EditFormData {

    public $username;
    public $password;
    public $email;
    public $accName;
    public $bankName;
    public $accNum;
    public $phoneNum;
    public $profPic;

    public function __construct(string $username, string $password,string $email, string $bankName, $accNum,
                                string $accName, $phoneNum, $profPic) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->bankName = $bankName;
        $this->accName = $accName;
        $this->accNum = $accNum;
        $this->phoneNum = $phoneNum;
        $this->profPic = $profPic;
    }
}