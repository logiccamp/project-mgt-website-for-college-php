<!-- navbar -->

<?php
$avatar = "/assets/img/user_avatar_2.png";
$userImage = '/assets/img/users/' . $user["profile_image"];
?>
<nav class="navbar navbar-expand-lg navbar-light py-0 my-0 fixed-top bg-light">
    <div class="container-fluid ">
        <div class="fw-bold">
            <input type="text" class="form-control" value="<?php echo $doc == '' ? 'Document ' : $doc['file_name']; ?> ">
        </div>

        <div class=" justify-content-end" id="navbarColor01">
            <ul class="navbar-nav d-flex align-items-center flex-row">
                <li class="nav-item">
                    <a class="nav-link position-relative" href="#?" id="saveDoc">
                        Save
                    </a>
                </li>
                <div class="mx-2"></div>
                <li class="nav-item position-relative left-0">
                    <a class="nav-link d-flex align-items-center" href="#?" id="toggleAvatar">
                        <img src="<?php echo if__else($user["profile_image"], "", $avatar, $userImage); ?>" class="rounded-circle avatar-caretdown" alt="Avatar" height="50" width="50" />
                        <span class="text-white fa fa-caret-down"></span>
                    </a>
                    <div class="shadow-sm bg-white rounded-0 position-absolute p-2 drop avartarDrop">
                        <a href="/portal/dashboard" class="nav-item d-block _primary_color"> <span class="fa fa-user"></span> &nbsp; Dashboard</a>
                        <a href="/portal/profile" class="nav-item d-block _primary_color"> <span class="fa fa-user"></span> &nbsp; Profile</a>
                        <a href="/logout" class="nav-item d-block _primary_color"> <span class="fa fa-bell"></span> &nbsp; Logout</a>
                    </div>
                </li>
                <div class="ml-2"></div>

            </ul>

        </div>
    </div>
</nav>