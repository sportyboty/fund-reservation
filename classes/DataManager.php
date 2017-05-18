<?php

    namespace MerryPayout;

    require_once "Db.php";

    /**
     * Class DataManager
     * @package KikShare
     * Description: This class handles every query to the databases
     */
    class DataManager {

        public $handle;

        /**
         * DataManager constructor.
         */
        public function __construct() {
            $db = new DbManager();
            $this->handle = $db->getHandle();
        }

        /**
         * @param $username
         * @return bool
         */
        public function userExists(string $username) {
            $query = <<<SQL
        SELECT * FROM users WHERE username = :username
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                $count = $stmt->rowCount();

                return ($count > 0) ? true : false;
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred." . $e->getMessage());
            }
        }

        /**
         * @param string $email
         * @return bool
         */
        public function emailExists(string $email) {
            $query = <<<SQL
          SELECT COUNT(*) FROM users WHERE email = :email
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN) != 0;
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. Please try again or contact us for help" . $e->getMessage());
            }

        }

        /**
         * @param $userId
         * @return bool
         */
        public function isRegisteredUser($userId) {
            $sql = <<<SQL
          SELECT id FROM users WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $count = $stmt->rowCount();

                return $count == 1;

            }
            catch (\PDOException $e) {
                return false;
            }
        }

        public function verifyToken($userId, $token) {
            $sql = <<<SQL
            
            SELECT v_token FROM users WHERE id = :userId AND v_token = :token
#               SELECT COUNT(*) FROM users WHERE id = :userId AND v_token = :token
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->bindParam(':token', $token);
                $stmt->execute();
                $count = $stmt->rowCount();

                return $count == 1;
            }
            catch (\PDOException $e) {
                return false;
            }
        }

        /**
         * @param $userId
         */
        public function activateUser($userId) {
            $sql = <<<SQL
              UPDATE users SET activated = 1 , email_verified = 1 WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        /**
         * @param $userId
         */
        public function deleteToken($userId) {
            $sql = <<<SQL
              UPDATE users SET v_token = NULL WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        /**
         * @param $username
         * @param $password
         * @return bool
         */
        public function isAUser($username, $password) {
            $query = <<<SQL
            SELECT password FROM users WHERE username = :username
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                $storedPasswordHash = $stmt->fetch(\PDO::FETCH_COLUMN);

                return password_verify($password, $storedPasswordHash);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred while logging in your account. Please try again later or 
            contact us for help");
            }
        }

        /**
         * @param $userId
         * @return bool
         * @throws \PDOException
         */
        public function isVerified($userId) {
            $query = <<<SQL
            SELECT email_verified FROM users WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $isVerified = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $isVerified == 1;
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. Please try again later or contact us for help");
            }
        }


        /**
         * @param $username
         * @return int
         */
        public function getUserId($username) {
            $query = <<<SQL
            SELECT id FROM users WHERE username = :username
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                $id = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $id;
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred while logging in your account. Please try again later or 
            contact us for help");
            }
        }

        public function getUsername($userId) {
            $query = <<<SQL
            SELECT username FROM users WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN);

            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred while logging in your account. Please try again later or 
            contact us for help");
            }
        }

        /**
         * @param $username
         * @return void
         */
        public function deleteUser($username) {
            $query = <<<SQL
        DELETE FROM users WHERE username = :username
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                echo "An error occurred";
                echo $e->getMessage();
                exit();
            }
        }

        /**
         * @param SignUpFormData $formData
         * @throws \PDOException
         */
        public function createUser(SignUpFormData $formData) {
            $dateCreated = new \DateTime(date('d-m-Y'));
            $dateJoined = $dateCreated->format('d-m-Y');
            $activated = 0;
            $validForGH = 0;
            $validForPH = 1;
            $emailVerified = 0;
            $role = "user";
            $password = password_hash($formData->password, PASSWORD_BCRYPT);
            $query = <<<SQL
                    INSERT INTO users
                    (username, password, email, bankName, accName, accNum, phoneNum, activated, valid_for_ph, 
                    valid_for_gh, email_verified, date_joined, role, ref_id, prof_pic)
                    VALUES
                    (:username,:password, :email, :bankName, :accName, :accNum, :phoneNum, :activated, :validForPH, 
                    :validForGH, :emailVerified, :dateJoined , :role, :refId, :profPic)
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':username', $formData->username);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':email', $formData->email);
                $stmt->bindParam(':bankName', $formData->bankName);
                $stmt->bindParam(':accName', $formData->accName);
                $stmt->bindParam(':accNum', $formData->accNum);
                $stmt->bindParam(':phoneNum', $formData->phoneNum);
                $stmt->bindParam(':dateJoined', $dateJoined);
                $stmt->bindParam(':validForGH', $validForGH);
                $stmt->bindParam(':validForPH', $validForPH);
                $stmt->bindParam(':activated', $activated);
                $stmt->bindParam(':emailVerified', $emailVerified);
                $stmt->bindParam(':role', $role);
                $stmt->bindParam(':profPic', $formData->profPic);
                $stmt->bindParam(':refId', $formData->refId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred, try again later" . $e->getMessage());
            }
        }

        /**
         * @param $receiverId
         * @param $payerId
         * @param $amount
         * @param $msgToReceiver
         * @param $msgToPayer
         * @param $date
         * @param $expiry
         * @param $receiverConfirmationToken
         */
        public function mergeUsers($receiverId, $payerId, $amount, $msgToReceiver, $msgToPayer, $date, $expiry,
                                   $receiverConfirmationToken) {
            $query = <<<SQL
          INSERT INTO merge (receiver_id, payer_id, amount, receiver_msg, payer_msg, date, expiry_date, expiry_msql, 
          receiver_confirmation_token) 
          VALUES 
          (:receiverId, 
          :payerId, :amount, :receiverMsg, :payerMsg, :date_of_transaction, :expiry, CURDATE() + INTERVAL 24 HOUR , 
          :receiverConfirmationToken)
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->bindParam(':amount', $amount);
                $stmt->bindParam(':receiverMsg', $msgToReceiver);
                $stmt->bindParam(':payerMsg', $msgToPayer);
                $stmt->bindParam(':date_of_transaction', $date);
                $stmt->bindParam(':expiry', $expiry);
                $stmt->bindParam(':receiverConfirmationToken', $receiverConfirmationToken);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred while merging the users. " . $e->getMessage());
            }

            $sql = <<<SQL
          UPDATE users SET valid_for_ph = 0 WHERE id = :payerId
