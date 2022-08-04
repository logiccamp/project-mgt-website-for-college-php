<?php
$pagetype = "";
$title = "HOME - ";
require("shared/_header.php");
require(__DIR__ . "/shared/functions.php");

if (isset($_GET['err'])) :
    $error = $_GET['err'];
endif;
?>

<main>
    <?php loadError($error | 'Something went wrong'); ?>
</main>

<?php
require("shared/_footer.php");
?>