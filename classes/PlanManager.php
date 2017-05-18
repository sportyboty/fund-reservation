<?php

namespace MerryPayout;

require_once "config.php";

class PlanManager extends Queryable {

    public function __construct() {
        parent::__construct();
    }



    static public function calculateReturns($amount)
    {
        return ((PERCENTAGE_PROFIT / 100) * $amount) + $amount;
    }

    static public function convertToNaira($dollarAmount)
    {
        return ($dollarAmount * DOLLAR_RATE_IN_NAIRA);
    }

    static public function calculateAccumulation($amount)
    {
        return 0.05 * $amount;
    }

}