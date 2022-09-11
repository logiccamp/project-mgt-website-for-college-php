<?php

namespace User;

use Project\Project;
use ProjectMember\ProjectMember;
use ChatMessage\ChatMessage;

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

    public static function Projects(string $id, $role = "student")
    {
        try {
            self::Connect();
            $projects = [];
            if ($role == "student") :
                $p_members = ProjectMember::Where("user_id", "=", $id);
                if (empty($p_members)) return $projects;

                foreach ($p_members as $memberOf) {
                    $of_project = Project::Where("id", "=", $memberOf["project_id"]);
                    foreach ($of_project as $p) {
                        $projects[] = $p;
                    }
                }
            else :
                $of_project = Project::Where("supervisor", "=", $id);
                foreach ($of_project as $p) {
                    $projects[] = $p;
                }
            endif;
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

    public static function Chats(string $id, $role = "student")
    {
        try {
            self::Connect();
            $projects = [];
            $chats = ChatMessage::WhereDistinct($id);
            return $chats;
        } catch (\Throwable $th) {
            return loadError($th, true, "/register", "Go back");
        }
    }
    public static function saveToken($email, $token)
    {
        $expired = time() + 100;
        $query = "INSERT into `password_resets` (`id`, `email`, `token`, `expired_at`) VALUES(NULL, '$email', '$token', '$expired')";
        $rs = mysqli_query(self::$con, $query);
        if ($rs) {
            return true;
        } else {
            return null;
        }
    }

    public static function voidTokens($email)
    {
        $value = 1;
        $query = "UPDATE `password_resets` SET `status` = '1' WHERE `email` = '$email'";
        mysqli_query(self::$con, $query);
    }

    public static function updatePassword($id, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        try {
            self::Connect();
            $query = "UPDATE `users` SET `password` = '$hash' WHERE `id` = '$id'";
            $rs = mysqli_query(self::$con, $query);
            if ($rs) {
                return true;
            } else {
                return null;
            }
        } catch (\Throwable $th) {
            return loadError($th, true, "/register", "Go back");
        }
    }

    public static function getToken($token)
    {
        try {
            self::Connect();
            $query = "Select * from `password_resets` where `token` = '$token'";
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
}
