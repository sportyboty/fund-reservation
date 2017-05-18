<?php
    session_start();

    set_time_limit(120);
    require_once "../vendor/autoload.php";
    require_once "../vendor/phpmailer/phpmailer/PHPMailerAutoload.php";

    $title = "All Users in List";

    $pagename = "list";

    use MerryPayout\Admin;


    $app = new \MerryPayout\App();
    $app->deleteAllExpiredTransactions();

    $admin = new Admin();
    $admin->checkAuth();
    $allUsers = $admin->getUsersInList();

    if (isset($_POST['publish_list'])) {
        $admin->releaseNewList();
    }

    if (isset($_POST['search'])) {
        $allUsers = $admin->searchUserByUsername($_POST['search_name']);
    }

?>


<?php
    $userInfo = $admin->getDetails();
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

                <div style="text-align: center;">
                    <form method="post">
                        <input type="submit" name="publish_list" class="btn btn-success btn-lg btn-round" value="Publish List">
                    </form>
                </div>
                <div>
                    <form method="post" class="form-inline">
                        <input type="text" class="form-control" name="search_name">
                        <input type="submit" class="btn btn-lg btn-success btn-round" name="search" value="Search">
                    </form>
                </div>
                <table class="table table-striped table-bordered table-hover table-full-width" id="users_table">
                    <thead>
                    <tr>
                        <th style="text-align: center;">Id</th>
                        <th style="text-align: center;">Username</th>
                        <th style="text-align: center;">Amount In Dollar ($)</th>
                        <th style="text-align: center;">Amount In Naira(₦)</th>
                        <th style="text-align: center;">Date Added</th>
                        <th style="text-align: center;">Time Added</th>
                        <th style="text-align: center;">Remaining Amount</th>
                        <th style="text-align: center;">Visible</th>
                        <th style="text-align: center;">Completed</th>
                        <th style="text-align: center;">Collected</th>
                        <th style="text-align: center;">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($allUsers as $user) {
                            ?>
                            <tr>
                                <td style="text-align: center;">
                                    <?php print $user['id']; ?>
                                </td>
                                <td style="text-align: center;">
                                    <a href=""><?php print $user['recipient_username']; ?> </a>
                                </td>
                                <td style="text-align: center;">
                                    <a href=""><?php print $user['amount_dollars']; ?> </a>
                                </td>
                                <td style="text-align: center;">
                                    <a href=""><?php print $user['amount_ngn']; ?> </a>
                                </td>
                                <td style="text-align: center;">
                                    <a href=""><?php print date('d-m-Y', $user['date_added']); ?> </a>
                                </td>
                                <td style="text-align: center;">
                                    <a href=""><?php print $user['time_added']; ?> </a>
                                </td>
                                <td style="text-align: center;">
                                    <a href=""><?php print $user['rem_amount']; ?> </a>
                                </td>
                                <td style="text-align: center;">
                                    <label
                                        class='label <?php echo $user["visible"] == 1 ? "label-success" : "label-danger";
                                        ?>'>  <?php echo $user["visible"] == 1 ? "Visible" : "Hidden"; ?>
                                    </label>
                                </td>
                                <td style="text-align: center;">
                                    <label
                                        class='label <?php echo $user["completed"] == 1 ? "label-success" : "label-danger";
                                        ?>'>  <?php echo $user["completed"] == 1 ? "Yes" : "No"; ?>
                                    </label>
                                </td>

                                <td style="text-align: center;">
                                    <a href=""><?php print $user['collected']; ?> </a>
                                </td>
                                <td style="text-align: center;">
                                    <i class="fa fa-trash-o fa-4" aria-hidden="true" style="font-size: large"></i>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
            <!-- row -->
        </div>
    </div>
</div>
<!-- wrapper -->


<?php require_once "includes/footer.php"; ?>
