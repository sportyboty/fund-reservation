<?php
session_start();

set_time_limit(120);
require_once "../vendor/autoload.php";
require_once "../vendor/phpmailer/phpmailer/PHPMailerAutoload.php";

$title = "Incoming Transaction";

$pagename = "incoming";

use MerryPayout\User;

$user = new User();
$user->checkAuth();

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
                <?php if ($user->isReceiver()) {
                    $receiver = new \MerryPayout\Receiver($user->getUserId());
                    $payers = $receiver->getPayers();
                    ?>
                    <table class="table table-striped table-bordered table-hover table-full-width" id="users_table">
                        <thead>
                        <tr>
                            <th style="text-align: center;">Trans ID</th>
                            <th style="text-align: center;">Username</th>
                            <th style="text-align: center;">Account Name</th>
                            <th style="text-align: center;">Phone</th>
                            <th style="text-align: center;">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($payers as $payer) {
                        ?>
                        <tr>
                            <td style="text-align: center;">
                                <?php print $payer['id']; ?>
                            </td>
                            <td style="text-align: center;">
                                <a href=""><?php print $payer['username']; ?> </a>
                            </td>
                            <td style="text-align: center;">
                                <?php print $payer['accName']; ?>
                            </td>
                            <td style="text-align: center;">
                                <a href=""><?php print $payer['phoneNum']; ?> </a>
                            </td>
                            <td style="text-align: center;">

                                <label class='label label-warning'>Pending</label>
                            </td>
                            <?php } ?>
                        </tr>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Message</h3>
                                </div>
                                <div class="panel-body">
                                    <p>You do not currently have incoming transactions</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- row -->
        </div>
    </div>
</div>
<!-- wrapper -->


<?php require_once "includes/footer.php"; ?>
