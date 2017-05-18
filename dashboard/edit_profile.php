<?php
session_start();

require_once "../vendor/autoload.php";

use MerryPayout\Validate;

$title = "Edit your profile ";

$pagename = "editprofile";

use MerryPayout\User;

$user = new User();
$user->checkAuth();
$userInfo = $user->getDetails();

$msg = "";
$submitted = false;

if (isset($_POST['update_profile'])) {
    $submitted = true;
    $bankName = $_POST['bankName'];
    $accName = $_POST['accName'];
    $accNum = $_POST['accNum'];
    $phoneNum = $_POST['phoneNum'];
    $profPic = $_FILES["profPic"]["name"];
    $profPic_tmp = $_FILES["profPic"]["tmp_name"];
    $upload_dir = 'upload';
    move_uploaded_file($profPic_tmp, "$upload_dir/$profPic");


    if (!Validate::String($bankName)) {
        $msg = "<div class=\"alert alert-danger\"> Bank name is invalid</div>";
    }
    elseif (!Validate::String($accName)) {
        $msg = "<div class=\"alert alert-danger\"> Account name is invalid</div>";
    }
    elseif (!Validate::AccountNumber($accNum)) {
        $msg = "<div class=\"alert alert-danger\"> Account number is invalid</div>";
    }
    elseif (!Validate::PhoneNumber($phoneNum)) {
        $msg = "<div class=\"alert alert-danger\"> Phone number is invalid</div>";
    }
    elseif ($profPic != "") {
        if (!Validate::Image($_FILES["profPic"])) {
            $msg = "<div class='alert alert-danger'> Invalid image format </div>";
        }
        else {
            $user->userUpdate($bankName, $accName, $accNum, $phoneNum, $profPic);
            $msg = "<div class=\"alert alert-success\"> successfully updated your profile</div>";
        }

    }
    else {
        $user->userUpdate($bankName, $accName, $accNum, $phoneNum, $profPic);
        $msg = "<div class=\"alert alert-success\"> successfully updated your profile</div>";
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
                                    <h5 class="panel-title">Edit Profile</h5>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    if ($msg !== "") {
                                        echo $msg;
                                    }
                                    ?>
                                    <p class="text-small margin-bottom-20">
                                        Please keep an up to date profile with MerryPayout. You can set your payment
                                        accounts here, all withdrawals will be sent to these payment accounts. In
                                        case one of your account changes, contact support, so it can be modified by
                                        our staff.
                                    </p>
                                    <form role="form" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="username">
                                                Username
                                            </label>
                                            <input readonly class="form-control" id="username" name="username"
                                                   value="<?php echo $userInfo['username']; ?>">
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
                                            <label for="profPic">
                                                Profile Pic
                                            </label>
                                            <input type="file" class="form-control" id="profPic"
                                                   name="profPic">
                                        </div>
                                        <button name="update_profile" type="submit" class="btn btn-o btn-primary">
                                            Update Profile
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <h5 class="panel-title">Your Profile</h5>
                                </div>
                                <div class="panel-body">
                                    <p class="text-small margin-bottom-20">
                                        You can set your name &amp; your payment accounts using this form.
                                    </p>
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







