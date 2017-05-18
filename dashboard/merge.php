<?php

require_once "../vendor/autoload.php";

use MerryPayout\Admin;
use MerryPayout\DataManager;
use MerryPayout\Validate;
use MerryPayout\exceptions\MerryPayoutUserException;


$admin = new Admin();
$dataManager = new DataManager();

$php_errormsg = "";


if (isset($_GET['payeeId']) && isset($_GET['payerId'])) {
    $payerId = $_GET['payerId'];
    $payeeId = $_GET['payeeId'];

    if (!Validate::Number($payerId) || !Validate::Number($payeeId)) {
        $php_errormsg = "Invalid operation";
    }
    else {
        // try to merge the users
        try {
            $admin->mergeUsers($payeeId, $payerId);
        }
        catch (MerryPayoutUserException $e) {
            $culpritId = $e->getCulpritId();
            $culpritUsername = $dataManager->getUserInfo($culpritId)["username"];
            $php_errormsg = "" . $e->getMessage() . "<br> Caused by: " . "<a href='admin_edit_user.php?u_id=$culpritId'>" . $culpritUsername . "</a>";
        }
        catch (\PDOException $e) {
            $php_errormsg = $e->getMessage();
        }
    }
}
?>

<?php require_once "includes/header.php"; ?>
<div>
    <?php
    if ($php_errormsg != "") {
        echo "<div class='alert alert-danger'>$php_errormsg</div>";
    }
    ?>
</div>
<?php require_once "includes/footer.php"; ?>



