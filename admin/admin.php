<?php
require_once '../lib/func.php';
if (!isLoginNow()) {
    goToPage("./index.php");
}
?>

<?php
    require_once ("app/left.html");
?>



