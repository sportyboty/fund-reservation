<?php
session_start();

require_once "../vendor/autoload.php";

$title = "Change password ";

$pagename = "changepassword";

use MerryPayout\User;
use MerryPayout\Validate;

$user = new User();
$user->checkAuth();
$userInfo = $user->getDetails();
$msg = "";

if (isset($_POST['change_password'])) {
    $oldpass = $_POST['password'];
    $pass1 = $_POST['new-password'];
    $pass2 = $_POST['confirm-new-password'];


    if (!Validate::Password($oldpass) || !Validate::Password($pass1) || !Validate::Password($pass2)) {
        $msg = "<div class=\"alert alert-danger\"> Some Input are not valid</div>";
    }
    elseif ($pass1 !== $pass2) {
        $msg = "<div class=\"alert alert-danger\"> Password do not match</div>";
    }

    else{
        if ($user->comparePass($oldpass))
        {
            $user->changePassword($pass1);
            $msg = "<div class=\"alert alert-success\"> You have successful changed your password</div>";
        }
        else{
            $msg = "<div class=\"alert alert-danger\">Old password do not match our record </div>";
        }
    }
}


?>




<?php

require_once "includes/header.php";

?>
<body>

<div class="wrapper comic-sans">


    <?php require_once "includes/side-bar.php";?>
    <!-- left-bar -->
    <div class="content" id="content">

        <div class="overlay"></div>

        <?php require_once "includes/top-bar.php" ; ?>
        <!-- /top-bar -->
        <div class="main-content">

            <div class="row">
                <div class="col-md-12">
                    <div class="row margin-top-30">
                        <div class="col-lg-6 col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <h5 class="panel-title">Change Password</h5>
                                </div>

                                <?php

                                if ($msg !== "")
                                {
                                    echo $msg;
                                }

                                ?>
                                <div class="panel-body">
                                    <p class="text-small margin-bottom-20">
                                        To change your password please complete the form below. Your password will be changed instantly.
                                    </p>
                                    <form role="form" method="post">
                                        <div class="form-group">
                                            <label for="password">
                                                Current Password
                                            </label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Current Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="new-password">
                                                New Password
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                <input type="password" class="form-control" name="new-password" id="new-password" placeholder="New Password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm-new-password">
                                                Confirm New Password
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                <input type="password" class="form-control" name="confirm-new-password" id="confirm-new-password" placeholder="New Password Confirmation">
                                            </div>
                                        </div>

                                        <button name="change_password" type="submit" class="btn btn-o btn-primary">
                                            Change Password
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <h5 class="panel-title">Account Security</h5>
                                </div>
                                <div class="panel-body">
                                    <p class="text-small margin-bottom-20">
                                        Please keep your MerryPayout Account Secure by completing the following steps. We are working with real money here, so guard your account information with the same care as your bank account information or wallet.
                                    </p>
                                    <ul>
                                        <li>Use a secure password mixed with lower, uppercase chars, numbers &amp; special characters.</li>
                                        <li>Example Random Generated password: <code>t1wsC]ch~ZRj2uA</code></li>
                                        <li>Never use the same password on different websites.</li>
                                        <li>Use Anti-Virus protection on your computer, and scan for viruses regularly.</li>
                                        <li>Do not click to links inside e-mails from unknown senders.</li>
                                        <li>Always log out from your account when using shared computers.</li>
                                    </ul>
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


<?php require_once "includes/footer.php" ;?>

