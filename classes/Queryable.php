<?php
/**
 * Created by PhpStorm.
 * @author Asiegbu Stanley
 * Date: 12/8/2016
 * Time: 10:09 PM
 */

namespace MerryPayout;

require_once "DataManager.php";
/**
 * This class is the base class for all classes that need to query the database
 * @package nairabank
 * @field $dm : This is an instance of the class DataManager for controlling all queries to the database
 */
abstract class Queryable {
    protected $dm;

    public function __construct() {
        $this->dm = new DataManager();
    }
}