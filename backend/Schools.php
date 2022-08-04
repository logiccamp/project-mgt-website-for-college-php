<?php

namespace Schools;

class Schools
{
    public static $con;


    public static function Connect()
    {
        include("Database.php");
        self::$con = mysqli_connect($host, $user, $password, $db);
    }

    public static function All()
    {
        try {
            self::Connect();
            $query = "SELECT *  from `schools`";
            $schools = [];
            $rs = mysqli_query(self::$con, $query);
            if ($rs) {
                while ($row = mysqli_fetch_assoc($rs)) {
                    $schools[] = $row;
                }
            } else {
            }
            return $schools;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function Get(string $id)
    {
        try {
            self::Connect();
            $query = "SELECT * from `schools` where `id`= '$id'";
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



class Departments
{
    public static $con;


    public static function Connect()
    {
        include("Database.php");
        self::$con = mysqli_connect($host, $user, $password, $db);
    }

    public static function All()
    {
        try {
            self::Connect();
            $query = "SELECT *  from `departments`";
            $departments = [];
            $rs = mysqli_query(self::$con, $query);
            if ($rs) {
                while ($row = mysqli_fetch_assoc($rs)) {
                    $departments[] = $row;
                }
            } else {
            }
            return $departments;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function Get(string $id)
    {
        try {
            self::Connect();
            $query = "Select * from `departments` where `id` = '$id'";
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
