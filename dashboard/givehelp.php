<?php
    session_start();

    require_once "../vendor/autoload.php";

    $title = "Send Payment";

    $pagename = "givehelp";

    use MerryPayout\User;

    $user = new User();
    $user->checkAuth();

    $dataManager = new \MerryPayout\DataManager();
    $records = $dataManager->getAllRecipients();

?>

<?php

    require_once "includes/header.php";

?>
<body>

<div class="wrapper ">


    <?php require_once "includes/side-bar.php"; ?>
    <!-- left-bar -->
    <div class="content comic-sans" id="content">
        <div class="overlay"></div>
        <?php require_once "includes/top-bar.php"; ?>
        <!-- /top-bar -->
        <div class="main-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="row margin-top-30">
                        <div class="col-lg-8 col-md-12">
                            <?php if (count($records) > 0) { ?>
                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <h5 class="panel-title" style="color: black"><i class="fa fa-list"></i><strong>
                                            CURRENT LIST</strong></h5>
                                    <hr size="6" style="color: darkred; font-weight: bolder;">
                                    <div class="panel-body">
                                        <table class="table table-responsive">
                                            <thead>
                                            <tr>
                                                <th><strong>Trans ID</strong></th>
                                                <th><strong>Recipient</strong></th>
                                                <th><strong>Amount (Dollar)</strong></th>
                                                <th><strong>Amount (NGN)</strong></th>
                                                <th><strong>Action</strong></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                foreach ($records as $record) {
                                                    echo <<<HTML
                                            <tr>
                                                <td>{$record['trans_id']}</td>
                                                <td>{$record['recipient_name']}</td>
                                                <td>{$record['rem_amount']}</td>
                                                <td>{$record['amount_ngn']}</td>
                                                <td>
                                                    <a class="btn btn-success" 
                                                    href="reserve?u_id={$record['recipient_id']}">Reserve</a>
                                                </td>
                                                </tr>
HTML;
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php } else { ?>
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Message</h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>The list will be released as scheduled</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- row -->
            </div>

        </div>
    </div>
    <!-- wrapper -->


    <?php require_once "includes/footer.php"; ?>




