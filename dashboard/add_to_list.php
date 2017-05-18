<?php
    session_start();


    require_once "../vendor/autoload.php";
    require_once "../vendor/phpmailer/phpmailer/PHPMailerAutoload.php";

    $title = "Add To List ";

    $pagename = "addTolist";

    use MerryPayout\Admin;
    use MerryPayout\Validate;
    use MerryPayout\EditFormData;


    $admin = new Admin();
    $admin->checkAuth();
    $dataManager = new \MerryPayout\DataManager();

    $msg = "";

    $uId = $_GET['u_id'];
    $userDetails = $admin->getUserDetails($uId);
    $plan = $dataManager->getUserPlan($uId);
    $groupToMergeWith = "";
    $available = array();
    $payer = false;


    if (isset($_POST['add'])) {
        $userId = $_GET['u_id'];
        $amount = $_POST['amount'];
        try {
            if ($admin->addToList($userId , $amount)) {
                $msg = "<div class='alert alert-success'><strong>User has been added to list.</strong></div>";
            }else {
                $msg = "<div class='alert alert-danger'><strong>Sorry this user can not be added to list at this time.</strong></div>";
            }
        }
        catch (\MerryPayout\exceptions\MerryPayoutUserException $e) {
            $msg = "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        }
        catch (\PDOException $e) {
            $msg = "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
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

            <div class="row">
                <div class="col-md-12">
                    <div class="row margin-top-30">
                        <div class="col-lg-6 col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <h5 class="panel-title" style="font-weight: bold; color: green;">User
                                        details</h5>
                                </div>
                                <div class="panel-body">
                                    <?php
                                        if ($msg !== "") {
                                            echo $msg;
                                        }
                                    ?>
                                    <form role="form" method="post">
                                        <div class="form-group">
                                            <label for="username">
                                                Username
                                            </label>
                                            <input readonly class="form-control" id="username" name="username"
                                                   value="<?php echo $userDetails['username']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="bankName">Valid for Provide Help:</label>

                                            <select readonly="" class="name_search form-control" name="valid_donor"
                                                    tabindex="-1"
                                                    style="display: none;">

                                                <option value="0" <?php if (!$userDetails["valid_for_ph"] == 1) {
                                                    echo "selected = 'selected'";
                                                } ?>>No
                                                </option>

                                                <option
                                                        value="1" <?php if ($userDetails["valid_for_ph"] == 1) {
                                                    echo "selected = 'selected'";
                                                } ?> >Yes
                                                </option>

                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <label for="bankName">Valid for Getting Help:</label>

                                            <select readonly="readonly" class="name_search form-control"
                                                    name="valid_receiver" tabindex="-1"
                                                    style="display: none;">
                                                <option value="0" <?php if (!$userDetails["valid_for_gh"] == 1) {
                                                    echo "selected = 'selected'";
                                                } ?>>No
                                                </option>
                                                <option
                                                        value="1" <?php if ($userDetails["valid_for_gh"] == 1) {
                                                    echo "selected = 'selected'";
                                                } ?> >Yes
                                                </option>
                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <label for="email">
                                                Email
                                            </label>
                                            <input readonly type="text" class="form-control" id="email" name="email"
                                                   value="<?php echo $userDetails['email']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="bankName">Bank Name:</label>

                                            <select readonly="" class="name_search form-control" name="bankName"
                                                    tabindex="-1"
                                                    style="display: none;">
                                                <option value="">Select your bank</option>

                                                <option
                                                        value="Access Bank PLC" <?php if ($userDetails["bankName"] == "Access Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?> >Access Bank PLC
                                                </option>

                                                <option
                                                        value="Citibank Nigeria LTD" <?php if ($userDetails["bankName"] == "Citibank Nigeria LTD") {
                                                    echo "selected = 'selected'";
                                                } ?> >Citibank Nigeria LTD
                                                </option>

                                                <option
                                                        value="Diamond Bank PLC" <?php if ($userDetails["bankName"] == "Diamond Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?> >Diamond Bank PLC
                                                </option>


                                                <option
                                                        value="Ecobank Nigeria PLC" <?php if ($userDetails["bankName"] == "Ecobank Nigeria PLC") {
                                                    echo "selected = 'selected'";
                                                } ?> >Ecobank Nigeria PLC
                                                </option>


                                                <option
                                                        value="Fidelity Bank PLC" <?php if ($userDetails["bankName"] == "Fidelity Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>Fidelity Bank PLC
                                                </option>


                                                <option
                                                        value="First bank of Nigeria PLC" <?php if ($userDetails["bankName"] == "First bank of Nigeria PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>First bank of Nigeria PLC
                                                </option>


                                                <option
                                                        value="First City Monument Bank PLC" <?php if ($userDetails["bankName"] == "First City Monument Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?> >First City Monument Bank PLC
                                                </option>

                                                <option
                                                        value="Guaranty Trust Bank" <?php if ($userDetails["bankName"] == "Guaranty Trust Bank") {
                                                    echo "selected = 'selected'";
                                                } ?>>Guaranty Trust Bank
                                                </option>

                                                <option
                                                        value="Heritage Bank" <?php if ($userDetails["bankName"] == "Heritage Bank") {
                                                    echo "selected = 'selected'";
                                                } ?>>Heritage Bank
                                                </option>

                                                <option
                                                        value="Jaiz Bank" <?php if ($userDetails["bankName"] == "Jaiz Bank") {
                                                    echo "selected = 'selected'";
                                                } ?>>Jaiz Bank
                                                </option>

                                                <option
                                                        value="Keystone Bank PLC" <?php if ($userDetails["bankName"] == "Keystone Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>Keystone Bank PLC
                                                </option>

                                                <option
                                                        value="Skye Bank PLC" <?php if ($userDetails["bankName"] == "Skye Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>Skye Bank PLC
                                                </option>


                                                <option
                                                        value="Stanbic IBTC Bank PLC" <?php if ($userDetails["bankName"] == "Stanbic IBTC Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>Stanbic IBTC Bank PLC
                                                </option>


                                                <option
                                                        value="Standard Chartered Bank Nigeria PLC" <?php if ($userDetails["bankName"] == "Standard Chartered Bank Nigeria PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>Standard Chartered Bank Nigeria PLC
                                                </option>


                                                <option
                                                        value="Sterling Bank PLC" <?php if ($userDetails["bankName"] == "Sterling Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>Sterling Bank PLC
                                                </option>


                                                <option
                                                        value="Union Bank of Nigeria PLC(UBN)" <?php if ($userDetails["bankName"] == "Union Bank of Nigeria PLC(UBN)") {
                                                    echo "selected = 'selected'";
                                                } ?>>Union Bank of Nigeria PLC(UBN)
                                                </option>


                                                <option
                                                        value="United Bank for Africa(UBA)" <?php if ($userDetails["bankName"] == "United Bank for Africa(UBA)") {
                                                    echo "selected = 'selected'";
                                                } ?>>United Bank for Africa(UBA)
                                                </option>


                                                <option
                                                        value="Unity Bank PLC" <?php if ($userDetails["bankName"] == "Unity Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>Unity Bank PLC
                                                </option>


                                                <option
                                                        value="Wema Bank PLC" <?php if ($userDetails["bankName"] == "Wema Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>Wema Bank PLC
                                                </option>


                                                <option
                                                        value="Zenith Bank PLC" <?php if ($userDetails["bankName"] == "Zenith Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?> >Zenith Bank PLC
                                                </option>
                                            </select>

                                        </div>
                                        <div class="form-group">
                                            <label for="accName">
                                                Account Name
                                            </label>
                                            <input readonly type="text" class="form-control" id="accName" name="accName"
                                                   value="<?php echo $userDetails['accName']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="accNum">
                                                Account Number
                                            </label>
                                            <input readonly type="text" pattern="[0-9]{10}" class="form-control"
                                                   id="accNum"
                                                   name="accNum" value="<?php echo $userDetails['accNum']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="phoneNum">
                                                Phone Number
                                            </label>
                                            <input readonly type="text" pattern="[0-9]{11}" class="form-control"
                                                   id="phoneNum"
                                                   name="phoneNum" value="<?php echo $userDetails['phoneNum']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="activated">Activated:</label>

                                            <select class="name_search form-control" name="activated" tabindex="-1"
                                                    style="display: none;">

                                                <option readonly=""
                                                        value="0" <?php if (!$userDetails["activated"] == 1) {
                                                    echo "selected = 'selected'";
                                                } ?>>No
                                                </option>
                                                <option
                                                        value="1" <?php if ($userDetails["activated"] == 1) {
                                                    echo "selected = 'selected'";
                                                } ?> >Yes
                                                </option>
                                            </select>

                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <h5 class="panel-title" style="font-weight: bold;color: green;"> Amount
                                        <br><br>
                                        <small>1 USD = <?php print DOLLAR_RATE_IN_NAIRA ?> NGN</small>
                                    </h5>
                                </div>
                                <div class="panel-body">
                                    <?php
                                        if ($msg != "") {
                                            echo $msg;
                                        }
                                    ?>
                                    <form method="post">
                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label">Amount in Dollar:</label>
                                            <div class="col-sm-8">
                                                <div class="input-group"><span
                                                            class="input-group-addon bg"><i>$</i></span>
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
                                                <button name="add" type="submit" class="btn btn-success pull-right">
                                                    Add to List
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
        </div>
    </div>
</div>
<!-- wrapper -->

<?php require_once "includes/footer.php"; ?>







