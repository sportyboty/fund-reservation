<?php
    /**
     * Created by PhpStorm.
     * User: User
     * Date: 2/14/2017
     * Time: 3:13 PM
     */

    namespace MerryPayout;

    require_once "config.php";


    class TokenGenerator {

        public static function generateToken() : string {
            return md5(time() . "" . TOKEN_SALT);
        }

        public static function generateReceiverConfirmationToken() : string {
            // random five digit letter
            $token = TokenGenerator::getTwoRandomAlphabets();
            $token .= rand(10000, 99999);
            $token .= TokenGenerator::getTwoRandomAlphabets();

            return $token;
        }

        private static function getTwoRandomAlphabets() : string {
            $small = [
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't',
                'u', 'v', 'w', 'x', 'y', 'z'
            ];
            $tok = "";
            $tok .= ($small[rand(0, count($small) - 1)]) . mb_strtoupper($small[rand(0, count($small) - 1)]);

            return $tok;
        }

    }