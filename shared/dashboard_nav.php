<!-- navbar -->

<?php
$avatar = "/assets/img/user_avatar_2.png";
$userImage = '/assets/img/users/' . $user["profile_image"];

$bg = '_primary-bg';
if ($user["role_name"] == "student") {
} else {
    $bg = '_secondary_bg';
}


?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top <?php echo $mode == "dark" ? 'bg-dark' : $bg; ?>">
    <div class="container-fluid ">
        <a class="navbar-brand fw-bold" href="/portal/dashboard">SuperVISE</a>

        <div class="justify-content-end" id="navbarColor01">
            <ul class="navbar-nav d-flex align-items-center flex-row">
                <li class="nav-item">
                    <a class="nav-link position-relative" href="/">
                        <i class="fa fa-bell"></i> <small class="text-white position-absolute top-0 small-font">0</small>
                    </a>
                </li>
                <div class="mx-2"></div>
                <li class="nav-item position-relative left-0">
                    <a class="nav-link d-flex align-items-center" href="#?" id="toggleAvatar">
                        <img src="<?php echo if__else($user["profile_image"], "", $avatar, $userImage); ?>" class="rounded-circle avatar-caretdown" alt="Avatar" />
                        <span class="text-white fa fa-caret-down"></span>
                    </a>
                    <div class="shadow-sm bg-white rounded-0 position-absolute p-2 drop avartarDrop">
                        <a href="/portal/dashboard" class="nav-item d-block _primary_color"> <span class="fa fa-user"></span> &nbsp; Dashboard</a>
                        <a href="/portal/profile" class="nav-item d-block _primary_color"> <span class="fa fa-user"></span> &nbsp; Profile</a>
                        <a href="/logout" class="nav-item d-block _primary_color"> <span class="fa fa-bell"></span> &nbsp; Logout</a>
                    </div>
                </li>
                <div class="ml-2"></div>
                <li class="nav-item position-relative left-0">
                    <a class="nav-link badge d-flex align-items-center" href="#?" id="toggleTheme">
                        &nbsp;<span class="is_desktop is_tablet">Change</span> &nbsp;<span class="text-white fa fa-moon-o"></span>
                    </a>
                    <div class="shadow-sm bg-white rounded-0 position-absolute p-2 drop themeDrop">
                        <a href="<?php echo getUrl() . '?action=change_theme&theme=light'; ?>" class="nav-item _primary_bg d-block text-white p-1"> &nbsp; Default</a>
                        <a href="<?php echo getUrl() . '?action=change_theme&theme=dark'; ?>" class="nav-item bg-dark d-block text-light p-1"> &nbsp; Dark</a>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</nav>