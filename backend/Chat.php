<?php

namespace Chat;

use ChatMessage\ChatMessage;

class Chat
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
            $query = "Select * from `chats` where `$column` $operator '$value'";
            $rs = mysqli_query(self::$con, $query);
            $count = mysqli_num_rows($rs) > 0;
            if ($count) {
                $chat = mysqli_fetch_assoc($rs);
                return $chat;
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            return null;
        }
    }

    public static function Create(array $chat)
    {
        try {
            self::Connect();

            // chat_hash, has_project, project_id, date_created
            $hash =  self::GenerateHash();
            $project_id = $chat["project_id"];
            $has_project = $chat["has_project"];
            $chat["chat_hash"] = $hash;

            $query = "INSERT into `chats` (`chat_hash`, `project_id`, `has_project`, `date_created`) values('$hash', '$project_id', '$has_project', CURRENT_TIMESTAMP)";
            $rs = mysqli_query(self::$con, $query);
            if ($rs) {
                return [
                    "status" => true,
                    "chat" => $chat,
                ];
            } else {
                return [
                    "status" => false,
                    "error" => mysqli_error(self::$con),
                ];
            }
        } catch (\Throwable $th) {
            //throw $th;
            print_r("error");
        }
    }
    public static function Messages($id)
    {
        return ChatMessage::Where("chat_id", "=", $id);
    }
    private static function GenerateHash()
    {
        $chars = "abcdefg4hijklmno-p5qrst2uvwxyzabc6defghijklm-nopqrst6uvwxy1zabc6defghij-klmnop6qrstuvwxyz7";
        return substr(str_shuffle($chars), 0, 50);
    }
}
