<?php
    ob_start();
    session_start();

    require_once "../vendor/autoload.php";

    $title = "Welcome to Dashboard ";
    $pagename = "dashboard";

    use MerryPayout\User;

    $user = new User();
    $user->checkAuth();
    $userInfo = $user->getDetails();

    $merger = new \MerryPayout\Merger();


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

            <div class="row comic-sans">


                <?php require_once "includes/profile.php"; ?>

                <?php require_once "includes/activities.php"; ?>


            </div>
            <!-- row -->
        </div>

    </div>


</div>
<!-- wrapper -->


<?php require_once "includes/footer.php"; ?>

