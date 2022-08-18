<?php

namespace ChatMessage;

use User\User;

class ChatMessage
{

    public static $con;


    public static function Connect()
    {
        include("Database.php");
        self::$con = mysqli_connect($host, $user, $password, $db);
    }
    public static function Where(string $column,  string $operator = "=", string $value)
    {
        try {
            self::Connect();
            $query = "SELECT * FROM `chat_messages` WHERE `$column` $operator '$value'";
            $rs = mysqli_query(self::$con, $query);
            $count = mysqli_num_rows($rs) > 0;
            $messages = [];
            if ($count) {
                while ($row = mysqli_fetch_assoc($rs)) {
                    $row["user"] = User::Where("id", "=", $row["user_id"]);
                    $messages[] = $row;
                }

                return $messages;
            } else {
                return [];
            }
        } catch (\Throwable $th) {
            return [];
        }
    }
    public static function WhereDistinct(string $user)
    {
        try {
            self::Connect();
            $query = "SELECT DISTINCT `chat_id` FROM `chat_messages` WHERE `user_id` = '$user' ";
            $rs = mysqli_query(self::$con, $query);
            $count = mysqli_num_rows($rs) > 0;
            $chats = [];
            if ($count) {
                while ($row = mysqli_fetch_assoc($rs)) {
                    $chats[] = $row;
                }
                return $chats;
            } else {
                return [];
            }
        } catch (\Throwable $th) {
            return [];
        }
    }

    public static function MessagesWithLimit(string $column, string $chat_id, string $user, string $limit)
    {
        try {
            self::Connect();
            $query = "SELECT * FROM `chat_messages` WHERE `$column` = '$chat_id' AND `user_id` != '$user' ORDER BY `id` DESC LIMIT $limit";
            $rs = mysqli_query(self::$con, $query);
            $count = mysqli_num_rows($rs) > 0;
            $messages = [];
            if ($count) {
                while ($row = mysqli_fetch_assoc($rs)) {
                    $row["user"] = User::Where("id", "=", $row["user_id"]);
                    $messages[] = $row;
                }

                return $messages;
            } else {
                print(mysqli_error(self::$con));
                return [];
            }
        } catch (\Throwable $th) {
            return [];
        }
    }
    public static function GetLimit(string $column, string $id, string $limit)
    {
        try {
            self::Connect();
            $query = "SELECT * FROM `chat_messages` WHERE `$column` = '$id' AND `is_file` = '1' ORDER BY `id` DESC LIMIT $limit";
            $rs = mysqli_query(self::$con, $query);
            $count = mysqli_num_rows($rs) > 0;
            $messages = [];
            if ($count) {
                while ($row = mysqli_fetch_assoc($rs)) {
                    $row["user"] = User::Where("id", "=", $row["user_id"]);
                    $messages[] = $row;
                }

                return $messages;
            } else {
                print(mysqli_error(self::$con));
                return [];
            }
        } catch (\Throwable $th) {
            return [];
        }
    }

    public static function Create(array $message)
    {
        try {
            self::Connect();
            $mysql = self::$con;
            // chat_id, user_id, project_id, message, message_has, date_created
            // file, file_type, file_size, file_ext, file_bg, me
            $chat_id = mysqli_real_escape_string($mysql, $message["chat_id"]);
            $user_id = mysqli_real_escape_string($mysql, $message["user_id"]);
            $project_id = mysqli_real_escape_string($mysql, $message["project_id"]);
            $hash =  self::GenerateHash();
            $is_file = $message["is_file"];
            if ($is_file) {
                $file = mysqli_real_escape_string($mysql, $message["file"]);
                $file_type = mysqli_real_escape_string($mysql, $message["file_type"]);
                $file_size = mysqli_real_escape_string($mysql, $message["file_size"]);
                $file_ext = mysqli_real_escape_string($mysql, $message["file_ext"]);
                $file_bg = mysqli_real_escape_string($mysql, $message["file_bg"]);
                $file_name = mysqli_real_escape_string($mysql, $message["file_name"]);
                $file_icon = mysqli_real_escape_string($mysql, $message["file_icon"]);
                $query = "INSERT into `chat_messages` (`chat_id`, `user_id`, `project_id`, `file`, `file_name`, `is_file`, `file_icon`, `file_type`, `file_size`, `file_ext`, `file_bg`, `message_hash`, `date_created`) values ('$chat_id', '$user_id', '$project_id', '$file', '$file_name', '1', '$file_icon', '$file_type', '$file_size', '$file_ext', '$file_bg', '$hash', CURRENT_TIMESTAMP)";
            } else {
                $message = mysqli_real_escape_string($mysql, $message["message"]);
                $query = "INSERT into `chat_messages` (`chat_id`, `user_id`, `project_id`, `message`, `message_hash`, `date_created`) values ('$chat_id', '$user_id', '$project_id', '$message', '$hash', CURRENT_TIMESTAMP)";
            }
            $rs = mysqli_query($mysql, $query);
            if ($rs) {
                $user = User::Where("id", "=", $user_id);
                User::UpdateLastLogin($user['matric_no']);
                return true;
            } else {
                print(mysqli_error($mysql));
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
            print($th);
            return false;
        }
    }

    private static function GenerateHash()
    {
        $chars = "abcdefg4hijklmno-p5qrst2uvwxyzabc6defghijklm-nopqrst6uvwxy1zabc6defghij-klmnop6qrstuvwxyz7";
        return substr(str_shuffle($chars), 0, 50);
    }
}
