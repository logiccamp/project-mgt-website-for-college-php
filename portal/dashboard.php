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

if ($member == null && $activeUser["role_name"] == "student") {
    header("Location: /join");
}

if ($activeUser["profile_completed"] == false && $activeUser["role_name"] == "student") {
    header("Location: /portal/profile");
}

if ($activeUser["role_name"] == "supervisor") {
    $projects_ = User\User::Projects($activeUser["id"], "supervisor");
} else {
    $projects_ = User\User::Projects($activeUser["id"]);
}
$avatar = "/assets/img/user_avatar_2.png";

$chats = User\User::Chats($activeUser["id"]);
$recentMessages = [];
if (count($chats[0]) > 0) {
    foreach ($chats[0] as $chat_) {
        $recentMessages = Chat\Chat::MessagesWithLimit($chat_, $activeUser["id"], 5);
    }
}

?>

<style>

</style>
<main>
    <section>
        <div class="page container-fluid">
            <div class="row page_row">
                <?php loadDashboardSidebar($modeTheme); ?>
                <div class="col-lg-8">
                    <div class="section_wrapper bg-white shadow p-3 my-4">
                        <h5 class="_primary_color"><?php echo if__else($activeUser["role_name"], "student", "Projects", "Dashboard"); ?> </h5>
                        <hr>
                        <div class="page_section row m-0 my-4 gx-3 row-cols-lg-3 row-cols-sm-2">
                            <?php
                            if (count($projects_) > 0) :
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
                                <?php }
                            else :
                                ?>
                                No projects found
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="section_wrapper bg-white shadow p-3 my-4">
                        <h5 class="_primary_color">Recent Chat</h5>
                        <hr>
                        <div class="page_section width_80 row m-0 my-4 row-cols-1">
                            <?php
                            if (count($recentMessages) > 0) :
                                foreach ($recentMessages as $msg) {
                                    $user = User\User::Where("id", "=", $msg["user_id"]);
                                    $thisImage = "../assets/img/users/" . $user["profile_image"];
                            ?>
                                    <div class="card Box py-2 p-3 my-2">
                                        <a href="" class="text-decoration-none  ">
                                            <div class="pinned-item-list-item-content">
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex width_80 align-items-center">
                                                        <img src="<?php echo if__else($user['profile_image'], '', $avatar, $thisImage) ?>" class="rounded-circle" alt="Avatar" width="60px" height="60px" /> <span class="mx-1"></span>
                                                        <div>
                                                            <strong class="text-black-50">New message from - <?php echo $user['full_name']; ?></strong>
                                                            <p class="text-bold text-dark p-0 m-0"><span class="project_name" title="pm-twitter"><?php echo if__else($msg['is_file'], true, 'Shared new ' . $msg['file_type'], $msg['message']); ?>.</span></p>
                                                        </div>
                                                    </div>
                                                    <div class="is_desktop">
                                                        <span class="badge _primary_bg">New</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            <?php else : ?>
                                No recent chat
                            <?php endif; ?>
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