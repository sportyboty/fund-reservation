<?php
session_start();

require_once "../vendor/autoload.php";

$title = "Send Emails ";

$page = "Welcome to Dashboard";

use NairaBank\User;

$user = new User();

$user->checkAuth();

$userInfo = $user->getDetails();


?>

<?php require_once "includes/header.php" ?>


    <body class="page-body page-left-in" data-url="#">
<div class="page-container">
<?php require_once "includes/side-bar.php"; ?>
    <div class="main-content">
<?php require_once "includes/top-bar.php"; ?>
    <hr/>
<?php require_once "includes/notify.php"; ?>


    <div class="col-md-6 col-md-offset-3">
        <style> p {
                font-size: 14px;
            } </style>
        <div class="panel panel-success" style="font-size: 20px;">
            <div class="panel-heading">Notification: <b>NOTIFICATION</b> <font style="font-size: 12px;">on 13th Feb,
                    2017 1:12PM</font></div>
            <div class="panel-body"><p>It came to our notice that some participant participate in the platform but
                    failed/refusing to make payment as at when due, all participant found guilty of such offence will be
                    suspended till further notice.</p>

                <p>Our participant hotlines and alternative emails still remains the same</p>

                <p>salvopay.org@yahoo.com</p>

                <p>asksalvopay.org@yahoo.com</p>

                <p>or call the participant careline on +2349020025773, +2349067687932</p>

                <p>Monday-Friday: 9:00am - 2:00pm, 5:00pm - 10:00pm</p>

                <p>Saturday: 12:00pm - 4:00pm</p>

                <p>Sunday: 6:00pm - 9:00pm</p>

                <p>Thank you for your patient</p>

                <p>LONG LIVE SALVOPAY.org</p>

                <p> </p></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-success" data-collapsed="0"> <!-- panel head -->
                <div class="panel-heading">
                    <div class="panel-title"><b>ACCOUNT UPGRADE</b></div>
                    <div class="panel-options"><a href="index.html#sample-modal" data-toggle="modal"
                                                  data-target="#sample-modal-dialog-1" class="bg"><i
                                class="entypo-cog"></i></a> <a href="index.html#" data-rel="collapse"><i
                                class="entypo-down-open"></i></a> <a href="index.html#" data-rel="reload"><i
                                class="entypo-arrows-ccw"></i></a> <a href="index.html#" data-rel="close"><i
                                class="entypo-cancel"></i></a>
                    </div>
                </div> <!-- panel body -->
                <div class="panel-body" style="display: block;">
                    <p align="center"><i class="fa fa-smile-o fa-5x"></i></p>
                    <p align="center" style="font-size: 14px;">Congratulation!!! Your account is eligible for an
                        upgrade </p>
                    <p align="center"><a href="http://salvopay.org/dashboard/upgrade.php" class="btn btn-success">
                            <i class="fa fa-check-circle"></i> Upgrade now!</a></p>

                    <p align="center" style="color: red; font-size: 14px;"> Your account will be blocked when your
                        upgrade duration elapses!</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-warning" data-collapsed="0"> <!-- panel head -->
                <div class="panel-heading">
                    <div class="panel-title"><b>DONATION PANEL</b></div>
                    <div class="panel-options"><a href="index.html#sample-modal" data-toggle="modal"
                                                  data-target="#sample-modal-dialog-1" class="bg"><i
                                class="entypo-cog"></i></a> <a href="index.html#" data-rel="collapse"><i
                                class="entypo-down-open"></i></a> <a href="index.html#" data-rel="reload"><i
                                class="entypo-arrows-ccw"></i></a> <a href="index.html#" data-rel="close"><i
                                class="entypo-cancel"></i></a>
                    </div>
                </div> <!-- panel body -->
                <div class="panel-body" style="display: block;">
                    <div class="text-center" style="margin-bottom: 10px;">
                        <a href="http://salvopay.org/dashboard/upgrade.php" class="btn btn-warning btn-block">
                            <i class="fa fa-money fa-spin"></i> You have been paired to make a donation
                        </a>
                    </div>

                    <div class="col-sm-4">
                        <img src="http://salvopay.org/asset/images/people/blank.jpg" alt="" class="img-circle"
                             style="width:120px;"/>
                    </div>

                    <div class="col-sm-8">
                        <table class="table">
                            <thead class="hidden">
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><b>Name</b></td>
                                <td><?php echo $userInfo['accName']?></td>
                            </tr>

                            <tr>
                                <td><b>Email</b></td>
                                <td><?php echo $userInfo['email'] ?></td>
                            </tr>

                            <tr>
                                <td><b>Phone</b></td>
                                <td><?php echo $userInfo['email']?></td>
                            </tr>


                            <tr>
                                <td><b>Username</b></td>
                                <td><?php echo $userInfo['username']?></td>
                            </tr>

                            <tr>
                                <td><b>Plan</b></td>
                                <td><b>Starter</b></td>
                            </tr>


                            <tr>

                                <td><b>Level</b></td>
                                <td>
                                    <span class="label label-danger">Free Account</span></td>
                            </tr>


                            </tbody>
                        </table>

                        <a href="http://salvopay.org/dashboard/update_profile.php" class="btn btn-success btn-block"> <i
                                class="fa fa-refresh"></i> Update Account details</a>
                    </div>


                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-sm-9">
            <div class="">

                <div class="tabs-vertical-env">
                    <ul class="nav tabs-vertical">
                        <!-- available classes "right-aligned" -->
                        <li class="active"><a href="index.html#v-bank" data-toggle="tab"><b>Payment Details</b></a></li>
                        <li class=""><a href="index.html#v-donated" data-toggle="tab"><b>Amount Donated</b></a></li>
                        <li class=""><a href="index.html#v-received" data-toggle="tab"><b>Amount Received</b></a></li>
                        <li class=""><a href="index.html#v-expected" data-toggle="tab"><b>Expected Returns</b></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="v-bank">
                            <div class="table-responsive">
                                <h3>Bank Account Details</h3>
                                <table class="table">
                                    <thead class="hidden">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Bank Name</td>
                                        <td><?php echo $userInfo['bankName']?></td>
                                    </tr>

                                    <tr>
                                        <td>Account Name</td>
                                        <td><?php echo $userInfo['accName']?></td>
                                    </tr>

                                    <tr>
                                        <td>Account Number</td>
                                        <td><?php echo $userInfo['accNum']?></td>
                                    </tr>


                                    </tbody>
                                </table>
                                <div class="">
                                    <a href="http://salvopay.org/dashboard/update_bank_account.php"
                                       class="btn btn-default btn-icon icon-left"><i class="fa fa-cloud"></i> Update
                                        Bank account</a>

                                </div>
                            </div>

                        </div>
                        <div class="tab-pane" id="v-donated">
                            <h3>Total Amount Donated</h3>
                            <h5 class="text-bold article text-danger"><i class="fa fa-warning"></i> You are on a free
                                trial account and you have been paired to make &#8358;5,000.
                                Please make sure you quickly make your donation else your account will be blocked <br>
                            </h5>
                            <!--<a href="upgrade" class="btn btn-default btn-icon icon-left"><i class="fa fa-money"></i>Make donation now!</a>-->


                        </div>
                        <div class="tab-pane" id="v-received">
                            <h3>Total Amount Received</h3>
                            <h5 class="text-bold article text-danger"><i class="fa fa-warning"></i> Your account cannot
                                receive any donation until you upgrade! </h5><br>
                            <!--  <a href="upgrade" class="btn btn-default btn-icon icon-left"><i class="fa fa-upload"></i> Upgrade now!</a>-->
                        </div>
                        <div class="tab-pane" id="v-expected">
                            <h3>Expected Returns (STARTER)</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th><i class="fa fa-level-down"></i> Levels</th>
                                        <th><i class="fa fa-sitemap"></i> Downlines</th>
                                        <th><i class="fa fa-cubes"></i> Upgrade Fees</th>
                                        <th><i class="fa fa-money"></i> Returns</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>&#8358;5,000</td>
                                        <td>&#8358;10,000</td>
                                    </tr>

                                    <tr>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>&#8358;5,000</td>
                                        <td>&#8358;15,000</td>
                                    </tr>


                                    <tr>
                                        <td>3</td>
                                        <td>5</td>
                                        <td>&#8358;10,000</td>
                                        <td>&#8358;50,000</td>
                                    </tr>


                                    <tr>
                                        <td>4</td>
                                        <td>5</td>
                                        <td>&#8358;20,000</td>
                                        <td>&#8358;100,000</td>
                                    </tr>


                                    <tr>
                                        <td>5</td>
                                        <td>10</td>
                                        <td>&#8358;50,000</td>
                                        <td>&#8358;500,000</td>
                                    </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
        <div class="col-sm-3">

        </div>
    </div>

<?php require_once "includes/footer.php"; ?>