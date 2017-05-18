<?php
    session_start();

    require_once "../vendor/autoload.php";

    $title = "Update your account ";

    $page = "Update your account";

    use MerryPayout\Admin;
    use MerryPayout\Validate;
    use MerryPayout\AdminEditForm;

    $admin = new Admin();

    $admin->checkAuth();

    $php_errormsg = "";

    $uId = $_GET['u_id'];
    $userInfo = $admin->getUserDetails($uId);

    $hasError = false;


    if (isset($_POST['update_profile'])) {

        $pwd1 = isset($_POST['password']) ? $_POST['password'] : null;
        $pwd2 = isset($_POST['password2']) ? $_POST['password2'] : null;

        if ($pwd1 != null && $pwd2 != null && trim($pwd1) != "" && trim($pwd2) != "" && $pwd1 !== $pwd2) {
            $hasError = true;
            $php_errormsg = "The passwords do not match";
        }
        elseif (!Validate::String($_POST['username'])) {
            $hasError = true;
            $php_errormsg = "Invalid username";
        }
        elseif (!Validate::AccountNumber($_POST['accNum'])) {
            $hasError = true;
            $php_errormsg = "Invalid account number. account number must be 10 digits. ";
        }
        elseif (!Validate::PhoneNumber($_POST['phoneNum'])) {
            $hasError = true;
            $php_errormsg = "Invalid phone number, phone number must be 11 digits";
        }
        elseif (!Validate::Email($_POST['email'])) {
            $hasError = true;
            $php_errormsg = "Invalid email address";
        }
        elseif (!Validate::String($_POST['accName'])) {
            $hasError = true;
            $php_errormsg = "Invalid account name";
        }
        else {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $bankName = $_POST['bankName'];
            $accName = $_POST['accName'];
            $accNum = $_POST['accNum'];
            $phoneNum = $_POST['phoneNum'];
            $activated = $_POST['activated'];
            $validDonor = $_POST['valid_donor'];
            $valid_receiver = $_POST['valid_receiver'];


            $formData = new AdminEditForm($uId, $username, $pwd1, $email, $bankName, $accName, $accNum,
                $phoneNum, $activated, $validDonor, $valid_receiver);

            try {
                $admin->editUser($formData);
                $php_errormsg = "You have successfully updated this user";
            }
            catch (Exception $e) {
                $hasError = true;
                $php_errormsg = $e->getMessage();
            }

        }


    }
?>

<?php

    require_once "includes/header.php";

?>
<body>

<div class="wrapper ">


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
                                    <h5 class="panel-title">Manage User profile</h5>
                                </div>
                                <div class="panel-body">
                                    <?php

                                        if ($php_errormsg != "") {
                                            if ($hasError) {
                                                echo "<div class='alert alert-danger'>" . $php_errormsg . "</div>";
                                            }
                                            else {
                                                echo "<div class='alert alert-success'>" . $php_errormsg . "</div>";
                                            }
                                        }

                                        if (isset($_GET['u_id'])) {
                                            if (Validate::Number($_GET['u_id'])) {
                                                $userId = $_GET['u_id'];
                                                $userInfo = $admin->getUserDetails($userId);
                                            }
                                        }

                                    ?>

                                    <p class="text-small margin-bottom-20">
                                        Please keep an up to date profile with MerryPayout. You can set your payment
                                        accounts
                                        here, all withdrawals will be sent to these payment accounts. In case one of
                                        your
                                        account changes, contact support, so it can be modified by our staff.
                                    </p>
                                    <form role="form" method="post">
                                        <div class="form-group">
                                            <label for="username">
                                                Username
                                            </label>
                                            <input class="form-control" id="username" name="username"
                                                   value="<?php echo $userInfo['username']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="password">
                                                Password
                                            </label>
                                            <input class="form-control" id="password" name="password">
                                        </div>

                                        <div class="form-group">
                                            <label for="retype-password">
                                                Retype Password
                                            </label>
                                            <input class="form-control" id="retype-password" name="password2">
                                        </div>

                                        <div class="form-group">
                                            <label for="email">
                                                Email
                                            </label>
                                            <input type="text" class="form-control" id="email" name="email"
                                                   value="<?php echo $userInfo['email']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="bankName">Bank Name:</label>

                                            <select class="name_search form-control" name="bankName" tabindex="-1"
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
                                            <input type="text" class="form-control" id="accName" name="accName"
                                                   value="<?php echo $userInfo['accName']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="accNum">
                                                Account Number
                                            </label>
                                            <input type="text" pattern="[0-9]{10}" class="form-control" id="accNum"
                                                   name="accNum" value="<?php echo $userInfo['accNum']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="phoneNum">
                                                Phone Number
                                            </label>
                                            <input type="text" pattern="[0-9]{11}" class="form-control" id="phoneNum"
                                                   name="phoneNum" value="<?php echo $userInfo['phoneNum']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="activated">Activated:</label>

                                            <select class="name_search form-control" name="activated" tabindex="-1"
                                                    style="display: none;">

                                                <option value="0" <?php if (!$userInfo["activated"] == 1) {
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

                                        <div class="form-group">
                                            <label for="bankName">Valid for Provide Help:</label>

                                            <select class="name_search form-control" name="valid_donor" tabindex="-1"
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

                                            <select class="name_search form-control" name="valid_receiver" tabindex="-1"
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
                                        <button name="update_profile" type="submit" class="btn btn-o btn-primary">
                                            Update Profile
                                        </button>
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
