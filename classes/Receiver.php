<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/11/2017
 * Time: 3:11 PM
 */

namespace MerryPayout;


class Receiver extends User {

    private $id;
    protected $dm;

    /**
     * Receiver constructor.
     * @param $id int
     */
    public function __construct($id) {
        $this->id = $id;
        $this->dm = new DataManager();
    }

    /**
     * @return bool
     */
    public function hasBeenFullyPaid() {
        return $this->dm->paymentHasBeenFullyTaken($this->id);
    }

    public function confirmPayer($payerId, $amount) {
        $this->dm->confirmPayer($this->id, $payerId, $amount);
        $this->dm->addBonus($this->getRefId($payerId));
        $this->dm->updateRefBonusPaid($payerId);

    }

    public function collectAmount($payerId, $amount) {
        $this->dm->updateCollected($this->id, $amount);
    }

    public function getRefId($payerId)
    {
        return $this->dm->getRefId($payerId);
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    public function addToRemainingAmount($amount) {
        $this->dm->addToRemainingAmount($this->id, $amount);
    }

    public function getAllExpiredPayers() {
        return $this->dm->getAllExpiredPayers($this->id);
    }

    public function getPayers() {
        return $this->dm->getAllPayers($this->id);
    }

}