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
$loadChatBot = true;
$pagetype = "dashboard";
$title = "Chat - ";
$pageIntro = "DASHBOARD";
$mode = getTheme();
$modeTheme = $mode  == "dark" ? "light" : "dark";
require("../shared/_header.php");


if (!isset($_GET["hash"]) || $_GET["hash"] == "") {
    exit(loadError("Invalid Project", true, "/portal/dashboard", "Go Back"));
}

$chat = Chat\Chat::Where("chat_hash", "=", $_GET['hash']);
if (!$chat) {
    loadError("Invalid Chat", true, "/portal/dashboard", "Go Back");
    exit();
}

if ($chat["has_project"] == true) {
    $project = Project\Project::Where("id", "=", $chat["project_id"])[0];
    $leaders = Project\Project::GetMultiple("groupleaders", $project["id"]);
    $totalMembers = Project\Project::GetMultiple('membercount', $project["id"]);
    $allMembers = Project\Project::GetMultiple("allMembers", $project["id"]);
} else {
    $allMembers = [];
}
$files = Chat\Chat::FilesWithLimit($chat["id"], 4);

$avatar = "/assets/img/user_avatar_2.png";

?>

<main style="margin-top: 75px">
    <div class="overlay_container" id="fileChatOverlay">
        <div class="overlay_inner">
            <div class="shadow w-100 rounded-0 bg-white p-3 mx-auto position-relative">
                <div class="alert alert-success fileSuccess" style="display: none">Upload success</div>
                <div class="alert alert-danger fileError" style="display: none">Unable to upload</div>
                <h3 class="text-dark text-center fw-bold fs-5">Send file</h3>
                <a href="#?" id="closeOverlay" class="rounded-pill shadow-sm bg-white p-2 py-1 text-danger position-absolute" style="right: -10px; top: -10px"><i class="fa fa-close"></i></a>
                <div id="owner_error" class="text-danger text-center"></div>
                <div class="upload-preview" for="profileImage" id="uploadFile">
                    <label for="uploadImage">Click here to select file</label>
                </div>
                <div align="center">
                    <input data-action="chat" type="file" hidden name="uploadImage" id="uploadImage">
                    <label for="uploadImage" class="btn btn-info my-2" id="submit-all">Select File</label> <span class="mx-2"></span>
                    <a href="#?" class="btn btn-danger my-2 removeall" id="removeall">Clear</a>
                    <a href="#?" class="btn btn-success my-2 sendFile" id="sendFile">Upload</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-lg-5 col-xl-4 mb-md-0 is_tablet b p-2">
                <ul class="list-unstyled mb-0 msg_container_base_ p-2" style="overflow-y: scroll;">
                    <?php
                    if ($chat["has_project"]) : ?>
                        <h5 class="fw-bold mt-4 mb-3 <?php echo $modeTheme; ?> text-center text-lg-start">Project</h5>
                        <a href="/portal/project.php" class="<?php echo $modeTheme; ?>"><?php echo $project['project_title']; ?> </a>
                    <?php endif; ?>
                    <hr>
                    <h5 class="font-weight-bold mt-4 mb-3 <?php echo $modeTheme; ?> text-center text-lg-start">Member</h5>
                    <?php
                    foreach ($allMembers as $member) {
                        $thisImage = "../assets/img/users/" . $member['profile_image'];
                    ?>
                        <li class="p-2 border-bottom ">
                            <a href="/" class="d-flex justify-content-between">
                                <div class="d-flex flex-row">
                                    <img src="<?php echo if__else($member['profile_image'], '', $avatar, $thisImage); ?>" alt="<?php echo $member['full_name']; ?>" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                                    <div class="pt-1">
                                        <p class="fw-bold mb-0 <?php echo $modeTheme; ?>"><?php echo $member['full_name']; ?></p>
                                        <p class="small p-0 text-muted d-flex">Last seen :
                                            <span class="moment p-0 d-inline" data-date="<?php echo $member['last_login']; ?>"></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="pt-1">
                                    <span class="badge _secondary_bg float-end">
                                        <span class="fa fa-eye"></span>
                                    </span>
                                </div>
                            </a>
                        </li>
                    <?php } ?>
                    <hr>
                    <h5 class="font-weight-bold mt-4 mb-3 <?php echo $modeTheme; ?> text-center text-lg-start">Recent Files</h5>
                    <?php

                    foreach ($files as $file) { ?>
                        <li class="p-2 border-bottom ">
                            <a href="#!" class="d-flex justify-content-between">
                                <div class="d-flex flex-row">
                                    <div class="badge shadow-sm rounded-pill d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                                        <i class="fa <?php echo $file['file_icon'] . ' ' . $file['file_bg']; ?>" style=" font-size: 20px;"></i>
                                    </div>
                                    <div class="mx-2"></div>
                                    <div class="pt-1">
                                        <p class="fw-bold mb-0 <?php echo $modeTheme; ?>"><?php echo $file['file_name']; ?></p>
                                        <p class="small text-muted moment" data-date="<?php echo $file['date_created']; ?>"></p>
                                    </div>
                                </div>
                                <div class="pt-1">
                                    <span class="badge _secondary_bg float-end">
                                        <span class="fa fa-eye"></span>
                                    </span>
                                </div>
                            </a>
                        </li>
                    <?php } ?>


                </ul>
            </div>

            <div class="col-md-7 col-lg-7 col-xl-8 position-relative">
                <ul class="list-unstyled msg_container_base shadow-sm p-2" style="overflow-y: scroll;">
                    <li class="loading_chat">loading...</li>
                    <!-- <li class="d-flex justify-content-between mb-4">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-1.webp" alt="avatar" class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between p-3">
                                <p class="fw-bold mb-0">Brad Pitt</p>
                                <p class="text-muted small mb-0"><i class="far fa-clock"></i> 12 mins ago</p>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                    labore et dolore magna aliqua.
                                </p>
                            </div>
                        </div>
                    </li> -->
                    <!-- <li class="d-flex justify-content-between mb-4">
                        <div class="card w-100">
                            <div class="card-header d-flex justify-content-between p-3">
                                <p class="fw-bold mb-0">Lara Croft</p>
                                <p class="text-muted small mb-0"><i class="far fa-clock"></i> 13 mins ago</p>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">
                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                    laudantium.
                                </p>
                            </div>
                        </div>
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-5.webp" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60">
                    </li> -->

                    <!-- <li class="bg-white mb-3">
                        <div class="form-outline">
                            <textarea class="form-control" id="textAreaExample2" rows="4"></textarea>
                            <label class="form-label" for="textAreaExample2">Message</label>
                        </div>
                    </li>
                    <button type="button" class="btn btn-info btn-rounded float-end">Send</button> -->
                </ul>

                <div class="chat-message d-flex p-1">
                    <div name="message" class="form-control message" id="messageInputBox" contenteditable="true" placeholder="Write a message" required="true"></div>
                    <div class="mx-2"></div>
                    <a href="#?" class="rounded-pill btn d-flex justify-content-center align-items-center <?php echo $mode == 'light' ? '_primary_bg' : 'bg-dark'; ?>" id="sendButton">
                        <i class="fa fa-send text-white"></i>
                    </a>
                    <a href="#?" class="d-flex btn-sm rounded-pill justify-content-center align-items-center" id="sendFiles">
                        <i class="fa fa-paperclip fa-2x <?php echo $modeTheme; ?>"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</main>
<script>
    var user_id = "<?php echo $activeUser['id']; ?>";
    var chat_id = "<?php echo $_GET['hash']; ?>";
    var project_id = "<?php echo $project == '' ? '' :  $project['id']; ?>"
    var image_folder = "/assets/img/users/";
    var avatar = "/assets/img/user_avatar_2.png";
</script>

<?php

require("../shared/_footer.php");
?>