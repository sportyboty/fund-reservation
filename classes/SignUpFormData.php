<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2/13/2017
 * Time: 9:29 AM
 */

namespace MerryPayout;


class SignUpFormData {

    public $username;
    public $password;
    public $email;
    public $accName;
    public $bankName;
    public $accNum;
    public $phoneNum;
    public $refId;
    //public $profPic;

    public function __construct(string $username, string $password,string $email, string $bankName, $accNum,
                                string $accName, $phoneNum, int $refId = 0) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->bankName = $bankName;
        $this->accName = $accName;
        $this->accNum = $accNum;
        $this->phoneNum = $phoneNum;
        //$this->profPic = $profPic;
        $this->refId = $refId;
    }

    /**
     * @param int $refId
     */
    public function setRefId(int $refId) {
        $this->refId = $refId;
    }
}