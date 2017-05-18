
<?php

    session_start();

    require_once "vendor/autoload.php";
    require_once "classes/config.php";
    use MerryPayout\User;
    use MerryPayout\Validate;
    use MerryPayout\LoginFormData;
    use MerryPayout\exceptions\NotVerifiedUserException;



    $dataManager = new \MerryPayout\DataManager();

    $attemptedLogin = false;
    $php_errormsg = "";
    $mmg = "";

    if (isset($_POST["login"])) {

        $attemptedLogin = true;


        if (!Validate::String($_POST['login_username']) ||
            !Validate::Password($_POST['login_password'])
        ) {
            $php_errormsg = "Some of your inputs are not valid";
        }
        else {
            $username = mb_strtolower($_POST['login_username']);
            $password = $_POST['login_password'];
            $formData = new LoginFormData($username, $password);
            try {
                $user = new User();
                $user->login($formData);
            }
            catch (NotVerifiedUserException $e) {
                $php_errormsg = $e->getMessage();
            }
            catch (\MerryPayout\exceptions\NotActivatedUserException $e) {
                $php_errormsg = $e->getMessage();
            }
        }
    }

?>

<?php

    $pageName = "signin";
    $title = "Sign In - Sign Up";

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
                            <img class="img-circle form-icon" src="assets/img/icon-118.png" alt=""/>
                            <div class="form-wrapper">
                                <div class="row">
                                    <div class="block-header">
                                        <h2 class="title">Login </h2>
                                        <div class="text">
                                            <div class="alert alert-info"><strong>We want to inform our users that we
                                                    have increased donation time to 12 hours.
                                                    </strong></div>
                                        </div>
                                    </div>
                                </div>
                                <form method="post">
                                    <?php
                                        if ($attemptedLogin) {
                                        if ($php_errormsg !== "") {
                                        echo "<div class='alert alert-danger'> $php_errormsg </div>";
                                        }
                                        elseif (!empty($user->getErrors()["loginErrors"])) {
                                        $errors = $user->getErrors()["loginErrors"];
                                        echo "<div class='alert alert-danger'>";
                                        foreach ($errors as $error) {
                                        echo "$error<br/>";
                                        }
                                        echo "</div>";
                                        }
                                        else {
                                        echo "<div class='alert alert-success'> Login successful </div>";
                                        }
                                        }
                                    ?>
                                    <div class="field-entry">
                                        <label for="field-1">Username *</label>
                                        <input type="text" name="login_username" id="field-1"/>
                                    </div>
                                    <div class="field-entry">
                                        <label for="field-2">Your Password *</label>
                                        <input type="password" name="login_password" id="field-2"/>
                                    </div>
                                    <a class="simple-link" href="forget_password"><span
                                            class="glyphicon glyphicon-chevron-right"></span>Forgot
                                        Password?</a><br/>
                                    <a class="simple-link" href="signup"><span
                                            class="glyphicon glyphicon-chevron-right"></span>Register Now</a><br/>
                                    <div class="button">Login<input type="submit" name="login" value=""/></div>
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