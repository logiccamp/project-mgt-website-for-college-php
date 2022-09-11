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


// chat
$chat = Project\Project::Chat($project['id']);

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

$recentMessages = Chat\Chat::MessagesWithLimit($chat["id"], $activeUser["id"], 5);
$recentMedia = Chat\Chat::FilesWithLimit($chat['id'], 4);
$docs = Doc\Doc::Where("project_id", $project['project_id']);
?>

<?php


?>

<style>

</style>
<br>
<main style="padding-top: 0px ">
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
                        <div class="col-12 tab-content no-bg py-2 pb-5 no-border">
                            <div class="mt-4 d-flex justify-content-between">
                                <h5 class="_primary_color">Documents</h5>
                                <div>
                                    <a href="/portal/files?project=<?php echo $project['project_id']; ?>" class="badge _primary_bg text-decoration-none">View All</a>
                                    <a href="/portal/editor?project=<?php echo $project['project_id']; ?>" class=" badge _secondary_bg text-decoration-none">New</a>

                                </div>
                            </div>

                            <div class="tab-pane active documents documents-panel ">
                                <?php
                                if (count($docs) > 0) :
                                    foreach ($docs as $doc) :
                                        $usr = "";
                                        $uploaded_by = User\User::Where("id", "=", $doc['user_id']);
                                        if ($uploaded_by) {
                                            $usr = $uploaded_by["full_name"];
                                        }
                                        $owner = $doc['user_id'] == $activeUser["id"] ? true : false;
                                ?>
                                        <a class="my-3 " href="<?php echo '/portal/editor?project=' . $project["project_id"] . '&doc=' . $doc["doc_id"]; ?>">
                                            <div class="document position-relative">
                                                <div class="document-body">
                                                    <i class="fa fa-file-word-o text-primary"></i>
                                                </div>
                                                <div class="document-footer">
                                                    <span class="document-name text-dark"> <?php echo $doc["file_name"]; ?> </span>
                                                    <span class="document-name text-black-50" style="font-size: smaller;"> Created by: <?php echo $usr; ?></span>
                                                </div>
                                                <a class="position-absolute fw-bold  px-2 rounded-pill bg-danger text-white deleteFile" style="top: 5px; right: 5px; font-size: 20px;" href="#?" data-doc="<?php echo $doc["doc_id"]; ?>">&times;</a>
                                            </div>
                                        </a>
                                    <?php endforeach;
                                else : ?>
                                    No Document found
                                <?php endif; ?>
                            </div>
                        </div>
                        <br>
                    </div>

                    <div class="row m-0 section_wrapper my-4 py-2">
                        <div class="col-12 tab-content no-bg no-border">
                            <div class="mt-4 d-flex justify-content-between">
                                <h5 class="_primary_color">Chat</h5>
                                <div>
                                    <a href="/portal/chat?hash=<?php echo $chat["chat_hash"]; ?>" class="badge bg-dark text-decoration-none">View</a>
                                </div>
                            </div>
                            <div class="page_section row m-0 my-4 row-cols-1">
                                <?php
                                if (count($recentMessages) > 0) :
                                    foreach ($recentMessages as $msg) {
                                        $user = User\User::Where("id", "=", $msg["user_id"]);
                                        $thisImage = "../assets/img/users/" . $user["profile_image"];
                                ?>
                                        <div class="card Box py-2 p-3 my-2">
                                            <a href="/portal/chat?hash=<?php echo $chat["chat_hash"]; ?>" class="text-decoration-none  ">
                                                <div class="pinned-item-list-item-content">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <img src="<?php echo if__else($user['profile_image'], '', $avatar, $thisImage); ?>" class="rounded-circle" alt="Avatar" width="60px" height="60px" /> <span class="mx-1"></span>
                                                            <div>
                                                                <strong class="text-black-50">New message from - <?php echo $user['full_name']; ?></strong>
                                                                <p class="text-bold text-dark p-0 m-0"><span class="project_name" title="pm-twitter"><?php echo if__else($msg['is_file'], true, 'Shared new ' . $msg['file_type'], $msg['message']); ?>.</span></p>
                                                            </div>
                                                        </div>
                                                        <div class="is_desktop">
                                                            <span class="badge _primary_bg">View</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php }
                                else : ?>
                                    No message found
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row m-0 my-4">
                        <div class="col-12 tab-content no-bg py-2 no-border">
                            <div class="mt-4 d-flex justify-content-between">
                                <h5 class="_primary_color">Chat Media</h5>
                                <a href="/portal/media?chat=<?php echo $chat["chat_hash"]; ?>" class="badge bg-dark text-decoration-none">View All</a>
                            </div>
                            <div class="tab-pane active documents documents-panel">
                                <?php
                                if (count($recentMedia) > 0) :
                                    foreach ($recentMedia as $file) { ?>
                                        <a href="<?php echo $file['file']; ?>" target="_blank">
                                            <div class="document">
                                                <div class="document-body">
                                                    <i class="fa <?php echo $file['file_icon'] . ' ' . $file['file_bg']; ?>" style=" font-size: 20px;"></i>
                                                </div>
                                                <div class="document-footer">
                                                    <span class="document-name <?php echo $modeTheme; ?> mb-2"> <?php echo $file['file_name']; ?> </span>
                                                    <span class="document-description "> <?php echo $file['file_size']; ?> MB</span>
                                                </div>
                                            </div>
                                        </a>
                                    <?php }
                                else : ?>
                                    No media found
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
<script>

</script>

<?php

use User\User;

require("../shared/_footer.php");
?>