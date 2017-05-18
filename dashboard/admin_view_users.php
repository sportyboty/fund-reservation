<?php
session_start();

set_time_limit(120);
require_once "../vendor/autoload.php";
require_once "../vendor/phpmailer/phpmailer/PHPMailerAutoload.php";

$title = "All users";

$pagename = "users";

use MerryPayout\Admin;


$app = new \MerryPayout\App();
$app->deleteAllExpiredTransactions();

$admin = new Admin();
$admin->checkAuth();
$allUsers = $admin->getAllUsers();

if (isset($_POST['mergeAll'])) {
    $admin = new Admin();
    $admin->mergeAllUsers();
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
                        <input type="submit" name="mergeAll" class="btn btn-success btn-lg btn-round" value="Merge All">
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
                        <th style="text-align: center;">Activated</th>
                        <th style="text-align: center;">Valid Donor</th>
                        <th style="text-align: center;">Valid Receiver</th>
                        <th style="text-align: center;">Add to List</th>
                        <th style="text-align: center;">Edit</th>
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
                                <a href=""><?php print $user['username']; ?> </a>
                            </td>
                            <td style="text-align: center;">
                                <label
                                        class='label <?php echo $user["activated"] == 1 ? "label-success" : "label-danger";
                                        ?>'>  <?php echo $user["activated"] == 1 ? "Active" : "Inactive"; ?>
                                </label>
                            </td>
                            <td style="text-align: center;">
                                <label
                                        class='label <?php echo $user["valid_for_ph"] == 1 ? "label-success" : "label-danger";
                                        ?>'>  <?php echo $user["valid_for_ph"] == 1 ? "Yes" : "No"; ?>
                                </label>
                            </td>
                            <td style="text-align: center;">
                                <label
                                        class='label <?php echo $user["valid_for_gh"] == 1 ? "label-success" : "label-danger";
                                        ?>'> <?php echo $user["valid_for_gh"] == 1 ? "Yes" : "No"; ?> </label>
                            </td>

                            <td style="text-align: center;">
                                <a href="add_to_list?u_id=<?php echo $user["id"]; ?>"><i
                                            class="fa fa-plus fa-4"
                                            aria-hidden="true"
                                            style="font-size: large"></i></a>
                            </td>
                            <td style="text-align: center;">
                                <a href="admin_edit_user?u_id=<?php echo $user["id"]; ?>"><i class="fa fa-pencil-square-o
                        fa-4" aria-hidden="true" style="font-size: large"></i></a>
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
