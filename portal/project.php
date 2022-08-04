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


// chat
$chat = Project\Project::Chat($project['id']);
print_r($chat);
if (!$chat) {
    $isCreated = Chat\Chat::Create([
        "has_project" => 1,
        "project_id" => $project['id'],
    ]);

    if ($isCreated) {
        if ($isCreated["status"] == true) {
            $chat = $isCreated["chat"];
        } else {
            loadError("Unable to create chat", true, "/portal/dashboard", "Go Back");
            exit();
        }
    } else {
        loadError("Unable to create chat", true, "/portal/dashboard", "Go Back");
        exit();
    }
}

?>

<?php





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
                    <div class="section_wrapper bg-white shadow-sm p-3 my-4">
                        <h4 class="_primary_color"><?php echo $project['project_title']; ?></h4>
                        <hr>
                        <div class="card Box bg-opacity-25 p-3 ">
                            <div class="pinned-item-list-item-content">
                                <h6 class="text-dark">Description</h6>
                                <div class="d-flex justify-content-between">
                                    <p class="text-dark">
                                        <?php echo $project["description"]; ?>
                                    </p>
                                </div>

                                <span class="mb-0 mt-2 _secondary_color d-flex justify-content-between">
                                    <span class="d-inline-block mr-3">
                                        <span itemprop="programmingLanguage"><?php echo $project["chapters"]; ?> Chapters</span>
                                    </span>

                                    <span href="/logiccamp/pm-twitter/stargazers" class="pinned-item-meta Link--muted">
                                        <span class="fa fa-users"></span> <?php echo $totalMembers; ?>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row m-0 my-4">
                        <div class="col-12 tab-content no-bg py-2 no-border">
                            <div class="mt-4 d-flex justify-content-between">
                                <h5 class="_primary_color">Files</h5>
                                <div>
                                    <a href="" class="badge _secondary_bg text-decoration-none">View All</a>
                                </div>
                            </div>
                            <div class="tab-pane active documents documents-panel">
                                <div class="document">
                                    <div class="document-body">
                                        <i class="fa fa-file-excel-o text-success"></i>
                                    </div>
                                    <div class="document-footer">
                                        <span class="document-name"> Excel database 2016 </span>
                                        <span class="document-description"> 1.1 MB </span>
                                    </div>
                                </div>

                                <div class="document">
                                    <div class="document-body">
                                        <i class="fa fa-file-word-o text-info"></i>
                                    </div>
                                    <div class="document-footer">
                                        <span class="document-name"> Excel database 2016 </span>
                                        <span class="document-description"> 1.1 MB </span>
                                    </div>
                                </div>

                                <div class="document">
                                    <div class="document-body">
                                        <i class="fa fa-file-pdf-o text-danger"></i>
                                    </div>
                                    <div class="document-footer">
                                        <span class="document-name"> Excel database 2016 </span>
                                        <span class="document-description"> 1.1 MB </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row m-0 section_wrapper my-4 py-2">
                        <div class="col-12 tab-content no-bg no-border">
                            <div class="mt-4 d-flex justify-content-between">
                                <h5 class="_primary_color">Chat</h5>
                                <div>
                                    <a href="" class="badge bg-dark text-decoration-none">View</a>
                                </div>
                            </div>
                            <div class="page_section row m-0 my-4 row-cols-1">
                                <div class="card Box py-2 p-3 my-2">
                                    <a href="" class="text-decoration-none  ">
                                        <div class="pinned-item-list-item-content">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <img src="https://mdbcdn.b-cdn.net/img/new/avatars/8.webp" class="rounded-circle" alt="Avatar" width="60px" height="60px" /> <span class="mx-1"></span>
                                                    <div>
                                                        <strong class="text-black-50">New message from - Jurge</strong>
                                                        <p class="text-bold text-dark p-0 m-0"><span class="project_name" title="pm-twitter">Lorem ipsum dolor sit amet consectetur adipisicing elit.</span></p>
                                                    </div>
                                                </div>
                                                <div class="is_desktop">
                                                    <span class="badge _primary_bg">New</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="card Box bg-opacity-25 py-2 p-3 my-2">
                                    <a href="" class="text-decoration-none">
                                        <div class="pinned-item-list-item-content">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <img src="https://mdbcdn.b-cdn.net/img/new/avatars/8.webp" class="rounded-circle" alt="Avatar" width="60px" height="60px" /> <span class="mx-1"></span>
                                                    <div>
                                                        <strong class="text-black-50">New message from - Jurge</strong>
                                                        <p class="text-bold text-dark p-0 m-0"><span class="project_name" title="pm-twitter">Lorem ipsum dolor sit amet consectetur adipisicing elit.</span></p>
                                                    </div>
                                                </div>
                                                <div class="is_desktop is_tablet">
                                                    <span class="badge _secondary_bg">View</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
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