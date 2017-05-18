<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/11/2017
 * Time: 3:11 PM
 */

namespace MerryPayout;


class Payer extends User {

    private $id;
    protected $dm;

    /**
     * Payer constructor.
     * @param $userId int
     */
    public function __construct($userId) {
        $this->id = $userId;
        $this->dm = new DataManager();
    }

    /**
     * @param $receiverId int
     * @param $amount int
     * @return void
     */
    public function donate($receiverId, $amount) {
        $merger = new Merger();
        $merger->merge($this->id, $receiverId, $amount);
        //$this->dm->makeDonation($this->id, $receiverId, $amount);
    }

    public function getId() {
        return $this->id;
    }

    /**
     * Checks if the receiver to be paid by this payer has confirmed payment from this payer.
     * @return bool
     */
    public function isConfirmed() {
        return $this->dm->receiverHasConfirmed($this->id);
    }



    public function getReceiverId() {
        return $this->dm->getReceiverId($this->id);
    }

    public function getPledgedAmount($receiverId) {
        return $this->dm->getPledgedAmount($this->id, $receiverId);
    }

    public function timeHasExpired() {
        $receiverId = $this->getReceiverId();
        return $this->dm->timeHasExpired($this->id, $receiverId, $this->getPledgedAmount($receiverId));
    }

    public function deleteUnsuccessfulTransaction() {
        $this->dm->deleteTransaction($this->id, $this->getReceiverId());
    }

    public function deactivate() {
        $this->dm->deactivateUser($this->id);
    }

    public function getExpiry() {
        return $this->dm->getTransactionExpiry($this->id, $this->getReceiverId());
    }

    public function endTransaction() {
        $receiverId = $this->getReceiverId();
        $pledgedAmount = $this->getPledgedAmount($receiverId);
        $receiver = new Receiver($receiverId);
        $receiver->addToRemainingAmount($pledgedAmount);
        $this->deleteUnsuccessfulTransaction();
        $this->deactivate();
    }

    public function getReceiverDetails() {
        return $this->dm->getReceiverDetailsForOutGoing($this->id);
    }

    public function getReceiverInfo()
    {
        return $this->dm->getReceiverInfo($this->id);
    }


}