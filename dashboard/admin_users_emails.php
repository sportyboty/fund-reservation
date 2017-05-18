<?php
    session_start();

    require_once "../vendor/autoload.php";

    $title = "Update your account ";

    $page = "Update your account";

    use MerryPayout\Admin;

    $admin = new Admin();

    $admin->checkAuth();

    $activeUsers = $admin->getActiveUsersEmail();
    $allUsers = $admin->getEmails();
    $inactiveUsers = $admin->getInActiveUsersEmail();


?>

<?php

    require_once "includes/header.php";

?>
<body>

<div class="wrapper ">


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
                        <div class="col-lg-6 col-md-12">
                            <div class="panel panel-white">
                                <div class="panel-heading">
                                    <h5 class="panel-title">Manage User profile</h5>
                                </div>
                                <div class="panel-body">

                                    <p class="text-small margin-bottom-20">
                                        Please keep an up to date profile with MerryPayout. You can set your payment
                                        accounts
                                        here, all withdrawals will be sent to these payment accounts. In case one of
                                        your
                                        account changes, contact support, so it can be modified by our staff.
                                    </p>

                                    <textarea rows="20" class="form-control">
                                        <?php $allUsers = implode(' , ' ,$allUsers);
                                            echo $allUsers;
                                                ?>
                                    </textarea>

                                    <textarea rows="20" class="form-control">
                                        <?php $activeUsers = implode(' , ' ,$activeUsers);
                                            echo $activeUsers;
                                        ?>
                                    </textarea>

                                    <textarea rows="20" class="form-control">
                                        <?php $inactiveUsers = implode(' , ' ,$inactiveUsers);
                                            echo $inactiveUsers;
                                        ?>
                                    </textarea>
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
