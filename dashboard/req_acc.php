<?php
    session_start();

    require_once "../vendor/autoload.php";

    $title = "Request Accumulated Earnings";
    $pagename = "req_acc";

    use MerryPayout\User;

    $user = new User();
    $user->checkAuth();

    $msg = "";
    if (isset($_POST['request'])) {

        if ($user->isPayer() || $user->isReceiver() || $user->isInList()) {
            $msg = "You cannot request your accumulated earnings now because you have an active transaction going on. Please
        try again when you do not have an active transaction.";
        }
        elseif (!$user->isValidForCollectingAccumulation()) {
            $msg = "You are not eligible to collect your accumulated earnings right now. Please read the how it works page to see why.";
        }
        elseif ($user->getAccumulatedEarnings() == 0) {
            $msg = "Your accumulated earnings is zero";
        }
        else {
            $user->addToList($user->getUserId(), $user->getAccumulatedEarnings(), false);
            $user->resetAccumulatedEarnings();
            $msg = "Your accumulated earnings will be paid to you shortly. Check the list to know when your name appears";
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
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Message</h3>
                            </div>
                            <div class="panel-body">
                                <form method="post">
                                <button type="submit" name="request"> Request Accumulated Earnings</button><br><br>
                                </form>
                                <p><?php
                                        echo $msg != '' ? $msg : "Click the button above to proceed";
                                    ?></p>
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





