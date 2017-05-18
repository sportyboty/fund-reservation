<?php
    /**
     * Created by PhpStorm.
     * User: User
     * Date: 3/11/2017
     * Time: 3:11 PM
     */

    namespace MerryPayout;


    class Referrer extends User {

        private $id;
        protected $dm;

        public function __construct($userId) {
            $this->id = $userId;
            $this->dm = new DataManager();
        }

        public function addBonus()
        {
            $this->dm->addBonus($this->id);
        }

        public function getAllReferred()
        {
            return $this->dm->getAllReferred($this->id);
        }

        public function getAllActiveReferred()
        {
            return $this->dm->getAllReferred($this->id);
        }

        public function refBonus()
        {
            return $this->dm->refBonus($this->id);
        }

        public function getAllReferredByName()
        {
            return $this->dm->referredUsers($this->id);
        }

        public function getAllActiveReferralsCount()
        {
            return $this->dm->getAllActiveReferralsCount($this->id);
        }

    }