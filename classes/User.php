<?php

    namespace MerryPayout;

    use MerryPayout\exceptions\NotVerifiedUserException;
    use MerryPayout\exceptions\NotActivatedUserException;


    class User extends Queryable {

        private $userId; // String
        private $username; // String
        private $password; // String
        private $merger;
        private $errors = [
            "loginErrors" => [],
            "signUpErrors" => [],
            "forgetPasswordError" => []
        ];

        /**
         * User constructor.
         */
        public function __construct() {
            parent::__construct();
            $this->merger = new Merger();
            $this->username = isset($_SESSION['username']) ? $_SESSION['username'] : "";
            $this->userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : "";
//            $this->userId = 10;
        }

        public function logout() {
            $_SESSION['username'] = "";
            $_SESSION['userId'] = "";
        }

        /**
         * @param SignUpFormData $formData
         */
        public function create(SignUpFormData $formData) {
            try {
                if ($this->dm->userExists($formData->username)) {
                    array_push($this->errors["signUpErrors"], "The username already exists. Choose another");
                }
                elseif ($this->dm->emailExists($formData->email)) {
                    array_push($this->errors["signUpErrors"], "The email address is already in use.");
                }
                else {
                    try {
                        $this->dm->createUser($formData);

                        // Send the user an email message containing the token for verification
                        $userId = $this->dm->getUserId($formData->username);
                        $app = new App();
                        $app->sendVerificationToken($formData->email, $userId);
                    }
                    catch (\PDOException $e) {
                        array_push($this->errors["signUpErrors"], $e->getMessage());
                    }
                }
            }
            catch (\PDOException $e) {
                array_push($this->errors["signUpErrors"], $e->getMessage());
            }
        }


        /**
         * @param LoginFormData $formData
         * @throws NotActivatedUserException
         * @throws NotVerifiedUserException
         */
        public function login(LoginFormData $formData) {
            try {
                $userExists = $this->dm->isAUser($formData->username, $formData->password);
                if (!$userExists) {
                    array_push($this->errors["loginErrors"], "Username or password is incorrect");
                }
                else {
                    try {
                        $this->userId = $this->dm->getUserId($formData->username);
                        if (!$this->dm->isVerified($this->userId)) {
                            throw new NotVerifiedUserException("You have not verified your email. Please verify 
                        and try again");
                        }
                        elseif (!$this->dm->isActivated($this->userId)) {
                            throw new NotActivatedUserException("Your account has been disabled because you are not in compliance with our 
                            policy. If you 
            think you are seeing this page as an error, contact us");
                        }
                        else {
                            $_SESSION['userId'] = $this->userId;
                            $_SESSION['username'] = $formData->username;
                            $_SESSION['isLoggedIn'] = true;
                            $this->redirect("dashboard/index");
                        }
                    }
                    catch (\PDOException $e) {
                        array_push($this->errors["loginErrors"], $e->getMessage());
                    }
                }
            }
            catch (\PDOException $e) {
                array_push($this->errors["loginErrors"], $e->getMessage());
            }
        }


        public function hasPassedDeadline(): bool {
            return $this->dm->hasPassedDeadline($this->userId);
        }

        public function deactivate() {
            $this->dm->deactivateUser($this->userId);
        }

        public function isActivated(): bool {
            return $this->dm->isActivated($this->userId);
        }

        public function isAdmin(): bool {
            return $this->dm->isAdmin($this->userId);
        }

        /**
         * @return string
         */
        public function getUsername(): string {
            return $this->username;
        }

        /**
         * @param string $username
         */
        public function setUsername(string $username): void {
            $this->username = $username;

            return;
        }

        /**
         * @return string
         */
        public function getPassword(): string {
            return $this->password;
        }

        /**
         * @param string $password
         */
        public function setPassword(string $password): void {
            $this->password = $password;

            return;
        }

        /**
         * @return array
         */
        public function getErrors(): array {
            return $this->errors;
        }

        /**
         * Redirects the user to the given page
         * @param $page : string
         */
        protected function redirect($page) {
            header("Location:$page");
        }

        /**
         * Login authenticator
         * Checks the session variable `userId`
         * Sets the userId to the session variable if it is set. Redirects to the login page if otherwise.
         */
        public function checkAuth() {

            if (!isset($_SESSION['userId']) || $_SESSION['userId'] == '') {
                $this->redirect(APP_ROOT_DIR . 'signin');
            }

            else {
                $this->userId = $_SESSION['userId'];
                $this->username = $_SESSION['username'];

                if (!$this->isActivated()) {
                    $this->logout();
//                header("Location:deactivated");
                }
            }
        }

        /**
         * @return bool
         */
        public function isValidForPH() {
            return $this->dm->isValidForPH($this->userId);
        }

        public function isPayer() {
            return $this->dm->isPayer($this->userId);
        }

        public function isValidForGH() {
            return $this->dm->isValidForGH($this->userId);
        }

        public function getInfo() {
            return $this->dm->getCurrentInfo($this->userId);
        }

        public function getMessage() {
            return $this->dm->getMessage($this->userId);
        }

        public function getAllMessages() {
            return $this->dm->getReceiverMessages($this->userId);
        }

        public function getDetails() {
            return $this->dm->getUserDetails($this->userId);
        }

        public function userUpdate($bankName, $accName, $accNum, $phoneNum, $profPic = null) {
            $this->dm->userUpdate($this->userId, $bankName, $accName, $accNum, $phoneNum, $profPic);

        }


        public function changePassword($newPass) {
            $this->dm->userUpdatePassword($this->userId, $newPass);
        }

        public function comparePass($oldPass) {
            return $this->dm->checkPassword($this->userId, $oldPass);
        }


        public function receiverHasConfirmed() {
            return $this->dm->receiverHasConfirmed($this->userId);
        }


        /**
         * confirms a transaction as successful and marks it as a done deal in the database
         * @param $payerId
         */
        public function confirmPayment($payerId) {

            // Mark the transaction as a done deal
            $this->dm->confirmPayment($this->userId, $payerId);

            // Make this user a valid donor only if he has been paid by 2 people
            if ($this->hasBeenPaidByTwoPeople()) {
                $this->dm->resetAvailability($this->userId);
            }

            // make the payer available for getting help
            $this->dm->confirmPaymentMakeReceiver($payerId);

            // tell the payer that he will be merged shortly with a donor
            //$this->merger->informPayerToWait($payerId);
        }


        /**
         * Gets the count of all the times a user has been paid and checks if it is divisible by two
         * if yes, the user has been paid by two people at that particular point
         * @return bool
         */
        private function hasBeenPaidByTwoPeople(): bool {
            $confirmedPayersCount = $this->dm->getConfirmedPayersCount($this->userId);

            return $confirmedPayersCount % 2 == 0;
        }


        public function getReceiverDetails() {
            return $this->dm->getReceiverDetails($this->userId);
        }


        public function saveTellerImage($payeeId, $imgName) {

            $this->dm->saveTellerImage($this->userId, $payeeId, $imgName);

            $this->merger->sendPayerConfirmMsg($this->userId);
        }


        public function transactionIsOver($payerId) {
            return $this->dm->transactionIsOver($this->userId, $payerId);
        }

        /**
         * @return string
         */
        public function getUserId(): string {
            return $this->userId;
        }

        public function isReceiver() {
            return $this->dm->isReceiver($this->userId);
        }

        public function payerHasConfirmed($payerId) {
            return $this->dm->payerHasConfirmed($this->userId, $payerId);
        }

        public function getPayerDetails() {
            return $this->dm->getPayerDetails($this->userId);
        }

        public function makeDonor($planName) {
            $this->dm->makeDonor($this->userId, $planName);
        }

        public function getPayers() {
            return $this->dm->getAllPayers($this->userId);
        }

        public function deleteUnsuccessfulTransaction() {
            $this->dm->deleteUnsuccessfulTransaction($this->userId);
        }

        public function getWithdrawalHistory() {
            return $this->dm->getWithdrawalHistory($this->userId);
        }

        public function getDepositHistory() {
            return $this->dm->getDepositHistory($this->userId);
        }

        public function getAllHistory() {
            return $this->dm->getAllHistory($this->userId);
        }

        public function isSuperUser(): bool {
            return $this->dm->isSuperUser($this->userId);
        }

        public function receiveToken($payerId) {
            return $this->dm->getReceiveToken($this->userId, $payerId);
        }

        public function cancelTransaction() {
            $this->dm->cancelTransaction($this->userId);
        }

        public function unconfirmedPayers() {
            return $this->dm->getUnconfirmedPayers($this->userId);
        }

        public function getExpiry() {
            return $this->dm->getTransactionExpiry($this->userId);
        }

        public function confirmPayer($payerId, $amount) {
            $this->dm->confirmPayer($this->userId, $payerId, $amount);

            $this->dm->confirmPaymentMakeReceiver($payerId);
        }

        public function getAmount($payerId) {
            return $this->dm->getAmount($this->userId, $payerId);
        }

        public function collectAmount($payerId, $amount) {
            $this->dm->updateCollected($this->userId, $amount);
        }

        public function getTotalReturn() {
            return $this->dm->getTotalReturn($this->userId);
        }

        public function getTotalInvestment() {
            return $this->dm->getTotalInvestment($this->userId);
        }

        public function confirmReceiver($receiverId, $imgName, $amount) {

            $this->dm->confirmReceiver($this->userId, $receiverId, $imgName, $amount);
            $sendPayerConfirmMsg = new Merger();
            $sendPayerConfirmMsg->sendPayerConfirmMsg($this->userId);

        }

        public function getPayerAmount($receiverId) {
            return $this->dm->getPayerAmount($this->userId, $receiverId);
        }

        public function isValidForCollectingAccumulation() {
            $donationCount = $this->dm->getDonationCount($this->userId);
            return $donationCount >= 5 and $donationCount % 5 == 0;
        }

        public function getRank()
        {
            $count =  $this->dm->getDonationCount($this->userId);
            return $rank = floor($count / 5);
        }
        public function getAccumulatedEarnings() {
            return $this->dm->getAccumulatedEarnings($this->userId);
        }

        public function resetAccumulatedEarnings() {
            $this->dm->resetAccumulatedEarnings($this->userId);
        }

        public function isInList() {
            return $this->dm->listContainsAndPending($this->userId);
        }

        public function addToList($userId, $amount, $withBonus = true) {
            if (!$this->dm->isPayer($userId) and !$this->dm->isReceiver($userId) and !$this->dm->listContainsAndPending($userId)) {
                $this->dm->adminAddToList($userId, $amount, $withBonus);
            }
        }

    }
