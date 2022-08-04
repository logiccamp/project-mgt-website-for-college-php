<?php
require(__DIR__ . "/../shared/functions.php");
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null) {
    header("Location: /login");
};
$matric_no = $_SESSION["user_id"];
$activeUser = User\User::Where("matric_no", "=", $matric_no);
$member = ProjectMember\ProjectMember::Where("user_id", "=", $activeUser['id']);

if ($member == null) {
    header("Location: /join");
}
if ($activeUser["profile_completed"] == false) {
    header("Location: /portal/profile");
}

$pagetype = "dashboard";
$title = "Members - ";
$pageIntro = "DASHBOARD";
$mode = getTheme();
$modeTheme = $mode  == "dark" ? "light" : "dark";
require("../shared/_header.php");


if (!isset($_GET["project"]) || $_GET["project"] == "") {
    exit(loadError("Invalid Project", true, "/portal/dashboard", "Go Back"));
}

$project = Project\Project::Where("project_id", "=", $_GET['project']);
if (count($project) == 0) {
    loadError("Invalid Project", true, "/portal/dashboard", "Go Back");
    exit();
}
$project = $project[0];
$leaders = Project\Project::GetMultiple("groupleaders", $project["id"]);

$totalMembers = Project\Project::GetMultiple('membercount', $project["id"]);
$membersList = Project\Project::GetMultiple("membersList", $project["id"]);
$avatar = "/assets/img/user_avatar_2.png";

?>
<style>

</style>
<main style="padding-top: 20px ">
    <section>
        <div class="page container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="my-2">
                        <?php loadProjectHeader($modeTheme, $project); ?>
                    </div>
                    <div class="section_wrapper p-3 my-4">
                        <h4 class="_primary_color"><?php echo $project['project_title']; ?></h4>
                        <hr>
                    </div>
                    <div class="row m-0 my-4 ">
                        <div class="col-12 tab-content no-bg py-2 no-border">
                            <div class="tab-panel  active documents documents-panel">
                                <h5 class="_primary_color">Members</h5>
                                <?php
                                foreach ($leaders as $member) {
                                    $thisImage = "../assets/img/users/" . $member['profile_image'];
                                ?>
                                    <div class="document">
                                        <div class="user_avatar text-center py-3">
                                            <img src="<?php echo if__else($member["profile_image"], "", $avatar, $thisImage); ?>" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover" alt="Avatar" />
                                            <h5 class="mb-2 <?php echo $modeTheme; ?>"><strong><?php echo $member['full_name']; ?></strong></h5>
                                            <small class="mb-2 <?php echo $modeTheme; ?>"><strong><?php echo $member['matric_no']; ?></strong></small>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php
                                foreach ($membersList as $member) {
                                    $thisImage = "../assets/img/users/" . $member['profile_image'];
                                ?>
                                    <div class="document">
                                        <div class="user_avatar text-center py-3">
                                            <img src="<?php echo if__else($member["profile_image"], "", $avatar, $thisImage); ?>" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover" alt="Avatar" />
                                            <h5 class="mb-2 <?php echo $modeTheme; ?>"><strong><?php echo $member['full_name']; ?></strong></h5>
                                            <small class="mb-2 <?php echo $modeTheme; ?>"><strong><?php echo $member['matric_no']; ?></strong></small>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                </div>
                <?php loadProjectSidebar($mode, $modeTheme, $project); ?>
            </div>


        </div>
    </section>
</main>

<?php
require("../shared/_footer.php");
?>