<?php
require(__DIR__ . "/../shared/functions.php");
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null) {
    header("Location: /login");
};
$matric_no = $_SESSION["user_id"];
$activeUser = User\User::Where("matric_no", "=", $matric_no);
$member = ProjectMember\ProjectMember::Where("user_id", "=", $activeUser['id']);

if ($member == null && $activeUser["role_name"] == "student") {
    header("Location: /join");
}

$pagetype = "dashboard";
$title = "Profile - ";
$pageIntro = "DASHBOARD";
$mode = getTheme();
$modeTheme = $mode  == "dark" ? "light" : "dark";

require("../shared/_header.php");
?>

<style>

</style>
<main style="padding-top: 20px ">
    <section>
        <div class="page container-fluid">
            <div class="row page_row">
                <?php loadDashboardSidebar($modeTheme); ?>
                <div class="col-lg-8">
                    <?php
                    if (isset($_GET['p'])) {
                        loadUserProfile_v();
                    } else {
                        loadUserProfile();
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
require("../shared/_footer.php");
?>