SQL;
            try {
                $stmt2 = $this->handle->prepare($sql);
                $stmt2->bindParam(':payerId', $payerId);
                $stmt2->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred while making the payer unavailable to give help");
            }
        }

        /**
         * @param $receiverId
         * @param $payerId
         */
        public function confirmPayment($receiverId, $payerId) {
            $query = <<<SQL
          UPDATE merge SET confirm_status = 1 WHERE payer_id = :payerId AND receiver_id = :receiverId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        /**
         * @param $receiverId
         */
        public function confirmPaymentMakeDonor($receiverId) {
            // make the receiver valid for providing help and not valid for getting help
            $query = <<<SQL
          UPDATE users SET valid_for_ph = 1, valid_for_gh = 0 WHERE id = :receiverId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        /**
         * @param $payerId
         */
        public function confirmPaymentMakeReceiver($payerId) {
            // make the payer valid for getting help and not valid for providing help
            $query = <<<SQL
          UPDATE users SET valid_for_ph = 0, valid_for_gh = 1 WHERE id = :payerId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        /**
         * @param $receiverId
         * @return mixed
         */
        public function getPayersCount($receiverId) {
            $query = <<<SQL
          SELECT COUNT(*) FROM merge WHERE receiver_id = :receiverId AND confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->execute();
                $count = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $count;
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function getConfirmedPayersCount($receiverId) {
            $query = <<<SQL
          SELECT COUNT(*) FROM merge WHERE receiver_id = :receiverId AND confirm_status = 1
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->execute();
                $count = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $count;
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        /**
         * @param $userId
         * @return bool
         */
        public function isValidForPH($userId) {
            $query = <<<SQL
          SELECT valid_for_ph FROM users WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $valid = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $valid == 1;
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }

        }

        /**
         * @param $userId
         * @return bool
         */
        public function isPayer($userId) {
            $query = <<<SQL
          SELECT COUNT(*) FROM merge WHERE payer_id = :userId AND confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $count = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $count > 0;
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        /**
         * @param $userId
         * @return bool
         */
        public function isReceiver($userId) {
            $query = <<<SQL
          SELECT COUNT(*) FROM merge WHERE receiver_id = :userId AND confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $count = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $count > 0;
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        /**
         * @param $userId
         * @return bool
         */
        public function isValidForGH($userId) {
            $query = <<<SQL
          SELECT valid_for_gh FROM users WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $valid = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $valid == 1;
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }

        }


        /**
         * @return array
         */
        public function getAllUsers() {
            $query = <<<SQL
          SELECT id, username , email, bankName , accName ,accNum, phoneNum, valid_for_ph, valid_for_gh, activated,current_plan 
          FROM 
          users
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        /**
         * @param $userId
         * @return mixed
         */
        public function getUserDetails($userId) {
            $query = <<<SQL
            SELECT id, username , prof_pic, email, bankName , accName ,accNum, phoneNum, activated, valid_for_ph, 
            valid_for_gh, current_plan 
            FROM users WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred while logging in your account. Please try again later or 
            contact us for help " . $e->getMessage());
            }
        }

        /**
         * @param $userId
         * @return bool
         */
        public function isAdmin($userId) {
            $query = <<<SQL
            SELECT role FROM users WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $role = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $role == "admin";
            }
            catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }

        /**
         * @param $userId
         * @return mixed
         */
        public function getUserPlan($userId) {
            $query = <<<SQL
            SELECT current_plan FROM users WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $plan = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $plan;
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }

        }

        /**
         * @param $userId
         * @param $bankName
         * @param $accName
         * @param $accNum
         * @param $phoneNum
         * @param $profPic
         * @return bool
         */
        public function userUpdate($userId, $bankName, $accName, $accNum, $phoneNum, $profPic) {
            $query = <<<SQL
        UPDATE users SET bankName = :bankName , accName = :accName , accNum = :accNum, phoneNum  = :phoneNum 
SQL;
            if ($profPic != null) {
                $query .= ", prof_pic = :profilePic";
            }

            $query .= " WHERE id = :userId";

            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':bankName', $bankName);
                $stmt->bindParam(':accName', $accName);
                $stmt->bindParam(':accNum', $accNum);
                $stmt->bindParam(':phoneNum', $phoneNum);
                $stmt->bindParam(':userId', $userId);
                if ($profPic != null) {
                    $stmt->bindParam(':profilePic', $profPic);
                }

                return $stmt->execute();
            }
            catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }


        /**
         * @param $userId
         * @param $password
         * @return bool
         */
        public function checkPassword($userId, $password) {
            $query = <<<SQL
            SELECT password FROM users WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $hashPassword = $stmt->fetch(\PDO::FETCH_COLUMN);
                $verify = password_verify($password, $hashPassword);

                return $verify;

            }
            catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }

        /**
         * @param $userId
         * @param $password
         * @return bool
         */
        public function userUpdatePassword($userId, $password): bool {
            $password = password_hash($password, PASSWORD_BCRYPT);

            $query = <<<SQL
            UPDATE users SET password = :password WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':userId', $userId);

                return $stmt->execute();
            }
            catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }

        /**
         * @param $userId
         * @return bool
         */
        public function isActivated($userId): bool {
            $query = <<<SQL
          SELECT activated FROM users WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $activated = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $activated == 1;
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. Please try again later or contact us for help");
            }
        }

        /**
         * @param string $plan
         * @return array
         */
        public function getValidDonors(string $plan): array {
            $query = <<<SQL
          SELECT username, id FROM users WHERE valid_for_ph = 1 AND current_plan = :plan
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':plan', $plan);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        /**
         * @param string $plan
         * @return array
         */
        public function getTwoValidDonors(string $plan): array {
            $query = <<<SQL
          SELECT username, id FROM users WHERE valid_for_ph = 1 AND current_plan = :plan AND users.activated = 1 LIMIT 2
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':plan', $plan);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        /**
         * @param string $plan
         * @return array
         */
        public function getValidReceivers(string $plan): array {
            $query = <<<SQL
          SELECT username, id FROM users WHERE valid_for_gh = 1 AND current_plan = :plan
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':plan', $plan);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        /**
         * @param $userId
         * @return int
         */
        public function getReferralBonus($userId) {
            $query = <<<SQL
            SELECT bonus FROM users WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }


        /**
         * @param $userId
         * @return mixed
         */
        public function getMessage($userId) {
            $query = <<<SQL
            SELECT payer_msg FROM merge WHERE payer_id = :payerId AND confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':payerId', $userId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        /**
         * @param $userId
         * @return array
         */
        public function getReceiverMessages($userId) {
            $query = <<<SQL
            SELECT receiver_msg FROM merge WHERE receiver_id = :receiverId AND confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':receiverId', $userId);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        /**
         * @param $userId
         * @return bool
         */
        public function hasPassedDeadline($userId): bool {
            $query = <<<SQL
          SELECT expiry_date FROM merge WHERE payer_id = :payerId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':payerId', $userId);
                $stmt->execute();

                return time() > $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());

            }
        }

        /**
         * @param $payerId
         */
        public function deleteUnsuccessfulTransaction($payerId) {
            $query = <<<SQL
          DELETE FROM merge WHERE payer_id = :payerId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());

            }
        }

        /**
         * @param $userId
         */
        public function deactivateUser($userId) {
            $query = <<<SQL
            UPDATE users SET activated = 0 WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($query);;
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }

        /**
         * @param $payerId
         * @return mixed
         */
        public function getReceiverDetails($payerId) {
            $query = <<<SQL
          SELECT users.id, username, accName,bankName, accNum, phoneNum FROM users INNER JOIN merge ON merge
          .receiver_id = users.id WHERE merge.payer_id = :payerId AND confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function getReceiverD($payerId) {
            $query = <<<SQL
          SELECT receiver_id FROM merge WHERE payer_id = :payerId AND confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        /**
         * @param $receiverId
         * @return array
         */
        public function getAllPayers($receiverId) {
            $query = <<<SQL
          SELECT merge.id, username, teller_img, accName, accNum, phoneNum FROM users INNER JOIN merge ON merge
          .payer_id = users.id WHERE merge.receiver_id = :receiverId AND confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function getUnconfirmedPayers($receiverId) {
            $query = <<<SQL
          SELECT users.id, username, teller_img, accName, accNum, phoneNum FROM users INNER JOIN merge ON merge.payer_id = users.id WHERE merge.receiver_id = :receiverId
AND merge.confirm_status = 0 AND merge.payer_confirmation = 1;
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);


            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }

        }

        /**
         * @param $payerId
         * @param $payeeId
         * @param $imgName
         */
        public function saveTellerImage($payerId, $payeeId, $imgName) {
            $sql = <<<SQL
          UPDATE merge SET teller_img = :tellerImg , payer_confirmation = 1 WHERE payer_id = :payerId AND receiver_id
           = :receiverId AND confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':tellerImg', $imgName);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->bindParam(':receiverId', $payeeId);
                $stmt->execute();

            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        /**
         * @param $receiverId
         * @param $payerId
         * @return bool
         */
        public function payerHasConfirmed($receiverId, $payerId) {
            $query = <<<SQL
          SELECT payer_confirmation FROM merge WHERE receiver_id = :receiverId AND payer_id = :payerId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN) == 1;
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        /**
         * @param $receiverId
         * @return mixed
         */
        public function getPayerDetails($receiverId) {
            $query = <<<SQL
          SELECT users.id ,username, accName, phoneNum, teller_img FROM users INNER JOIN merge ON merge.payer_id = users
          .id WHERE merge.receiver_id = :receiverId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        /**
         * @param $userId
         */
        public function makeDonor($userId) {
            $sql = <<<SQL
          UPDATE users SET valid_for_ph = 1 , valid_for_gh = 0 WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function makeReceiver($payerId) {
            $sql = <<<SQL
          UPDATE users SET valid_for_ph = 0 , valid_for_gh = 1 WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $payerId);
                $stmt->execute();

            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        /**
         * @param $receiverId
         * @param $payerId
         * @return bool
         */
        public function transactionIsOver($receiverId, $payerId) {
            $query = <<<SQL
          SELECT confirm_status FROM merge WHERE receiver_id = :receiverId AND payer_id = :payerId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN) == 1;
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }


        /**
         * @param $userId
         * @return array
         */
        public function getWithdrawalHistory($userId) {
            $sql = <<<SQL
          SELECT date, amount, confirm_status FROM merge WHERE receiver_id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }


        /**
         * @param $userId
         * @return array
         */
        public function getDepositHistory($userId) {
            $sql = <<<SQL
          SELECT date, amount, confirm_status FROM merge WHERE payer_id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        /**
         * @param $userId
         * @return array
         */
        public function getAllHistory($userId) {
            $sql = <<<SQL
          SELECT merge.id, payer_id, (SELECT username FROM users WHERE users.id = payer_id) AS payerUsername,
          receiver_id, (SELECT username FROM users WHERE users.id = receiver_id) AS receiverUsername,
          amount, 
          date, 
          confirm_status 
          FROM 
          merge WHERE 
          receiver_id = 
          :userId OR 
          payer_id = 
          :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function updateReceiverMsg($payerId, $msg) {
            $sql = <<<SQL
          UPDATE merge SET receiver_msg = :receiverMsg WHERE payer_id = :payerId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':receiverMsg', $msg);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function getCurrentInfo($userId) {
            $sql = <<<SQL
          SELECT current_msg FROM users WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam('userId', $userId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function resetAvailability($userId) {
            $sql = <<<SQL
          UPDATE users SET valid_for_ph = 0, valid_for_gh = 0 WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam('userId', $userId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function deleteAllExpiredTransactions() {
            $now = time();
            $sql = <<<SQL
          DELETE FROM merge WHERE expiry_date < $now AND confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam('userId', $userId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function deactivateAllExpiredPayers() {
            $now = time();
            $query = <<<SQL
              UPDATE users INNER JOIN merge ON merge.payer_id = users.id SET activated = 0 WHERE expiry_date < $now 
              AND merge.confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function receiverHasConfirmed($userId) {
            $query = <<<SQL
          SELECT receiver_confirmation FROM merge WHERE payer_id = :payerId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':payerId', $userId);
                $stmt->execute();
                $confirmed = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $confirmed == 1;
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function saveToken($userId, $token) {
            $query = <<<SQL
          UPDATE users SET v_token = :token WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':token', $token);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function getAllValidReceivers() {
            $query = <<<SQL
              SELECT id, current_plan FROM users WHERE valid_for_gh = 1 AND activated = 1
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function getValidPayer($receiverPlan) {
            $query = <<<SQL
              SELECT id FROM users WHERE activated = 1 AND valid_for_ph = 1 AND current_plan = :receiverPlan LIMIT 1
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':receiverPlan', $receiverPlan);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function getReceiveHistoryCount($receiverId) {
            $query = <<<SQL
              SELECT COUNT(*) FROM merge WHERE receiver_id = :receiverId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN);

            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function adminEditUser(AdminEditForm $adminEditForm) {
            $query = <<<SQL
        UPDATE users SET bankName = :bankName , accName = :accName , accNum = :accNum, phoneNum  = :phoneNum, 
        activated = :activated, valid_for_ph = :valid_for_ph, valid_for_gh = :valid_for_gh
SQL;

            if ($adminEditForm->password != "") {
                $query .= ", password = :password";
            }
            $query .= " WHERE id = :userId";

            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':bankName', $adminEditForm->bankName);
                $stmt->bindParam(':accName', $adminEditForm->accName);
                $stmt->bindParam(':accNum', $adminEditForm->accNum);
                $stmt->bindParam(':phoneNum', $adminEditForm->phoneNum);

                if ($adminEditForm->password != "") {
                    $stmt->bindParam(':password', password_hash($adminEditForm->password, PASSWORD_BCRYPT));
                }
                $stmt->bindParam(':activated', $adminEditForm->activated);
                $stmt->bindParam(':valid_for_ph', $adminEditForm->validDonor);
                $stmt->bindParam(':valid_for_gh', $adminEditForm->valid_receiver);
                $stmt->bindParam(':userId', $adminEditForm->userId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function isSuperUser($userId) {
            $sql = <<<SQL
              SELECT role FROM users WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $role = $stmt->fetch(\PDO::FETCH_COLUMN);

                return ($role == "superuser" || $role == "admin");
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function getReceiveToken($receiverId, $payerId) {
            $sql = <<<SQL
              SELECT receiver_confirmation_token FROM merge WHERE receiver_id = :receiver_id AND payer_id = :payer_id
               AND confirm_status = 0;
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':receiver_id', $receiverId);
                $stmt->bindParam(':payer_id', $payerId);
                $stmt->execute();
                $token = $stmt->fetch(\PDO::FETCH_COLUMN);


                return $token;
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function searchUserByUsername(string $username) {
            $username .= "%";
            $sql = <<<SQL
              SELECT id, username, activated, valid_for_ph, valid_for_gh, current_plan FROM users WHERE username LIKE 
              :username OR id LIKE :username OR users.accName LIKE :username
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function getDonorsCount() {
            $sql = <<<SQL
              SELECT COUNT(*) FROM users WHERE valid_for_ph = 1
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function savePasswordResetToken($userId, $token) {
            $query = <<<SQL
          UPDATE users SET reset_password_token = :token WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':token', $token);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function getUserIdByEmail($email) {
            $query = <<<SQL
          SELECT id FROM users WHERE email = :email
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function resetPasswordTokenMatches($userId, $token) {
            $sql = <<<SQL
            
            SELECT COUNT(*) FROM users WHERE id = :userId AND reset_password_token = :token
#               SELECT COUNT(*) FROM users WHERE id = :userId AND v_token = :token
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->bindParam(':token', $token);
                $stmt->execute();
                $count = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $count == 1;
            }
            catch (\PDOException $e) {
                return false;
            }
        }

        public function deletePasswordResetToken($userId) {
            $sql = <<<SQL
              UPDATE users SET reset_password_token = NULL WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function increaseViews() {
        }

        public function isDeactivated($username): bool {
            $query = <<<SQL
          SELECT activated FROM users WHERE username = :username
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                $activated = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $activated == 0;
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. Please try again later or contact us for help");
            }
        }

        public function cancelTransaction($userId) {
            $query = <<<SQL
             UPDATE users SET valid_for_ph = 0 WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. Please try again later or contact us for help");
            }

        }

        public function getReceiverUnfinishedTransaction($receiverId) {
            $query = <<<SQL
              SELECT COUNT(*) FROM merge WHERE receiver_id = :receiverId AND confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_COLUMN);

            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function getAllActiveUserEmail() {
            $query = <<<SQL
              SELECT email FROM users WHERE activated = 1
SQL;
            $stmt = $this->handle->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_COLUMN);

        }

        public function getAllInActiveUserEmail() {
            $query = <<<SQL
              SELECT email FROM users WHERE activated = 1
SQL;
            $stmt = $this->handle->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_COLUMN);

        }

        public function getUserEmail() {
            $query = <<<SQL
              SELECT email FROM users
SQL;
            $stmt = $this->handle->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_COLUMN);

        }

        public function getTransactionExpiry($payerId, $receiverId) {
            $query = <<<SQL
              SELECT expiry_date FROM merge WHERE payer_id = :payerId AND receiver_id = :receiverId AND confirm_status 
              = 0;
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }

        }

        public function getAllRecipients() {
            $sql = <<<SQL
          SELECT list.id AS trans_id, list.recipient_id, (SELECT username FROM users WHERE id = recipient_id) AS 
          recipient_name, rem_amount, (list.rem_amount * 500) AS amount_ngn FROM list WHERE visible = 1 ORDER BY 
          date_added  
          LIMIT
           20 
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function makeDonation($payerId, $receiverId, $amount, $date, $expiry, $receiverConfirmationToken) {
            $query = <<<SQL
          INSERT INTO merge (payer_id,receiver_id, amount, date, expiry_date, expiry_msql, 
          receiver_confirmation_token) 
          VALUES 
          (:payerId,:receiverId, 
           :amount, :date_of_transaction, :expiry, CURDATE() + INTERVAL 4 HOUR , 
          :receiverConfirmationToken)
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->bindParam(':amount', $amount);
                $stmt->bindParam(':date_of_transaction', $date);
                $stmt->bindParam(':expiry', $expiry);
                $stmt->bindParam(':receiverConfirmationToken', $receiverConfirmationToken);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred while merging the users. " . $e->getMessage());
            }

            $sql = <<<SQL
          UPDATE users SET valid_for_ph = 0 WHERE id = :payerId
SQL;
            try {
                $stmt2 = $this->handle->prepare($sql);
                $stmt2->bindParam(':payerId', $payerId);
                $stmt2->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred while making the donor unavailable to reserve");
            }
        }

        public function confirmPayer($receiverId, $payerId, $amount) {
            $sql = <<<SQL
          UPDATE merge SET confirm_status = 1 WHERE payer_id = :payerId AND receiver_id = :receiverId AND 
          amount = :amount
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->bindParam(':amount', $amount);
                $stmt->execute();

                // update the confirmed amount for the receiver
                $this->updateCollected($receiverId, $amount);

                // check if the recipient has received all payments
                if ($this->hasReceivedFullPayment($receiverId)) {
                    $this->completePayment($receiverId);
                    $this->makeDonor($receiverId);
                }
                // Add the user to the list
                $this->makeReceiver($payerId);
                $this->addToList($payerId, $amount, $withBonus = true);
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }


        public function confirmReceiver($payerId, $payeeId, $imgName, $amount) {
            $sql = <<<SQL
          UPDATE merge SET teller_img = :tellerImg , payer_confirmation = 1 WHERE payer_id = :payerId AND receiver_id
           = :receiverId AND confirm_status = 0 AND amount = :amount
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->bindParam(':receiverId', $payeeId);
                $stmt->bindParam(':tellerImg', $imgName);
                $stmt->bindParam(':amount', $amount);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function completePayment($receiverId) {
            $sql = <<<SQL
            UPDATE list SET completed = 1 WHERE recipient_id = :recipientId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':recipientId', $receiverId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function updateCollected($userId, $amount) {
            $sql = <<<SQL
            UPDATE list SET collected = collected + $amount WHERE recipient_id = :recipientId AND 
            completed = 0
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                //$stmt->bindParam(':amount', $amount);
                $stmt->bindParam(':recipientId', $userId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function hasReceivedFullPayment($userId): bool {
            $sql = <<<SQL
          SELECT list.amount_dollars, list.collected FROM list WHERE recipient_id = :recipientId AND completed = 0
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':recipientId', $userId);
                $stmt->execute();
                $arr = $stmt->fetch(\PDO::FETCH_ASSOC);

                return $arr['amount_dollars'] == $arr['collected'];
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function addToList($userId, $amount , $withBonus) {
            if ($withBonus) {
                $refBonus = $this->getReferralBonus($userId);
                $totalReturns = PlanManager::calculateReturns($amount);
                $totalReturns += $refBonus;
                $accumulation = PlanManager::calculateAccumulation($totalReturns);
                $totalReturns -= $accumulation;
                $this->updateAccumulation($userId, $accumulation);
                $this->resetRefBonus($userId);
            }
            else {
                $totalReturns = $amount;
            }
            $amountInNaira = PlanManager::convertToNaira($totalReturns);
            $dateAdded = date('d-m-Y');
            $timeAdded = time();
            $sql = <<<SQL
          INSERT INTO list (recipient_id, amount_dollars, amount_ngn, date_added,time_added, rem_amount) VALUES 
          (:recipientId, :amountDollars, :amountNaira, :dateAdded, :timeAdded , :remAmount)
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':recipientId', $userId);
                $stmt->bindParam(':amountDollars', $totalReturns);
                $stmt->bindParam(':amountNaira', $amountInNaira);
                $stmt->bindParam(':dateAdded', $dateAdded);
                $stmt->bindParam(':timeAdded', $timeAdded);
                $stmt->bindParam(':remAmount', $totalReturns);

                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function listContains($userId) {
            $sql = <<<SQL
          SELECT COUNT(*) FROM list WHERE recipient_id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN) == 1;
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function isVisible($userId) {
            $sql = <<<SQL
          SELECT visible FROM list WHERE recipient_id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN) == 1;
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function getRecipientInfo($recipientId) {
            $query = <<<SQL
          SELECT users.id , username, accName,bankName, accNum, phoneNum, rem_amount FROM users INNER JOIN list ON list
          .recipient_id =  users.id WHERE list.recipient_id = :recipientId
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':recipientId', $recipientId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function payTo($recipientId, $amount) {
            $sql = <<<SQL
          UPDATE list SET rem_amount = rem_amount - $amount WHERE recipient_id = :recipientId AND visible = 1
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                //$stmt->bindParam(':amount', $amount);
                $stmt->bindParam(':recipientId', $recipientId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function paymentHasBeenFullyTaken($recipientId) {
            $sql = <<<SQL
          SELECT rem_amount FROM list WHERE recipient_id = :recipientId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':recipientId', $recipientId);
                $stmt->execute();
                $remAmount = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $remAmount <= 0;
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred");
            }
        }

        public function makeInvisible($userId) {
            $sql = <<<SQL
          UPDATE list SET visible = 0 WHERE recipient_id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }

        }

        public function getAmount($receiverId, $payerId) {
            $sql = <<<SQL
           SELECT amount FROM merge WHERE receiver_id = :receiverId AND payer_id = :payerId AND merge.confirm_status = 0
SQL;

            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }

        }

        public function getPayerAmount($payerId, $receiverId) {
            $sql = <<<SQL
           SELECT amount FROM merge WHERE receiver_id = :receiverId AND payer_id = :payerId AND merge.confirm_status = 0
SQL;

            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }

        }

        public function getReceiverId($payerId) {
            $now = time();
            $sql = <<<SQL
          SELECT receiver_id FROM merge WHERE payer_id = :payerId AND confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function getPledgedAmount($payerId, $receiverId) {
            $sql = <<<SQL
          SELECT amount FROM merge WHERE payer_id = :payerId AND receiver_id = :receiverId AND merge.confirm_status = 0 
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function timeHasExpired($payerId, $receiverId, $amount) {
            $now = time();
            $sql = <<<SQL
          SELECT expiry_date FROM merge WHERE payer_id
           = :payerId AND receiver_id = :receiverId AND amount = :amount AND confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->bindParam(':amount', $amount);
                $stmt->execute();
                $expiry = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $now > $expiry;
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function addToRemainingAmount($receiverId, $amount) {
            $sql = <<<SQL
          UPDATE list SET rem_amount = rem_amount + :amount WHERE recipient_id = :recipientId AND completed = 0
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':amount', $amount);
                $stmt->bindParam(':recipientId', $receiverId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }

        }

        public function deleteTransaction($payerId, $receiverId) {
            $sql = <<<SQL
             DELETE FROM merge WHERE payer_id = :payerId AND receiver_id = :receiverId AND merge.confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function getAllExpiredPayers($receiverId) {
            $now = time();
            $sql = <<<SQL
          SELECT payer_id FROM merge WHERE receiver_id = :receiverId AND confirm_status = 0 AND merge.expiry_date < :now
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':receiverId', $receiverId);
                $stmt->bindParam(':now', $now);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function getAllReceivers() {
            $sql = <<<SQL
          SELECT receiver_id FROM merge WHERE confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function getTotalInvestment($userId) {
            $sql = <<<SQL
           SELECT SUM(amount) FROM merge WHERE payer_id = :userId AND confirm_status = 1
SQL;

            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $total = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $total > 0 ? $total : 0;
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function getTotalReturn($userId) {
            $sql = <<<SQL
           SELECT SUM(amount) FROM merge WHERE receiver_id = :userId AND confirm_status = 1
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $total = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $total > 0 ? $total : 0;
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function addBonus($referralId) {
            $refBonus = REF_BONUS;
            $sql = <<<SQL
           UPDATE users SET ref_bonus = ref_bonus + :refBonus WHERE id = :referralId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':refBonus', $refBonus);
                $stmt->bindParam(':referralId', $referralId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }

        }

        public function getRefId($payerId) {
            $sql = <<<SQL
           SELECT ref_id FROM users WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $payerId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }

        }

        /**
         * @param $payerId
         * @return mixed
         */
        public function getReceiverDetailsForOutGoing($payerId) {
            $query = <<<SQL
        
        SELECT merge.id, username, accName,bankName, accNum, phoneNum FROM users INNER JOIN merge ON merge
          .receiver_id = users.id WHERE merge.payer_id = :payerId AND confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function getReceiverInfo($payerId) {
            $query = <<<SQL
        
        SELECT users.id, username, amount, accName,bankName, accNum, phoneNum FROM users INNER JOIN merge ON merge
          .receiver_id = users.id WHERE merge.payer_id = :payerId AND confirm_status = 0
SQL;
            try {
                $stmt = $this->handle->prepare($query);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function getAllReferred($userId) {
            $sql = <<<SQL
          SELECT COUNT(*) FROM users WHERE ref_id = :userId 
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                $total = $stmt->fetch(\PDO::FETCH_COLUMN);

                return $total > 0 ? $total : 0;
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }

        }

        public function refBonus($userId) {
            $sql = <<<SQL
          SELECT ref_bonus FROM users WHERE id = :userId 
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }

        }

        public function referredUsers($userId) {
            $sql = <<<SQL
          SELECT users.id AS referralId, (SELECT COUNT(*) FROM merge INNER JOIN users ON merge.payer_id = users.id 
          WHERE payer_id = referralId AND confirm_status = 1) AS pledge_count, date_joined, username , activated, 
          ref_bonus, ref_bonus_paid FROM users WHERE ref_id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function getAllReferredId($userId) {
            $sql = <<<SQL
          SELECT id FROM users WHERE ref_id = :userId
SQL;

            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                return $stmt->fetchAll(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }

        }

        public function getAllActiveReferralsCount($userId) {
            $referredIds = $this->getAllReferredId($userId);
            $count = 0;
            foreach ($referredIds as $id) {
                if ($this->hasBeenPayer($id)) {
                    $count++;
                }
            }

            return $count;
        }

        public function hasBeenPayer($userId) {
            $sql = <<<SQL
          SELECT COUNT(*) FROM merge WHERE payer_id = :userId AND confirm_status = 1
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN) > 0;
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function getListUsers() {
            $sql = <<<SQL
          SELECT id, recipient_id AS recipientId, (SELECT username FROM users WHERE users.id = recipientId) AS  
          recipient_username, amount_dollars, amount_ngn, date_added, time_added, rem_amount, visible, collected,  
          completed FROM list
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }
            catch (\PDOException $e) {
             throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function getVisibleReceiversCount() {
            $sql = <<<SQL
              SELECT COUNT(*) FROM list WHERE visible = 1
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->execute();
                return $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException("An error occurred. " . $e->getMessage());
            }
        }

        public function releaseNewList() {
            $visible = $this->getVisibleReceiversCount();
            var_dump($visible);
            if ($visible == 0) {
                $sql = <<<SQL
              UPDATE list SET visible = 1 WHERE visible = 0 AND completed = 0 AND list.rem_amount != 0 
              ORDER BY time_added DESC LIMIT 2
SQL;
                try {
                    $stmt = $this->handle->prepare($sql);
                    $stmt->execute();
                }
                catch (\PDOException $e) {
                    throw new \PDOException("An error occurred. " . $e->getMessage());
                }
            }
        }


        public function updateAccumulation($userId, $amount) {
            $sql = <<<SQL
              UPDATE users SET accumulation = accumulation + :amount WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':amount', $amount);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function adminAddToList($userId, $amount, $withBonus = true) {
            $this->makeReceiver($userId);
            if ($withBonus) {
                $refBonus = $this->getReferralBonus($userId);
                $totalReturns = PlanManager::calculateReturns($amount);
                $totalReturns += $refBonus;
                $accumulation = PlanManager::calculateAccumulation($totalReturns);
                $totalReturns -= $accumulation;
                $this->updateAccumulation($userId, $accumulation);
                $this->resetRefBonus($userId);
            }
            else {
                $totalReturns = $amount;
            }
            $amountInNaira = PlanManager::convertToNaira($totalReturns);
            $dateAdded = date('d-m-Y');
            $timeAdded = time();
            $sql = <<<SQL
          INSERT INTO list (recipient_id, amount_dollars, amount_ngn, date_added,time_added, rem_amount) VALUES 
          (:recipientId, :amountDollars, :amountNaira, :dateAdded, :timeAdded , :remAmount)
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':recipientId', $userId);
                $stmt->bindParam(':amountDollars', $totalReturns);
                $stmt->bindParam(':amountNaira', $amountInNaira);
                $stmt->bindParam(':dateAdded', $dateAdded);
                $stmt->bindParam(':timeAdded', $timeAdded);
                $stmt->bindParam(':remAmount', $totalReturns);

                return $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function resetRefBonus($userId)
        {
            $sql = <<<SQL
               UPDATE users SET ref_bonus = 0 WHERE id = :userId
SQL;

            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function getDonationCount($userId) {
            $sql = <<<SQL
              SELECT COUNT(*) FROM merge WHERE payer_id = :userId AND confirm_status = 1
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                return $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function getAccumulatedEarnings($userId) {
            $sql = <<<SQL
                SELECT accumulation FROM users WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
                return $stmt->fetch(\PDO::FETCH_COLUMN);
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function resetAccumulatedEarnings($userId) {
            $sql = <<<SQL
                UPDATE users SET accumulation = 0 WHERE id = :userId
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

        public function updateRefBonusPaid($payerId)
        {
            $sql = <<<SQL
               UPDATE users SET ref_bonus_paid = 1 WHERE id = :payerId
SQL;

            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':payerId', $payerId);
                $stmt->execute();
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }

        }

        public function listContainsAndPending($userId) {
            $sql = <<<SQL
          SELECT COUNT(*) FROM list WHERE recipient_id = :userId AND completed = 0
SQL;
            try {
                $stmt = $this->handle->prepare($sql);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                return $stmt->fetch(\PDO::FETCH_COLUMN) == 1;
            }
            catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
        }

    }
