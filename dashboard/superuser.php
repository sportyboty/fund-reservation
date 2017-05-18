<?php
    session_start();

    require_once "../vendor/autoload.php";
    require_once "../vendor/phpmailer/phpmailer/PHPMailerAutoload.php";

    $title = "Merge User ";

    $pagename = "mergeuser";

    use MerryPayout\Admin;
    use MerryPayout\Validate;
    use MerryPayout\EditFormData;

    $dataManager = new \MerryPayout\DataManager();
    $user = new \MerryPayout\User();
    $user->checkAuth();
    $admin = new Admin();
//    $admin->checkAuth();
    $userInfo = $user->getDetails();


    if (!$user->isSuperUser()) {
        header("Location:signin");
    }
    else {
        $msg = "";
        $plan = $dataManager->getUserPlan($user->getUserId());
        $groupToMergeWith = "";
        $available = array();
        $payer = false;

        if ($user->isValidForGH()) {
            $available = $dataManager->getTwoValidDonors($plan);
            $groupToMergeWith = "Available Donors";
            $payer = false;
        }
    }

    if (isset($_POST['merge'])) {
        $payerId = $payer ? $user->getUserId() : $_POST['payerId'];
        $payee = $payer ? $_POST['payerId'] : $user->getUserId();
        try {
            $admin->mergeUsers($payee, $payerId);
            $msg = "<div class='alert alert-success'> Successfully merged the users </div>";
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
                                        details</h5><br>
                                    <?php if ($groupToMergeWith != "") { ?>
                                        <small style="color: darkgreen;">This user is an available <?php echo $payer ? "donor so can only
                                     be 
                                    merged with receivers." : "receiver so can only be merged with donors." ?></small>
                                    <?php }
                                    elseif ($dataManager->isPayer($user->getUserId())) { ?>
                                        <small style="color: red;">This user is already a merged payer.</small>
                                    <?php } ?>
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
                                                   value="<?php echo $userInfo['username']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="bankName">Valid for Provide Help:</label>

                                            <select readonly="" class="name_search form-control" name="valid_donor"
                                                    tabindex="-1"
                                                    style="display: none;">

                                                <option value="0" <?php if (!$userInfo["valid_for_ph"] == 1) {
                                                    echo "selected = 'selected'";
                                                } ?>>No
                                                </option>

                                                <option
                                                    value="1" <?php if ($userInfo["valid_for_ph"] == 1) {
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
                                                <option value="0" <?php if (!$userInfo["valid_for_gh"] == 1) {
                                                    echo "selected = 'selected'";
                                                } ?>>No
                                                </option>
                                                <option
                                                    value="1" <?php if ($userInfo["valid_for_gh"] == 1) {
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
                                                   value="<?php echo $userInfo['email']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="bankName">Bank Name:</label>

                                            <select readonly="" class="name_search form-control" name="bankName"
                                                    tabindex="-1"
                                                    style="display: none;">
                                                <option value="">Select your bank</option>

                                                <option
                                                    value="Access Bank PLC" <?php if ($userInfo["bankName"] == "Access Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?> >Access Bank PLC
                                                </option>

                                                <option
                                                    value="Citibank Nigeria LTD" <?php if ($userInfo["bankName"] == "Citibank Nigeria LTD") {
                                                    echo "selected = 'selected'";
                                                } ?> >Citibank Nigeria LTD
                                                </option>

                                                <option
                                                    value="Diamond Bank PLC" <?php if ($userInfo["bankName"] == "Diamond Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?> >Diamond Bank PLC
                                                </option>


                                                <option
                                                    value="Ecobank Nigeria PLC" <?php if ($userInfo["bankName"] == "Ecobank Nigeria PLC") {
                                                    echo "selected = 'selected'";
                                                } ?> >Ecobank Nigeria PLC
                                                </option>


                                                <option
                                                    value="Fidelity Bank PLC" <?php if ($userInfo["bankName"] == "Fidelity Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>Fidelity Bank PLC
                                                </option>


                                                <option
                                                    value="First bank of Nigeria PLC" <?php if ($userInfo["bankName"] == "First bank of Nigeria PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>First bank of Nigeria PLC
                                                </option>


                                                <option
                                                    value="First City Monument Bank PLC" <?php if ($userInfo["bankName"] == "First City Monument Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?> >First City Monument Bank PLC
                                                </option>

                                                <option
                                                    value="Guaranty Trust Bank" <?php if ($userInfo["bankName"] == "Guaranty Trust Bank") {
                                                    echo "selected = 'selected'";
                                                } ?>>Guaranty Trust Bank
                                                </option>

                                                <option
                                                    value="Heritage Bank" <?php if ($userInfo["bankName"] == "Heritage Bank") {
                                                    echo "selected = 'selected'";
                                                } ?>>Heritage Bank
                                                </option>

                                                <option
                                                    value="Jaiz Bank" <?php if ($userInfo["bankName"] == "Jaiz Bank") {
                                                    echo "selected = 'selected'";
                                                } ?>>Jaiz Bank
                                                </option>

                                                <option
                                                    value="Keystone Bank PLC" <?php if ($userInfo["bankName"] == "Keystone Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>Keystone Bank PLC
                                                </option>

                                                <option
                                                    value="Skye Bank PLC" <?php if ($userInfo["bankName"] == "Skye Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>Skye Bank PLC
                                                </option>


                                                <option
                                                    value="Stanbic IBTC Bank PLC" <?php if ($userInfo["bankName"] == "Stanbic IBTC Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>Stanbic IBTC Bank PLC
                                                </option>


                                                <option
                                                    value="Standard Chartered Bank Nigeria PLC" <?php if ($userInfo["bankName"] == "Standard Chartered Bank Nigeria PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>Standard Chartered Bank Nigeria PLC
                                                </option>


                                                <option
                                                    value="Sterling Bank PLC" <?php if ($userInfo["bankName"] == "Sterling Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>Sterling Bank PLC
                                                </option>


                                                <option
                                                    value="Union Bank of Nigeria PLC(UBN)" <?php if ($userInfo["bankName"] == "Union Bank of Nigeria PLC(UBN)") {
                                                    echo "selected = 'selected'";
                                                } ?>>Union Bank of Nigeria PLC(UBN)
                                                </option>


                                                <option
                                                    value="United Bank for Africa(UBA)" <?php if ($userInfo["bankName"] == "United Bank for Africa(UBA)") {
                                                    echo "selected = 'selected'";
                                                } ?>>United Bank for Africa(UBA)
                                                </option>


                                                <option
                                                    value="Unity Bank PLC" <?php if ($userInfo["bankName"] == "Unity Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>Unity Bank PLC
                                                </option>


                                                <option
                                                    value="Wema Bank PLC" <?php if ($userInfo["bankName"] == "Wema Bank PLC") {
                                                    echo "selected = 'selected'";
                                                } ?>>Wema Bank PLC
                                                </option>


                                                <option
                                                    value="Zenith Bank PLC" <?php if ($userInfo["bankName"] == "Zenith Bank PLC") {
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
                                                   value="<?php echo $userInfo['accName']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="accNum">
                                                Account Number
                                            </label>
                                            <input readonly type="text" pattern="[0-9]{10}" class="form-control"
                                                   id="accNum"
                                                   name="accNum" value="<?php echo $userInfo['accNum']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="phoneNum">
                                                Phone Number
                                            </label>
                                            <input readonly type="text" pattern="[0-9]{11}" class="form-control"
                                                   id="phoneNum"
                                                   name="phoneNum" value="<?php echo $userInfo['phoneNum']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="activated">Activated:</label>

                                            <select class="name_search form-control" name="activated" tabindex="-1"
                                                    style="display: none;">

                                                <option readonly="" value="0" <?php if (!$userInfo["activated"] == 1) {
                                                    echo "selected = 'selected'";
                                                } ?>>No
                                                </option>
                                                <option
                                                    value="1" <?php if ($userInfo["activated"] == 1) {
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
                                    <h5 class="panel-title" style="font-weight: bold;color: green;"><?php echo
                                        $groupToMergeWith; ?></h5>
                                </div>
                                <div class="panel-body">
                                    <small class="text-small margin-bottom-20" style="color:darkgreen">
                                        Click on merge and the users will be merged automatically
                                    </small>
                                    <br><br>
                                    <?php if (count($available) == 0) { ?>
                                        <div class="alert alert-info">
                                            No available users
                                        </div>
                                    <?php }
                                    else { ?>
                                        <table class="table table-striped table-bordered table-hover table-full-width"
                                               id="sample_1">
                                            <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Merge</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php foreach ($available as $payer) { ?>

                                                <tr>
                                                    <td>
                                                        <a href="admin_edit_user.php?u_id=<?php echo $payer['id']; ?>"><?php
                                                                echo $payer["username"]; ?></a>
                                                    </td>
                                                    <td>
                                                        <form method="post">
                                                            <input title="" name="payerId" style="display: none;"
                                                                   value="<?php echo $payer['id'] ?>">
                                                            <button type="submit" class="btn btn-success"
                                                                    name="merge">Merge
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>

                                            <?php } ?>

                                            </tbody>
                                        </table>

                                    <?php } ?>

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







