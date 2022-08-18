<?php

namespace ProjectMember;



class ProjectMember
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
            $query = "SELECT * FROM `project_members` WHERE `$column` $operator '$value'";
            $rs = mysqli_query(self::$con, $query);
            $count = mysqli_num_rows($rs) > 0;
            $projects = [];
            if ($count) {
                while ($row = mysqli_fetch_assoc($rs)) {
                    $projects[] = $row;
                }

                return $projects;
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            return loadError($th, true, "/register", "Go back");
        }
    }

    public static function Leaders(string $project_id)
    {
        try {
            self::Connect();
            $query = "SELECT * FROM `project_members` WHERE `project_id` = '$project_id' and `role` = '1'";
            $rs = mysqli_query(self::$con, $query);
            $count = mysqli_num_rows($rs) > 0;
            $projects = [];
            if ($count) {
                while ($row = mysqli_fetch_assoc($rs)) {
                    $projects[] = $row;
                }

                return $projects;
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            return loadError($th, true, "/register", "Go back");
        }
    }


    public static function Members(string $project_id)
    {
        try {
            self::Connect();
            $query = "SELECT * FROM `project_members` WHERE `project_id` = '$project_id' and `role` = '2'";
            $rs = mysqli_query(self::$con, $query);
            $count = mysqli_num_rows($rs) > 0;
            $projects = [];
            if ($count) {
                while ($row = mysqli_fetch_assoc($rs)) {
                    $projects[] = $row;
                }
                return $projects;
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            return loadError($th, true, "/register", "Go back");
        }
    }

    public static function Add(string $user, string $project_id, string $role)
    {
        try {
            $id = $user;

            self::Connect();
            $query = "INSERT into `project_members` (`user_id`, `project_id`, `role`, `date_joined`) values('$id', '$project_id', '$role', CURRENT_TIMESTAMP)";
            $rs = mysqli_query(self::$con, $query);
            if ($rs) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
