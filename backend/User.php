<?php

namespace User;

use Project\Project;
use ProjectMember\ProjectMember;

class User
{

    public static $con;


    public static function Connect()
    {
        include("Database.php");
        self::$con = mysqli_connect($host, $user, $password, $db);
    }
    public static function Where(string $column,  string $operator = "=", string $matric)
    {
        try {
            self::Connect();
            $query = "Select * from `users` where `$column` $operator '$matric'";
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

    public static function All(array $params = [])
    {
        try {
            self::Connect();
            $query = "Select * from `users`";
            foreach ($params as $key => $value) {
                if (strpos($query, "where")) {
                    $query .= " and `$key` " . $value[0] . "'$value[1]'";
                } else {
                    $query .= " where `$key` " . $value[0] . " '$value[1]'";
                }
            }
            $users = [];
            $rs = mysqli_query(self::$con, $query);
            $count = mysqli_num_rows($rs) > 0;
            if ($count) {
                while ($row = mysqli_fetch_assoc($rs)) {
                    $users[] = $row;
                }
                return $users;
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            return loadError($th, true, "/register", "Go back");
        }
    }

    public static function Projects(string $id)
    {
        try {
            self::Connect();
            $projects = [];

            $p_members = ProjectMember::Where("user_id", "=", $id);
            if (empty($p_members)) return $projects;

            foreach ($p_members as $memberOf) {
                $of_project = Project::Where("id", "=", $memberOf["project_id"]);
                foreach ($of_project as $p) {
                    $projects[] = $p;
                }
            }
            return $projects;
        } catch (\Throwable $th) {
            return loadError($th, true, "/register", "Go back");
        }
    }

    public static function Has(string $column, $id)
    {
        try {
            self::Connect();
            $query = "Select * from `users` where `id` = '$id'";
            $rs = mysqli_query(self::$con, $query);
            $count = mysqli_num_rows($rs) > 0;
            if ($count) {
                $user = mysqli_fetch_assoc($rs);
                if (!$user[$column] == "") {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            return loadError($th, true, "/register", "Go back");
        }
    }

    public static function UploadPicture($id, $picture)
    {
        try {
            self::Connect();
            $query = "UPDATE `users` SET `profile_image` = '$picture', `profile_completed` = '1' WHERE `matric_no` = '$id'";
            $rs = mysqli_query(self::$con, $query);
            if ($rs) {

                return true;
            } else {
                return "";
            }
        } catch (\Throwable $th) {
            return loadError($th, true, "/register", "Go back");
        }
    }

    public static function UpdateColumn($column, $value, $id)
    {
        try {
            self::Connect();
            $query = "UPDATE `users` SET `$column` = '$value' WHERE `matric_no` = '$id'";
            $rs = mysqli_query(self::$con, $query);
            if ($rs) {
                return true;
            } else {
                return "";
            }
        } catch (\Throwable $th) {
            return loadError($th, true, "/register", "Go back");
        }
    }

    public static function UpdateLastLogin($id)
    {
        try {
            self::Connect();
            $query = "UPDATE `users` SET `last_login` = CURRENT_TIMESTAMP WHERE `matric_no` = '$id'";
            $rs = mysqli_query(self::$con, $query);
            if ($rs) {
                return true;
            } else {
                return "";
            }
        } catch (\Throwable $th) {
            return loadError($th, true, "/register", "Go back");
        }
    }
}
