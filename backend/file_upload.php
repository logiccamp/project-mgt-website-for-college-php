<?php
include("User.php");
//upload.php
session_start();
$matric_ = $_SESSION["user_id"];
$userClass = new User\User;
$user = $userClass::Where("matric_no", '=', $_SESSION["user_id"]);
$hasProfilePicture = $userClass::Has("profile_image", $user["id"]);
$user_ = str_replace('/', "", $matric_);
if (isset($_REQUEST['action'])) {
    switch ($_REQUEST['action']) {
        case 'profile':
            // $_POST["ext"];
            $file = $_FILES["file"]["tmp_name"];
            $filename = $user_ . $_POST["ext"];
            if ($hasProfilePicture) {
                unlink("../assets/img/users/" . $user["profile_image"]);
            }
            if (move_uploaded_file($file, "../assets/img/users/" . $filename)) {
                $userClass = $userClass::UploadPicture($matric_, $filename);
                return print json_encode(array(
                    "message" => "success",
                    "status" => true,
                ));
            } else {
                return print json_encode(array(
                    "message" => "Unable to upload files",
                    "status" => false,
                ));
            }
            break;

        default:
            # code...
            break;
    }
} else {
    return print json_encode(array(
        "server" => true,
        "status" => false,
    ));
}


// $folder_name = 'upload/';

// if (!empty($_FILES)) {
//     $temp_file = $_FILES['file']['tmp_name'];
//     $location = $folder_name . $_FILES['file']['name'];
//     move_uploaded_file($temp_file, $location);
// }

        // if(isset($_POST["name"]))
        // {
        //  $filename = $folder_name.$_POST["name"];
        //  unlink($filename);
        // }

        // $result = array();

        // $files = scandir('upload');

        // $output = '<div class="row">';

        // if(false !== $files)
        // {
        //  foreach($files as $file)
        //  {
        //   if('.' !=  $file && '..' != $file)
        //   {
        //    $output .= '
        //    <div class="col-md-2">
        //     <img src="'.$folder_name.$file.'" class="img-thumbnail" width="175" height="175" style="height:175px;" />
        //     <button type="button" class="btn btn-link remove_image" id="'.$file.'">Remove</button>
        //    </div>
        //    ';
        //   }
        //  }
        // }
        // $output .= '</div>';
        // echo $output;
