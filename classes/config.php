<?php
namespace MerryPayout;

date_default_timezone_set('Africa/Lagos');

//------------- DATABASE CONFIGURATIONS ----------------------
define("HOST", "localhost");
define("USER", "root");
define("PASSWORD", '');
define("DB_NAME", 'twilightfunds');
define("DSN", "mysql:dbname=twilightfunds;host=localhost");
//-------------------------------------------------------------


define("VALID_PASSWORD_MIN_LENGTH", 1);

//------ SALT FOR TOKEN GENERATOR --------- //
define("TOKEN_SALT", "((WHHHiueo{d--9e_)j)ljoie%j5l*7");


define("PERCENTAGE_PROFIT", 35);
define("DOLLAR_RATE_IN_NAIRA", 500);
define("DOLLAR_SIGN" , '$');
define("REF_BONUS" , 8);

define("APP_ROOT_DIR", "/twilightfunds/");

//--- GRACE INTERVAL -------//
define("GRACE_PERIOD", (60 * 60 * 4));
define("INTERVAL", 'PT4H');

define("PROF_PIC_DIR", "/dashboard/upload/prof_pics/");