<?php
    /**
     * Created by PhpStorm.
     * User: User
     * Date: 2/17/2017
     * Time: 12:27 AM
     */

    namespace MerryPayout;


    class AdminEditForm {

        public $userId;
        public $username;
        public $password;
        public $email;
        public $accName;
        public $bankName;
        public $accNum;
        public $phoneNum;
        public $activated;
        public $validDonor;
        public $valid_receiver;

        public function __construct($userId, string $username, string $password, string $email, string $bankName,
                                    $accName, string $accNum, $phoneNum, $activated, $validDonor, $valid_receiver) {
            $this->userId = $userId;
            $this->username = $username;
            $this->password = $password;
            $this->email = $email;
            $this->bankName = $bankName;
            $this->accName = $accName;
            $this->accNum = $accNum;
            $this->phoneNum = $phoneNum;
            $this->activated = $activated;
            $this->validDonor = $validDonor;
            $this->valid_receiver = $valid_receiver;
        }
    }