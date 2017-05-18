<?php

require_once "vendor/autoload.php";

$dataManager = new \MerryPayout\DataManager();

$user = new \MerryPayout\User(10);

$user->getUserId();

 $check = $user->confirmReceiver( 9, "ffffffffff" , 70);

 var_dump($check);

