<?php

namespace Project;

use ProjectMember\ProjectMember;
use User\User;

class Project
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
            $query = "Select * from `projects` where `$column` $operator '$value'";
            $rs = mysqli_query(self::$con, $query);
            $count = mysqli_num_rows($rs) > 0;
            $projects = [];
            if ($count) {
                while ($row = mysqli_fetch_assoc($rs)) {
                    $projects[] = $row;
                }
                return $projects;
            } else {
                return [];
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

    public static function All(array $params = [])
    {
        try {
            self::Connect();
            $query = "SELECT * FROM `projects`";
            $projects = [];
            $rs = mysqli_query(self::$con, $query);
            if ($rs) {
                while ($row = mysqli_fetch_assoc($rs)) {
                    $projects[] = $row;
                }
                return $projects;
            } else {
                return [];
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function GetMultiple($param, $this_id)
    {
        try {
            switch ($param) {
                case 'membercount':
                    return count(ProjectMember::Where("project_id", "=", $this_id));
                    break;
                case 'groupleaders':
                    $leaders = ProjectMember::Leaders($this_id);
                    $users = [];
                    foreach ($leaders as $lead) {
                        $users[] = User::Where("id", "=", $lead["user_id"]);
                    }
                    return $users;
                    break;
                case 'membersList':
                    $leaders = ProjectMember::Members($this_id);
                    $users = [];
                    foreach ($leaders as $lead) {
                        $users[] = User::Where("id", "=", $lead["user_id"]);
                    }
                    return $users;
                    break;
                case 'allMembers':
                    $members = ProjectMember::Where("project_id", "=", $this_id);
                    $users = [];
                    foreach ($members as $member) {
                        $users[] = User::Where("id", "=", $member["user_id"]);
                    }
                    return $users;
                    break;

                default:
                    # code...
                    break;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public static function Chat($this_id)
    {
        try {
            self::Connect();
            $query = "SELECT * FROM `chats` where `project_id` = '$this_id'";
            $projects = [];
            $rs = mysqli_query(self::$con, $query);
            if ($rs) {
                $chat = mysqli_fetch_assoc($rs);
                return $chat;
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
