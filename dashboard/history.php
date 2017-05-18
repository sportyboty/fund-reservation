<?php
ob_start();
session_start();

require_once "../vendor/autoload.php";

$title = "History of your recent transactions";

$pagename = "history";

use MerryPayout\User;

$user = new User();
$user->checkAuth();

$details = $user->getAllHistory();



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
                    <form role="form" method="post">
                        <div class="form-group">
                            <label for="type">
                                Transaction History
                            </label>

                        </div>
                    </form>
                    <h4 class="over-title margin-bottom-15"></strong></h4>
                    <?php if (count($details) > 0) { ?>
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                        <tr>
                            <th>Trans</th>
                            <th>Payer</th>
                            <th>Payee</th>
                            <th>Amount ($)</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($details as $detail) {
                        ?>
                        <tr>
                            <td><?php echo $detail['id']; ?></td>
                            <td><?php echo $detail['payerUsername']; ?></td>
                            <td><?php echo $detail['receiverUsername']; ?></td>
                            <td><?php echo $detail['amount']; ?></td>
                            <td><?php echo $detail['date']; ?></td>

                            <td><?php echo $detail['confirm_status'] == 1 ? "successful" : "pending"; ?></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <?php } else { ?>
                        <div class="col-md-12">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Your Transaction history</h3>
                                </div>

                                <div class="panel-body">
                                    <p>You haven't got any transaction yet. <a href="givehelp">Click here to reserve and start making money!</a></p>

                                </div>

                            </div>

                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- wrapper -->


<?php require_once "includes/footer.php"; ?>




