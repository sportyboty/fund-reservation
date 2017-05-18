<?php


namespace MerryPayout\exceptions;


class MerryPayoutUserException extends \Exception {

	private $culpritId;

    public function __construct($message, $culpritId, $code = null, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->culpritId = $culpritId;
    }

    public function getCulpritId() : int {
    	return $this->culpritId;
    }
}