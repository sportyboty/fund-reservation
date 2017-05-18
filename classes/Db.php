<?php

    /**
     * Created by PhpStorm.
     * User: User
     * Date: 12/8/2016
     * Time: 8:51 PM
     */

    namespace MerryPayout;

    require_once "config.php";

    class DbManager {
        private static $instance;
        protected $handle;

        public function __construct() {
            try {
                $handle = new \PDO(DSN, USER, PASSWORD);
                $this->handle = $handle;
                $this->handle->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
            catch (\PDOException $e) {
                echo "Connection to the database failed: " . $e->getMessage();
                exit();
            }
        }

        static public function Instantiate() {
            if (!isset(self::$instance)) {
                $class = __CLASS__;
                self::$instance = new $class;
            }

            return self::$instance;
        }

        public function getHandle() {
            return $this->handle;
        }
    }