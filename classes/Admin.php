<?php

    namespace MerryPayout;

    use MerryPayout\exceptions\MerryPayoutUserException;

    require_once "config.php";

    class Admin extends User {

        private $merger;

        public function __construct() {
            parent::__construct();
            $this->merger = new Merger();
        }

        public function checkAuth() {
            parent::checkAuth();
            if (!$this->isAdmin()) {
                $this->redirect(APP_ROOT_DIR . '404');
            }
        }

        public function mergeAllUsers() {
            $this->merger->mergeAllUsers();
        }


        public function mergeUsers(int $receiverId, int $payerId) {
            try {
                $this->merger->merge($payerId, $receiverId);
            }
            catch (MerryPayoutUserException $e) {
                throw new MerryPayoutUserException($e->getMessage(), $e->getCulpritId());
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function getAllUsers() {
            return $this->dm->getAllUsers();
        }

        public function getUserDetails($userId) {
            return $this->dm->getUserDetails($userId);
        }

        public function editUser(AdminEditForm $formData) {
            $this->dm->adminEditUser($formData);
        }

        public function searchUserByUsername(string $username) {
            return $this->dm->searchUserByUsername($username);
        }

        public function getActiveUsersEmail() {
            return $this->dm->getAllActiveUserEmail();
        }

        public function getEmails() {
            return $this->dm->getUserEmail();
        }

        public function getInActiveUsersEmail() {
            return $this->dm->getAllInActiveUserEmail();
        }

        public function getUsersInList() {
            return $this->dm->getListUsers();
        }

        public function releaseNewList() {
            $this->dm->releaseNewList();
        }

        public function addToList($userId, $amount, $withBonus = true) {
            if (!$this->dm->isPayer($userId) and !$this->dm->isReceiver($userId) and !$this->dm->listContainsAndPending($userId)) {
                return $this->dm->adminAddToList($userId, $amount, $withBonus);
            }
        }
    }