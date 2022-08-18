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

    public static function Add(array $project)
    {
        try {
            self::Connect();
            $project_title = mysqli_real_escape_string(self::$con, $project["title"]);
            $description = mysqli_real_escape_string(self::$con, $project["description"]);
            $supervisor = mysqli_real_escape_string(self::$con, $project["supervisor"]);
            $chapters = mysqli_real_escape_string(self::$con, $project["chapters"]);
            $chars = "123456789";
            $project_id = substr(str_shuffle($chars), 0, 10);
            $query = "Insert into `projects` (`project_title`, `project_id`, `description`, `supervisor`, `date_added`, `chapters`) values('$project_title', '$project_id', '$description', '$supervisor', CURRENT_TIMESTAMP, '$chapters')";
            $rs = mysqli_query(self::$con, $query);
            if ($rs) {
                return [
                    "status" => true,
                    "project" => mysqli_insert_id(self::$con),
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
}
