<?php

    require_once "vendor/autoload.php";
    use MerryPayout\Validate;
    use MerryPayout\App;

    $app = new App();
    $msg = "";
    $hasError = false;

    if (isset($_GET['uid']) and isset($_GET['tk'])) {
        $userId = $_GET['uid'];
        $token = $_GET['tk'];


        if (!Validate::Number($userId)  ||!$app->isRegisteredUser($userId) || !$app->verifyToken($userId,
                $token)
        ) {
            $hasError = true;
            $msg = "Invalid token. Register on MerryPayout <a href='signin'>here</a>";
        }
        else {
            $app->activateUser($userId);
            $app->deleteToken($userId);
            $msg = "You have successfully verified your account. you can now proceed to login  <a href='signin'>here</a>";
        }
    }
?>

<br> <br> <br>

<?php
    if ($hasError) {
        echo "<h2 class='alert alert-danger'> $msg </h2>";
    }
    else {
        echo "<h2 class='alert alert-success'> $msg </h2>";
    }
?>
