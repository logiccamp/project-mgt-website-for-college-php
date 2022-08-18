<?php
include(__DIR__ . '/../backend/Auth.php');
include(__DIR__ . '/../backend/ProjectMembers.php');
include(__DIR__ . '/../backend/Project.php');
include(__DIR__ . '/../backend/Profile.php');
include(__DIR__ . '/../backend/Schools.php');
include(__DIR__ . '/../backend/Chat.php');
include(__DIR__ . '/../backend/ChatMessages.php');
include(__DIR__ . '/../backend/Doc.php');


use Project\Project;
use ProjectMember\ProjectMember;
use Chat\Chat;
use Doc\Doc;



$loadChatBot = false;
$formSuccess = "";
$formError = "";
// <!-- get theme -->
function getTheme()
{
    if (isset($_COOKIE["theme"])) return $mode = $_COOKIE["theme"];
    return $mode = "light";
}

function if__else($check, $value = true, $return, $return_else)
{
    if ($check == $value) return $return;
    return $return_else;
}
function getUrl()
{
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    if (strpos($url, "?")) return substr($url, 0, strpos($url, "?"));
    return $url; // Outputs: Full URL
}

function changeTheme()
{
    if (isset($_GET["theme"])) {

        if ($_GET["theme"] != 'dark' && $_GET["theme"] != 'light') return false;
        setCookie("theme", $_GET["theme"]);
        return true;
    }
}



function get_time_ago($datetime, $full = false)
{
    $now = date_create('now', new DateTimeZone("UTC +1"));
    $ago = date_create($datetime, new DateTimeZone("UTC +1"));;
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
