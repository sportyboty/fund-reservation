<?php

    session_start();

    require_once "vendor/autoload.php";
    require_once "classes/config.php";
    require_once "vendor/phpmailer/phpmailer/PHPMailerAutoload.php";


    use MerryPayout\User;
    use MerryPayout\Validate;
    use MerryPayout\SignUpFormData;


    $user = new User();

    $attemptedLogin = false;
    $attemptedSignUp = false;
    $php_errormsg = "";
    $mmg = "";

    if(isset($_POST["signUp"])) {
        $attemptedSignUp = true;

        $pwd1 = isset($_POST['password']) ? $_POST['password'] : null;
        $pwd2 = isset($_POST['password_again']) ? $_POST['password_again'] : null;

        if ($pwd1 != null && $pwd2 != null && trim($pwd1) != "" && trim($pwd2) != "" && $pwd1 !== $pwd2) {
            $php_errormsg = "The passwords do not match";
        }
        elseif (!Validate::String($_POST['username'])) {
            $php_errormsg = "Invalid username";
        }
        elseif (!Validate::Password($_POST['password'])) {
            $php_errormsg = "Invalid password";
        }
        elseif (!Validate::AccountNumber($_POST['accNum'])) {
            $php_errormsg = "Invalid account number. account number must be 10 digits. ";
        }
        elseif (!Validate::PhoneNumber($_POST['phoneNum'])) {
            $php_errormsg = "Invalid phone number, phone number must be 11 digits";
        }
        elseif (!Validate::Email($_POST['email'])) {
            $php_errormsg = "Invalid email address";

        }

        else {
            $username = mb_strtolower($_POST['username']);
            $password = $_POST['password'];
            $email = $_POST['email'];
            $bankName = $_POST['bankName'];
            $accName = $_POST['accName'];
            $accNum = $_POST['accNum'];
            $phoneNum = $_POST['phoneNum'];
            $formData = new SignUpFormData($username, $password, $email, $bankName, $accNum, $accName, $phoneNum);
            $dataManager = new \MerryPayout\DataManager();
            if (isset($_GET['ref_id']) && $dataManager->isRegisteredUser($_GET['ref_id']))
            {
                $formData->setRefId($_GET['ref_id']);
            }
            $user->create($formData);
            // save the file to uploads directory

        }
    }

?>

