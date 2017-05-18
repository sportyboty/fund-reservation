
<?php

    require_once "vendor/autoload.php";
    require_once "classes/config.php";
    require_once "vendor/phpmailer/PHPMailerAutoload.php";

    use MerryPayout\Validate;
    $dataManager = new \MerryPayout\DataManager();

    $submitted = false;
    $hasErrors = false;
    $php_errormsg = "";

    if (isset($_POST["forgetPass"])) {
        $submitted = true;

        $email = $_POST['email'];

        if (!Validate::Email($email)
        ) {
            $hasErrors = true;
            $php_errormsg = "Invalid Email Address";
        }

        elseif (!$dataManager->emailExists($email)) {
            $hasErrors = true;

            $php_errormsg = "The email does not exist";
        }
        else {
            $app = new \MerryPayout\App();
            $userId = $dataManager->getUserIdByEmail($email);
            $app->sendPasswordResetToken($email, $userId);
        }
    }

?>

<?php

    $pageName = "signin";
    $title = "Forgot Password";

?>

<?php require_once 'includes/header.php'; ?>
<body class="header-moved loaded colour-1">

<!-- HEADER -->
<?php require_once 'includes/nav.php'; ?>

<div id="content-wrapper">

    <?php require_once 'includes/news.php';?>
        <div class="blocks-container">

            <!-- BLOCK "TYPE 18" -->
            <div class="block">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 wow fadeInUp">
                            <div class="form-block">
                                <img class="img-circle form-icon" src="img/icon-118.png" alt=""/>
                                <div class="form-wrapper">
                                    <div class="row">
                                        <div class="block-header">
                                            <h2 class="title">Forget password </h2>
                                        </div>
                                    </div>
                                    <form method="post">
                                        <?php
                                            $style = "style='color:red;background-color:white;font-weight:bold'";
                                            if ($submitted) {
                                                if ($php_errormsg !== "") {
                                                    echo "<div class='alert alert-danger' $style> $php_errormsg </div>";
                                                }
                                                else {
                                                    echo "<div class='alert alert-success'> We have sent a password 
                                                    reset link to your email. Check your Inbox and follow the 
                                                    instructions to reset your password.
                                                    </div>";
                                                }
                                            }

                                        ?>

                                        <div class="field-entry">
                                            <label for="field-1">Email *</label>
                                            <input type="text" name="email" id="field-1"/>
                                        </div>
                                        <div class="button">Submit<input type="submit" name="forgetPass"></div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="clear"></div>

                    </div>
                </div>
            </div>


        </div>

    </div>

<?php require_once "includes/footer.php"; ?>