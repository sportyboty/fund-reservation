<?php


namespace MerryPayout;

use MerryPayout\exceptions\MerryPayoutUserException;

require_once "config.php";

class Merger extends Queryable {

    private $planManager;

    public function __construct() {
        parent::__construct();
        $this->planManager = new PlanManager();
    }

    /**
     * @param int $payerId
     * @param int $payeeId
     * @param $amount
     * @throws MerryPayoutUserException
     */
    public function merge(int $payerId, int $payeeId, $amount) {

        // First of all check if the participants are both activated
        try {
            if (!$this->dm->isValidForPH($payerId)) {
                throw new MerryPayoutUserException("You are not eligible to reserve", $payerId);
            }
            else {

                // subtract amount from recipient total sum
                $this->dm->payTo($payeeId, $amount);

                if ($this->dm->paymentHasBeenFullyTaken($payeeId)) {
                    $this->dm->makeInvisible($payeeId);
                }

                // Send notification to the receiver and the payer. This message is seen in the user
                // profile page
                $payerDetails = $this->dm->getUserDetails($payerId);
                $receiverDetails = $this->dm->getUserDetails($payeeId);

                $date = date('d-m-Y');
                $expiryDate = $this->calculateExpiry();
                $showExpiry = new \DateTime($date);
                $showExpiry = $showExpiry->add(new \DateInterval(INTERVAL))->format('d-m-Y');
                $naira = $amount * DOLLAR_RATE_IN_NAIRA;
                $dSign = "$";

                // Generate token for the receiver to confirm
                $receiverConfirmationToken = TokenGenerator::generateReceiverConfirmationToken();

                $msgToReceiver = "<div>This user {$payerDetails["username"]} has chosen to reserve you with 
                        ‎{$dSign}{$amount} = ₦{$naira} on " . date('d-m-Y') . ".<br> Payer phone 
                        number is: {$payerDetails["phoneNum"]} .<br> Please 
                        confirm payment once you have been funded by the payer.<br>Transaction token: {$receiverConfirmationToken}</div>";

                $msgToPayer = "You have chosen to reserve {$dSign}{$amount} = ₦{$naira} for {$receiverDetails['username']} 
                <br>  Bank Name: 
                        {$receiverDetails['bankName']} <br>
                            Account Name: {$receiverDetails['accName']} <br> Account Number: 
                            {$receiverDetails['accNum']} <br>Receiver phone number is: 
                            {$receiverDetails['phoneNum']} <br> on " . date('d-m-Y') . ".<br> You will be confirmed by the receiver once you make 
                            the transaction.<br>";

                $receiverUsername = $this->dm->getUsername($payeeId);

                // Save the transaction in the merge table
                $this->dm->mergeUsers($payeeId, $payerId, $amount, $msgToReceiver, $msgToPayer, $date,
                    $expiryDate, $receiverConfirmationToken);

                // Send confirmation token to the recipient
//                            $app = new App();
//                            $app->sendReceiverConfirmationToken($receiverDetails['email'], $receiverUsername,
//                                $receiverConfirmationToken,
//                                $payerDetails["accName"], $payerDetails["username"]);
            }

        }
        catch (\PDOException $e) {
            throw new \PDOException("Error Processing Request " . $e->getMessage());
        }
    }

    public function sendPayerConfirmMsg($payerId) {
        $payerDetails = $this->dm->getUserDetails($payerId);

        $msg = "This payer has confirmed payment to your account.<br> 
        <label>Name: </label> {$payerDetails['accName']}<br>Please go to the confirm payment page and confirm his 
        payment.";

        $this->dm->updateReceiverMsg($payerId, $msg);
    }


    private function calculateExpiry() {
        return time() + GRACE_PERIOD;
    }

    private function calculateAmountToBePaid(int $payerId, int $payeeId): int {
        $plan = $this->dm->getUserPlan($payerId);
        $amount = $this->planManager->getPlanValue($plan);
        $bonus = $this->dm->getReferralBonus($payeeId);
        $amountToPay = $amount + $bonus;

        return $amountToPay;
    }

    public function mergeAllUsers() {
        $validReceivers = $this->dm->getAllValidReceivers();
        //$donorsCount = $this->dm->getDonorsCount();
        $validReceiversCount = count($validReceivers);
        if ($validReceiversCount > 0) {
            foreach ($validReceivers as $receiver) {

                //$payersCount = $this->dm->getPayersCount($receiver['id']);

                //while ($payersCount != null && $donorsCount > 0 && $payersCount < 2) {
                $payerId = $this->dm->getValidPayer($receiver["current_plan"]);
                $payeeId = $receiver["id"];
                //if ($payerId != null) {
                try {
                    $this->merge($payerId, $payeeId);
                    //$payersCount++;
                    //$donorsCount--;
                }
                catch (\Exception $e) {
                    continue;
                }
//                        }
                //}
            }
        }
    }
}