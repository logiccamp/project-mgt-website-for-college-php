<?php

include("../Chat.php");
include("../ChatMessages.php");
include("../User.php");

$chatClass = new Chat\Chat;
if (isset($_REQUEST['action'])) :
    switch ($_REQUEST['action']):
        case 'Get':
            $chat_hash = $_REQUEST["chat"];
            $chat = $chatClass::Where("chat_hash", "=", $chat_hash);
            $chat["messages"] = ChatMessage\ChatMessage::Where("chat_id", "=", $chat["id"]);
            print json_encode($chat);
            break;

        case 'Create':
            $chat = $chatClass::Where("chat_hash", "=", $_POST['chat_id']);
            if (!$chat) return print("error");

            $chat_id = $chat["id"];
            $project_id = $_POST['project_id'];
            $user_id = $_POST['user_id'];
            if ($user_id == "") return print("error");

            // check if its valid user;
            $isUser = User\User::where("id", "=", $user_id);
            if (!$isUser) return print("invalid user");


            if ($_REQUEST["type"] == "text") :
                $message = $_POST['message'];

                if ($message == "") return print("message cannot be empty");
                echo $chat_id;
                $new_message = ChatMessage\ChatMessage::Create([
                    "is_file" => false,
                    "chat_id" => $chat_id,
                    "user_id" => $user_id,
                    "project_id" => $project_id,
                    "message" => $message
                ]);
            else :
                $file = $_FILES["file"]["tmp_name"];
                $str = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 5);
                $filename = time() . $str . $_POST["file_ext"];
                $file_loc = "/assets/chat/" . $filename;

                try {
                    move_uploaded_file($file, "../../assets/chat/" . $filename);
                } catch (\Throwable $th) {
                    return print("error");
                }
                $new_message = ChatMessage\ChatMessage::Create([
                    // file, file_type, file_size, file_ext, file_bg
                    "is_file" => true,
                    "chat_id" => $chat_id,
                    "user_id" => $user_id,
                    "project_id" => $project_id,
                    "file_type" => $_POST["file_type"],
                    "file_size" => $_POST["file_size"],
                    "file_ext" => $_POST["file_ext"],
                    "file_bg" => $_POST["file_bg"],
                    "file_name" => $_POST["file_name"],
                    "file_icon" => $_POST["file_icon"],
                    "file" => $file_loc
                ]);
            endif;


            if ($new_message) return print("success");
            if ($new_message) return print("error");

        default:
            # code...
            break;
    endswitch;
endif;
