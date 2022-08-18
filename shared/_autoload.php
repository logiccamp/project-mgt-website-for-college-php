<?php


function loadNavigation()
{
    require(__DIR__ . "/nav.php");
}


function loadDashboardNav($mode, $user)
{
    require(__DIR__ . "/dashboard_nav.php");
}

function loadEditorNav($mode, $user, $doc)
{
    require(__DIR__ . "/editor_nav.php");
}


function loadDashboardSidebar($modeTheme)
{
    require(__DIR__ . "/dashboard_side_card.php");
}

function loadProjectSidebar($mode, $modeTheme, $project)
{
    require(__DIR__ . "/project_sidebar_card.php");
}

function loadUserProfile()
{
    require(__DIR__ . "/profile_owner.php");
}


function loadUserProfile_v()
{
    require(__DIR__ . "/profile_visitor.php");
}

function loadProjectHeader($modeTheme, $project)
{
    require(__DIR__ . "/project_header.php");
}
function loadError($message, $button = false, $link = "", $button_text = "")
{
    require(__DIR__ . "/error.php");
}
