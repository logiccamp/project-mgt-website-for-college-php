<?php

namespace Auth;

include("User.php");

use User\User;

class Auth
{

    public static $con;

    public static function Connect()
    {
        include("Database.php");
        self::$con = mysqli_connect($host, $user, $password, $db);
    }

    public static function Login(array $user)
    {
        try {
            self::Connect();
            $matric_no = mysqli_real_escape_string(self::$con, $user['matric_no']);
            $userPassword = mysqli_real_escape_string(self::$con, $user['password']);

            $query = "Select * from `users` where `matric_no` = '$matric_no'";
            $rs = mysqli_query(self::$con, $query);
            $count = mysqli_num_rows($rs) > 0;
            if ($count) {
                $user = mysqli_fetch_assoc($rs);
                if (password_verify($userPassword, $user["password"])) {
                    User::updateLastLogin($matric_no);
                    return [
                        "status" => true,
                        "message" => "user Logged in",
                    ];
                } else {
                    return [
                        "status" => false,
                        "message" => "Invalid login combination",
                    ];
                }
            } else {
                return [
                    "status" => false,
                    "message" => "Invalid Login Combination",
                ];
            }
        } catch (\Throwable $th) {
            loadError($th);
        }
    }

    public static function Register(array $user, $role = "student")
    {
        self::Connect();
        try {
            $matricNo = mysqli_real_escape_string(self::$con, $user["matric_no"]);
            $full_name = $user["full_name"];
            $password = $user["password"];
            $password_confirmation = $user["password_confirmation"];
            $isUser = User::Where('matric_no', "=", $matricNo);
            if ($role == "student") {
                $email = $user["email"];
                if (substr_count($user["matric_no"], "/") !== 3) {
                    return [
                        "status" => false,
                        "message" => "Invalid matric no",
                    ];
                }
                if (strlen($matricNo) < 15) {
                    return [
                        "status" => [false],
                        "message" => "Invalid matric no",
                    ];
                }
                if ($email == "") {
                    return [
                        "status" => [false],
                        "message" => "Invalid email address",
                    ];
                }
            } else {
                $email = $matricNo;
            }
            if ($password !== $password_confirmation) {
                return [
                    "status" => false,
                    "message" => "password not matched",
                ];
            }

            if ($isUser !== null) {
                return [
                    "status" => false,
                    "message" => "User already exist",
                ];
            }

            $hashed = password_hash($password, PASSWORD_DEFAULT);
            if ($role == "student") {
                $query = "INSERT into `users` (`id`, `matric_no`, `full_name`, `password`, `email`, `date_registered`) VALUES(NULL, '$matricNo', '$full_name', '$hashed','$email', CURRENT_TIMESTAMP)";
            } else {
                $query = "INSERT into `users` (`id`, `matric_no`, `full_name`, `password`, `email`, `role_name`, `date_registered`) VALUES(NULL, '$matricNo', '$full_name', '$hashed', '$email', '$role', CURRENT_TIMESTAMP)";
            }
            $rs = mysqli_query(self::$con, $query);
            if ($rs) {
                return [
                    'status' => true,
                ];
            } else {
                loadError(mysqli_error(self::$con), true, "/register", "Go back");
            }
        } catch (\Throwable $th) {
            loadError($th);
        }
    }
}
