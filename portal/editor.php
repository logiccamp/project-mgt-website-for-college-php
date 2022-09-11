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

$pagetype = "editor";
$title = "Editor - ";
$pageIntro = "DASHBOARD";
$mode = getTheme();
$modeTheme = $mode  == "dark" ? "light" : "dark";


if (!isset($_GET["project"]) || $_GET["project"] == "") {
    exit(loadError("Invalid Project", true, "/portal/dashboard", "Go Back"));
}
$doc = "";
$ddoc = "";
$content = "";
if (isset($_GET["doc"]) && $_GET["doc"] !== "") {
    $doc_id = $_GET["doc"];
    $ddoc = $_GET["doc"];
    $doc = Doc\Doc::Get("doc_id", $doc_id);
    if ($doc == null) {
        loadError("Invalid Document", true, "/portal/dashboard", "Go Back");
        exit();
    }

    if ($doc["file_location"] != "") {
        $file = fopen("../assets/docs/" . $doc["file_location"], 'r') or loadError("Unable to load document content", true, "/portal/dashboard", "Go Back");
        $content = fread($file, filesize("../assets/docs/" . $doc["file_location"]));
        fclose($file);
    }
}

$project = Project\Project::Where("project_id", "=", $_GET['project']);
if (count($project) == 0) {
    loadError("Invalid Project", true, "/portal/dashboard", "Go Back");
    exit();
}
$project = $project[0];

require("../shared/_header.php");

?>
<main>
    <div id="success-alert" class="success_alert position-fixed shadow bg-success text-white p-2" style="top: 20px; right: 10px; z-index: 10000000003; display: none">File saved successfully</div>
    <textarea name="content" class="content" id="content" cols="30" rows="10"><?php echo html_entity_decode($content); ?></textarea>
</main>

<script>
    var file_id = "<?php echo $ddoc; ?>"
    var project_id = "<?php echo $project["project_id"]; ?>"
</script>
<?php
require("../shared/_footer.php");
?>