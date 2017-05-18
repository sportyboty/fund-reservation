<?php
    session_start();

    require_once "../vendor/autoload.php";

    $title = "Referral";

    $pagename = "referral";

    use MerryPayout\User;

    $user = new User();
    $user->checkAuth();

    $userInfo = $user->getDetails();

    $ref = new \MerryPayout\Referrer($user->getUserId());


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
                    <div class="row margin-top-30">
                        <div class="col-lg-12 col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <h5 class="panel-title">Referral Program</h5>
                                </div>
                                <div class="panel-body">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                                            <li class="active">
                                                <a data-toggle="tab" href="#panel_overview" aria-expanded="true">
                                                    Affiliate Link
                                                </a>
                                            </li>
                                            <li class="">
                                                <a data-toggle="tab" href="#panel_edit_account" aria-expanded="false">
                                                    Banners
                                                </a>
                                            </li>
                                            <li class="">
                                                <a data-toggle="tab" href="#panel_projects" aria-expanded="false">
                                                    Statistics
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="panel_overview" class="tab-pane fade active in">
                                                <form action="#" role="form" id="form">
                                                    <fieldset>
                                                        <legend>
                                                            Your Affiliate Link
                                                        </legend>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label" for="affiliateurl">
                                                                        Affiliate URL
                                                                    </label>
                                                                    <input type="text" class="form-control"
                                                                           id="affiliateurl"
                                                                           value="https://twilightfunds.com/signin?ref_id=<?php
                                                                               echo $user->getUserId(); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </form>
                                            </div>
                                            <div id="panel_edit_account" class="tab-pane fade">
                                                <div class="alert alert-info">Coming Soon</div>
                                            </div>
                                            <div id="panel_projects" class="tab-pane fade">
                                                <div class="row">
                                                    <div class="col-sm-5 col-md-4">
                                                        <div class="user-left">
                                                            <table class="table">
                                                                <thead>
                                                                <div class="alert alert-info">Coming Soon</div>
                                                                <tr>
                                                                    <th colspan="3">Affiliate Program Info</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>Your Affiliates</td>
                                                                    <td><?php echo $ref->getAllReferred(); ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Active Affiliates</td>
                                                                    <td><?php echo $ref->getAllActiveReferralsCount();
                                                                        ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Affiliate Earnings</td>
                                                                    <td><?php echo DOLLAR_SIGN . $ref->refBonus();
                                                                        ?></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-7 col-md-8">
                                                        <div class="panel panel-white" id="activities">
                                                            <div class="panel-heading border-light">
                                                                <h4 class="panel-title text-primary">Recent
                                                                    Earnings</h4>
                                                                <paneltool class="panel-tools"
                                                                           tool-collapse="tool-collapse"
                                                                           tool-refresh="load1"
                                                                           tool-dismiss="tool-dismiss"></paneltool>
                                                            </div>
                                                            <div collapse="activities" ng-init="activities=false"
                                                                 class="panel-wrapper">
                                                                <div class="panel-body">
                                                                    <ul class="timeline-xs">
                                                                        <li class="timeline-item">
                                                                            <div class="margin-left-15"><p>No referral
                                                                                    earnings yet.</p></div>
                                                                        </li>
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




