<?php

namespace Profile;

class Student
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
            $query = "Select * from `student_profiles` where `$column` $operator '$value'";
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

    public static function Add(array $profile, $user)
    {
        try {
            self::Connect();
            $school = mysqli_real_escape_string(self::$con, $profile["school"]);
            $program = mysqli_real_escape_string(self::$con, $profile["program"]);
            $level = mysqli_real_escape_string(self::$con, $profile["level"]);
            $department = mysqli_real_escape_string(self::$con, $profile["department"]);
            $gender = mysqli_real_escape_string(self::$con, $profile["gender"]);
            // student_profiles, level, program, school, department, gender, user_id
            $query = "Insert into `student_profiles` (`level`, `program`, `school`, `department`, `gender`, `user_id`) values('$level', '$program', '$school', '$department', '$gender', '$user')";
            $rs = mysqli_query(self::$con, $query);
            if ($rs) {
                return [
                    "status" => true,
                    "profile" => mysqli_insert_id(self::$con),
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
