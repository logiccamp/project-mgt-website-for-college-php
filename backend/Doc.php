<?php

namespace Doc;

use ChatMessage\ChatMessage;
use ProjectMember\ProjectMember;
use User\User;

class Doc
{

    public static $con;


    public static function Connect()
    {
        include("Database.php");
        self::$con = mysqli_connect($host, $user, $password, $db);
    }
    public static function Where(string $column,  string $value)
    {
        try {
            self::Connect();
            $query = "Select * from `docs` where `$column` = '$value'";
            $rs = mysqli_query(self::$con, $query);
            $count = mysqli_num_rows($rs) > 0;
            $docs = [];
            if ($count) {
                while ($row = mysqli_fetch_assoc($rs)) {
                    $docs[] = $row;
                }
                return $docs;
            } else {
                return [];
            }
        } catch (\Throwable $th) {
            return loadError($th, true, "/register", "Go back");
        }
    }

    public static function Get(string $column,  string $value)
    {
        try {
            self::Connect();
            $query = "Select * from `docs` where `$column` = '$value'";
            $rs = mysqli_query(self::$con, $query);
            $count = mysqli_num_rows($rs) > 0;
            if ($count) {
                return mysqli_fetch_assoc($rs);
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            return loadError($th, true, "/register", "Go back");
        }
    }

    public static function Add(array $doc)
    {
        try {
            self::Connect();
            $project = mysqli_real_escape_string(self::$con, $doc["project_id"]);
            $user = mysqli_real_escape_string(self::$con, $doc["user_id"]);
            $content = $doc["content"];
            $file_name = mysqli_real_escape_string(self::$con, $doc["file_name"]);

            $chars = "123456789";
            $doc_id = substr(str_shuffle($chars), 0, 10);
            $docLocation = "../assets/docs/" . $doc_id . ".super";
            $file_location = $doc_id . ".super";
            $docFile = fopen($docLocation, "w");
            fwrite($docFile, $content);
            fclose($docFile);
            $query = "INSERT INTO `docs` (`doc_id`, `project_id`, `user_id`, `file_location`, `file_name`, `date_created`) VALUES ('$doc_id', '$project', '$user', '$file_location', '$file_name', CURRENT_TIMESTAMP)";
            $rs = mysqli_query(self::$con, $query);
            if ($rs) {
                return [
                    "status" => true,
                    "doc" => $doc_id,
                ];
            } else {
                return [
                    "status" => false,
                    "error" => mysqli_error(self::$con),
                ];
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function Update(array $doc, $doc_id)
    {
        try {
            self::Connect();
            $content = $doc["content"];
            $file_name = mysqli_real_escape_string(self::$con, $doc["file_name"]);

            $docLocation = "../assets/docs/" . $doc_id . ".super";
            $docFile = fopen($docLocation, "w");
            fwrite($docFile, $content);
            fclose($docFile);


            $query = "UPDATE `docs` SET `file_name` = '$file_name' WHERE `doc_id` = '$doc_id'";
            $rs = mysqli_query(self::$con, $query);
            if ($rs) {
                return [
                    "status" => true,
                    "doc" => $doc_id,
                ];
            } else {
                return [
                    "status" => false,
                    "error" => mysqli_error(self::$con),
                ];
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public static function DeleteDoc($doc)
    {
        $query = "DELETE FROM `docs` WHERE `doc_id` = '$doc'";

        mysqli_query(self::$con, $query);
        return true;
    }
}
