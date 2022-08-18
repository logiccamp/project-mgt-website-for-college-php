<?php include("_autoload.php"); ?>

<!-- change theme -->
<?php
if (isset($_GET["action"])) :
    switch ($_GET["action"]) {
        case 'change_theme':
            if (changeTheme()) header("Location: " . getUrl());
            break;
    }
endif;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> SUPER VISE</title>
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/vendors/bootstrap/bootstrap.css">
    <link rel="stylesheet" href="/vendors/dropzone/dropzone.min.css">
    <link rel="stylesheet" href="/vendors/toastr/toastr.min.css">

    <!-- register styles -->
    <?php
    if ($pagetype == "dashboard" || $pagetype == "editor") : ?>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="/assets/css/dashboard.css" />
        <link rel="stylesheet" href="/assets/css/panel.css" />
        <link rel="stylesheet" href="/assets/css/chat.css" />
        <link rel="stylesheet" href="/vendors/perfect-scrollbar/css/mdb.min.css" />
        <link rel="stylesheet" href="/assets/css/editor.css">
    <?php else : ?>
        <link rel="stylesheet" href="/vendors/fontawesome/all.min.css" />
        <link rel="stylesheet" href="/assets/css/home.css" />
        <link rel="stylesheet" href="/assets/css/auth.css" />
    <?php endif; ?>
</head>


<body class='<?php echo "bg-" . $mode; ?>' style="overflow-x: hidden">
    <?php
    if ($pagetype == "dashboard") :
        $activeUser = User\User::Where("matric_no", "=", $_SESSION['user_id']);
        loadDashboardNav($mode, $activeUser);
    elseif ($pagetype == "editor") :
        loadEditorNav($mode, $activeUser, $doc);

    else :
        loadNavigation();
    endif;
    ?>