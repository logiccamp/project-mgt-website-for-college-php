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
if ($activeUser["profile_completed"] == false && $activeUser["role_name"] == "student") {
    header("Location: /portal/profile");
}

$pagetype = "dashboard";
$title = "Dashboard - ";
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
$totalMembers = Project\Project::GetMultiple('membercount', $project["id"]);
$avatar = "/assets/img/user_avatar_2.png";
$docs = Doc\Doc::Where("project_id", $project['project_id']);

?>

<style>

</style>
<div class="my-2">s</div>
<main style="padding-top: 0px">
    <section>
        <div class="page container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <?php loadProjectHeader($modeTheme, $project); ?>
                    <br>
                    <h4 class="_primary_color"><?php echo $project['project_title']; ?></h4>
                    <hr>

                    <div class="row m-0 my-4">
                        <div class="col-12 tab-content no-bg py-2 no-border">
                            <div class="mt-4 d-flex justify-content-between">
                                <h5 class="_primary_color">Documents</h5>
                                <div>
                                    <a href="/portal/files?project=<?php echo $project['project_id']; ?>" class="badge _primary_bg text-decoration-none">View All</a>
                                    <a href="/portal/editor?project=<?php echo $project['project_id']; ?>" class=" badge _secondary_bg text-decoration-none">New</a>
                                </div>
                            </div>

                            <div class="tab-pane active documents documents-panel">
                                <?php
                                if (count($docs) > 0) :
                                    foreach ($docs as $doc) :
                                        $usr = "";
                                        $uploaded_by = User\User::Where("id", "=", $doc['user_id']);
                                        if ($uploaded_by) {
                                            $usr = $uploaded_by["full_name"];
                                        }
                                ?>
                                        <a href="<?php echo '/portal/editor?project=' . $project["project_id"] . '&doc=' . $doc["doc_id"]; ?>">
                                            <div class="document">
                                                <div class="document-body">
                                                    <i class="fa fa-file-word-o text-primary"></i>
                                                </div>
                                                <div class="document-footer">
                                                    <span class="document-name text-dark"> <?php echo $doc["file_name"]; ?> </span>
                                                    <span class="document-name text-black-50" style="font-size: smaller;"> Created by: <?php echo $usr; ?></span>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endforeach;
                                else : ?>
                                    No Document found
                                <?php endif; ?>

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