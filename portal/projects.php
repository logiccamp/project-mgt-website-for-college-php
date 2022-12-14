<?php


require(__DIR__ . "/../shared/functions.php");
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null) {
    header("Location: /login");
};
$matric_no = $_SESSION["user_id"];


$pagetype = "dashboard";
$title = "Dashboard - ";
$pageIntro = "DASHBOARD";
$mode = getTheme();
$modeTheme = $mode  == "dark" ? "light" : "dark";
require("../shared/_header.php");
$activeUser = User\User::Where("matric_no", "=", $matric_no);
$member = ProjectMember\ProjectMember::Where("user_id", "=", $activeUser['id']);

$projects_ = User\User::Projects($activeUser["id"]);

if ($member == null) {
    header("Location: /join");
}
?>

<style>

</style>
<main style="padding-top: 20px ">
    <section>
        <div class="page container-fluid">
            <div class="row page_row">
                <?php loadDashboardSidebar($modeTheme); ?>
                <div class="col-lg-8">
                    <div class="section_wrapper bg-white shadow-sm p-3 my-4">
                        <h5 class="_primary_color">Projects</h5>
                        <hr>
                        <div class="page_section row m-0 my-4 gx-3 row-cols-lg-3 row-cols-sm-2">
                            <?php
                            foreach ($projects_ as $project) { ?>
                                <div class="p-2">
                                    <div class="card Box bg-opacity-25 p-3 ">
                                        <a href="/portal/project?project=<?php echo $project['project_id']; ?>" class="text-decoration-none">
                                            <div class="pinned-item-list-item-content">
                                                <div class="d-flex flex_rotate justify-content-between">
                                                    <p class="text-bold w-75 text-dark">
                                                        <span class="project_name" title="pm-twitter"><?php echo $project['project_title']; ?></span>
                                                    </p>
                                                    <div class="">
                                                        <span class="badge bg-dark">
                                                            <?php
                                                            echo if__else($check = $project["status"], $value = "1", $return = "open", $return_else = "closed");
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>

                                                <span class="mb-0 mt-2 _secondary_color d-flex justify-content-between">
                                                    <span class="d-inline-block mr-3">
                                                        <span itemprop="programmingLanguage">Chapter <?php echo $project["chapters"]; ?></span>
                                                    </span>

                                                    <span class="pinned-item-meta Link--muted">
                                                        <span class="fa fa-users"></span> <?php echo Project\Project::GetMultiple("membercount", $project["id"]); ?>
                                                    </span>
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>

<?php
require("../shared/_footer.php");
?>