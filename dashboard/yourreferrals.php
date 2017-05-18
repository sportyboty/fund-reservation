<?php
session_start();

require_once "../vendor/autoload.php";

$title = "List of your referrals";

$pagename = "yourreferrals";

use MerryPayout\User;

$user = new User();

$user->checkAuth();

$userInfo = $user->getDetails();


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

                <?php
                $ref = new \MerryPayout\Referrer($user->getUserId());
                $referredUsers = $ref->getAllReferredByName();
                ?>
                <div class="col-md-12">
                    <h5 class="over-title margin-bottom-15">All Referred Users <span class="text-bold">History</span></h5>
                    <?php if (count($referredUsers) > 0) { ?>
                    <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                        <thead>
                        <tr>
                            <th style="text-align: center;">Date</th>
                            <th style="text-align: center;">Username</th>
                            <th style="text-align: center;">Status</th>
                            <th style="text-align: center;">Bonus</th>
                            <th style="text-align: center;">Bonus Paid</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($referredUsers as $referred) {
                        ?>
                        <tr>
                            <td style="text-align: center;">
                                <?php print $referred['date_joined']; ?>
                            </td>
                            <td style="text-align: center;">
                                <?php print $referred['username']; ?>
                            </td>
                            <td style="text-align: center;">
                                <?php
                                    if($referred['pledge_count'] == 0)
                                    {
                                        print "<label class='label label-danger'>Inactive</label>";
                                    }
                                    elseif ($referred['activated'] > 0)
                                    {
                                        print "<label class='label label-success'>Active</label>";
                                    }
                                ?>
                            </td>
                            <td style="text-align: center;">
                                <?php print DOLLAR_SIGN.REF_BONUS ?>
                            </td>
                            <td style="text-align: center;">
                                <?php
                                    if($referred['ref_bonus_paid'] == 0)
                                    {
                                        print "<label class='label label-warning'>Pending</label>";
                                    }
                                    elseif ($referred['ref_bonus_paid'] == 1)
                                    {
                                        print "<label class='label label-success'>Paid</label>";
                                    }
                                ?>
                            </td>
                            <?php } ?>
                        </tr>
                        </tbody>
                    </table>
                    <?php } else { ?>
                        <div class="col-md-12">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Your Referrals</h3>
                                </div>
                                <div class="panel-body">
                                    <p>You haven't got any referrals yet. <a href="referral">Invite your friends using your affiliate link by clicking here!</a></p>

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


<?php require_once "includes/footer.php" ;?>