<?php

    $pageName = "signup";
    $title = "Sign Up";

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

                        <div class="clear"></div>

                        <div class="col-md-6 col-md-offset-3 wow fadeInUp" id="register">
                            <div class="form-block">
                                <img class="img-circle form-icon" src="assets/img/icon-119.png" alt=""/>

                                <div class="form-wrapper">
                                    <div class="row">
                                        <div class="block-header">
                                            <h2 class="title">Registration Form</h2>
                                            <div class="text">
                                                We want to inform our users that we have increased donation time
                                                to 12 hours..
                                            </div>
                                        </div>
                                    </div>
                                    <form method="post">
                                        <?php
                                            if ($attemptedSignUp) {
                                                if ($php_errormsg !== "") {
                                                    echo "<div class='alert alert-danger'> $php_errormsg </div>";
                                                }
                                                elseif (!empty($user->getErrors()["signUpErrors"])) {
                                                    $errors = $user->getErrors()["signUpErrors"];
                                                    echo "<div class='alert alert-danger'>";
                                                    foreach ($errors as $error) {
                                                        echo "$error<br/>";
                                                    }
                                                    echo "</div>";
                                                }
                                                else {
                                                    echo "<div class='alert alert-success'> You have successfully 
                                                    created an account with MerryPayout. We will now send a 
                                                    verification link to your email account in a moment. Please check
                                                     your inbox and verify your email to activate your account. 
                                                    </div>";
                                                }
                                            }
                                        ?>
                                        <div class="field-entry">
                                            <label for="username">Username *</label>
                                            <input type="text" name="username" id="username">
                                        </div>
                                        <div class="field-entry">
                                            <label for="email">Email * <span style="color: red">you must enter a
                                                    valid email in order to activate your account.
                                                </span> </label>
                                            <input type="email" name="email" id="email">
                                        </div>

                                        <div class="field-columns">
                                            <div class="">
                                                <div class="field-entry">
                                                    <label for="password">Password *</label>
                                                    <input type="password" name="password" id="password">
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="field-entry">
                                                    <label for="password_again">Re-type password *</label>
                                                    <input type="password" name="password_again" id="password_again">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-columns">
                                            <div class="">
                                                <div class="field-entry">
                                                    <label for="bankName">Bank Name *</label>
                                                    <select id="bankName" class="form-control" name="bankName"
                                                            tabindex="-1">
                                                        <option value="">Select your bank</option>

                                                        <option
                                                            value="Access Bank PLC">Access Bank PLC
                                                        </option>

                                                        <option
                                                            value="Citibank Nigeria LTD">Citibank Nigeria LTD
                                                        </option>

                                                        <option
                                                            value="Diamond Bank PLC">Diamond Bank PLC
                                                        </option>


                                                        <option
                                                            value="Ecobank Nigeria PLC">Ecobank Nigeria PLC
                                                        </option>


                                                        <option
                                                            value="Fidelity Bank PLC">Fidelity Bank PLC
                                                        </option>


                                                        <option
                                                            value="First bank of Nigeria PLC">First bank of Nigeria
                                                            PLC
                                                        </option>


                                                        <option
                                                            value="First City Monument Bank PLC">First City Monument
                                                            Bank PLC
                                                        </option>

                                                        <option
                                                            value="Guaranty Trust Bank">Guaranty Trust Bank
                                                        </option>

                                                        <option
                                                            value="Heritage Bank">Heritage Bank
                                                        </option>

                                                        <option
                                                            value="Jaiz Bank">Jaiz Bank
                                                        </option>

                                                        <option
                                                            value="Keystone Bank PLC">Keystone Bank PLC
                                                        </option>

                                                        <option
                                                            value="Skye Bank PLC">Skye Bank PLC
                                                        </option>


                                                        <option
                                                            value="Stanbic IBTC Bank PLC">Stanbic IBTC Bank PLC
                                                        </option>


                                                        <option
                                                            value="Standard Chartered Bank Nigeria PLC">Standard
                                                            Chartered Bank Nigeria PLC
                                                        </option>


                                                        <option
                                                            value="Sterling Bank PLC">Sterling Bank PLC
                                                        </option>


                                                        <option
                                                            value="Union Bank of Nigeria PLC(UBN)">Union Bank of
                                                            Nigeria PLC(UBN)
                                                        </option>


                                                        <option
                                                            value="United Bank for Africa(UBA)">United Bank for
                                                            Africa(UBA)
                                                        </option>


                                                        <option
                                                            value="Unity Bank PLC">Unity Bank PLC
                                                        </option>


                                                        <option
                                                            value="Wema Bank PLC">Wema Bank PLC
                                                        </option>


                                                        <option
                                                            value="Zenith Bank PLC">Zenith Bank PLC
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="field-entry">
                                                    <label for="accName">Account Name *</label>
                                                    <input type="text" name="accName" id="accName">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="field-columns">
                                            <div class="">
                                                <div class="field-entry">
                                                    <label for="accNum">Account Number *</label>
                                                    <input type="text" pattern="[0-9]{10}" name="accNum" id="accNum">
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="field-entry">
                                                    <label for="phoneNum">Phone Number *</label>
                                                    <input type="text" pattern="[0-9]{11}" name="phoneNum"
                                                           id="phoneNum">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-6">
                                                    <h5>Solve</h5>
                                                    <span id="hint"></span><br>
                                                    <span id="first"></span>
                                                    <span> + </span>
                                                    <span id="second"></span>
                                                    <span> = </span>
                                                    <input type="text" name="ans" title="ans" id="ans"
                                                           style="width: 40px;padding: 3px;"/>
                                                    <input type="button" class="btn btn-info" title="sum"
                                                           value="Ok"
                                                           onclick="chkSum();">

                                                    <script>
                                                        setNewQuestion();

                                                        function chkSum() {
                                                            var firstNum = parseInt(document.getElementById("first")
                                                                .innerHTML);
                                                            var secondNum = parseInt(document.getElementById("second")
                                                                .innerHTML);
                                                            var ans = parseInt(document.getElementById("ans")
                                                                .value);
                                                            var sum = firstNum + secondNum;
                                                            console.log(sum);
                                                            console.log(ans);

                                                            if (sum !== ans) {
                                                                document.getElementById("hint").innerHTML =
                                                                    "<span style='color: red;'>Incorrect</span>";
                                                                setNewQuestion();
                                                            }
                                                            else {
                                                                document.getElementById("hint").innerHTML =
                                                                    "<span style='color: green;'>Correct. You can" +
                                                                    " now register </span>";
                                                                document.getElementById("signUp").removeAttribute
                                                                ("disabled");
                                                            }
                                                        }

                                                        function setNewQuestion() {
                                                            var f = Math.round(Math.random() * 10);
                                                            var s = Math.round(Math.random() * 10);
                                                            document.getElementById("first").innerHTML = f;
                                                            document.getElementById("second").innerHTML = s;
                                                        }

                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                        <br>

                                        <input type="submit" class="button" name="signUp" id="signUp" value="Register"
                                               data-loading-text="Loading..."
                                               disabled>
                                    </form>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


        </div>

    </div>

<?php require_once "includes/footer.php"; ?>