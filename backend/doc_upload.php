<?php
include("User.php");
include("Doc.php");
//upload.php
session_start();
$matric_ = $_SESSION["user_id"];
$userClass = new User\User;
$user = $userClass::Where("matric_no", '=', $_SESSION["user_id"]);
$hasProfilePicture = $userClass::Has("profile_image", $user["id"]);
$user_ = str_replace('/', "", $matric_);


$file_id = $_POST["file_id"];
$project_id = $_POST["project_id"];
$content = $_POST["content"];
$file_name = $_POST["file_name"];

if ($file_id == "") {
    $doc = [
        "project_id" => $project_id,
        "user_id" => $user["id"],
        "content" => $content,
        "file_name" => $file_name,
    ];
    $saveDoc = Doc\Doc::Add($doc);
    print(json_encode($saveDoc));
} else {
    $doc = [
        "content" => $content,
        "file_name" => $file_name,
    ];
    $saveDoc = Doc\Doc::Update($doc, $file_id);
    print(json_encode($saveDoc));
}
