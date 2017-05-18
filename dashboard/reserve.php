<?php
session_start();


require_once "../vendor/autoload.php";
require_once "../vendor/phpmailer/phpmailer/PHPMailerAutoload.php";

$title = "Merge User ";

$pagename = "mergeuser";


$user = new \MerryPayout\User();
$user->checkAuth();
$dataManager = new \MerryPayout\DataManager();

$msg = "";

$uId = $_GET['u_id'] ?? null;
$receiverDetails = $dataManager->getRecipientInfo($uId);
$remainAmt = $receiverDetails['rem_amount'];

if (isset($_POST['reserve'])) {
    $amount = $_POST['amount'];

    if (!\MerryPayout\Validate::Number($amount)) {
        $msg = "You have entered an invalid amount.";
    }
    elseif ($amount < 20 && $remainAmt > 20) {
        $msg = "You cannot reserve less than 20 USD currently";
    }
    elseif ($amount < $remainAmt && $remainAmt < 20) {
        $msg = "Sorry you cannot reserve less than the max reserve amount.";
    }
    elseif($amount > $remainAmt) {
        $msg = "You cannot reserve more than the max reserve amount.";
    }
    else {
        try {
            $payer = new \MerryPayout\Payer($user->getUserId());
            $payer->donate($uId, $amount);
        }
        catch (Exception $e) {
            $msg =  $e->getMessage();
        }
    }

}


?>

<?php

require_once "includes/header.php";

?>
<body>

<div class="wrapper comic-sans">


    <?php require_once "includes/side-bar.php"; ?>
    <!-- left-bar -->
    <div class="content" id="content">

        <div class="overlay"></div>

        <?php require_once "includes/top-bar.php"; ?>
        <!-- /top-bar -->
        <div class="main-content">

            <?php if ($dataManager->listContains($uId) && $dataManager->isVisible($uId)) { ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="row margin-top-30">
                            <div class="col-lg-6 col-md-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h5 class="panel-title" style="font-weight: bold; color: green;">Recipient
                                            Details</h5>
                                    </div>
                                    <div class="panel-body">
                                        <form role="form" method="post">
                                            <div class="form-group">
                                                <label for="username">
                                                    Username
                                                </label>
                                                <input readonly class="form-control" id="username" name="username"
                                                       value="<?php echo $receiverDetails['username']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="username">
                                                    Bank Name
                                                </label>
                                                <input readonly class="form-control" id="username" name="username"
                                                       value="<?php echo $receiverDetails['bankName']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="accName">
                                                    Account Name
                                                </label>
                                                <input readonly type="text" class="form-control" id="accName"
                                                       name="accName"
                                                       value="<?php echo $receiverDetails['accName']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="accNum">
                                                    Account Number
                                                </label>
                                                <input readonly type="text" pattern="[0-9]{10}" class="form-control"
                                                       id="accNum"
                                                       name="accNum" value="<?php echo $receiverDetails['accNum']; ?>">
                                            </div>

                                            <div class="form-group">
                                                <label for="phoneNum">
                                                    Phone Number
                                                </label>
                                                <input readonly type="text" pattern="[0-9]{11}" class="form-control"
                                                       id="phoneNum"
                                                       name="phoneNum"
                                                       value="<?php echo $receiverDetails['phoneNum']; ?>">
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="panel panel-white">
                                    <div class="panel-heading">
                                        <h5 class="panel-title" style="font-weight: bold;color: green;">Reserve Amount
                                            <br><br>
                                            <small>1 USD = 500 NGN</small>
                                        </h5>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                        if ($msg != "") {
                                            echo "<div class='alert alert-danger'><strong>" . $msg . "</strong></div>";
                                        }
                                        ?>
                                        <form method="post">
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label">Max Reserve:</label>
                                                <div class="col-sm-8">
                                                    <div class=""><strong
                                                                style="padding-right: 20px">USD: <?php echo
                                                            $receiverDetails['rem_amount']; ?></strong>
                                                        <strong>NGN:</strong> <strong><?php echo
                                                                $receiverDetails['rem_amount'] * DOLLAR_RATE_IN_NAIRA; ?></strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label">Amount in Dollar:</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group"><span class="input-group-addon bg"><i>$</i></span>
                                                        <input name="amount" type="text" class="form-control" value=""
                                                               placeholder="Enter an amount" id="usd"
                                                               onkeyup="calcReturns()">
                                                    </div>
                                                    <!-- /input-group -->
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 control-label">Amount in Naira:</label>
                                                <div class="col-sm-8">
                                                    <div class="input-group"><span
                                                                class="input-group-addon bg"><i>‎₦</i></span>
                                                        <input title="" type="text" class="form-control" id="ngn"
                                                               disabled="">
                                                    </div>
                                                    <!-- /input-group -->
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-10">
                                                    <button name="reserve" class="btn btn-success pull-right">Reserve
                                                    </button>
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                function calcReturns() {
                                                    var input_number = $("#usd").val();
                                                    input_number = $.trim(input_number);
                                                    input_number = Number(input_number);

                                                    nairaEquiv = input_number * 500;

                                                    $("#ngn").val(nairaEquiv);
                                                }
                                            </script>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- wrapper -->

<?php require_once "includes/footer.php"; ?>







