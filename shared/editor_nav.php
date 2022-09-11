<!-- navbar -->

<?php
$avatar = "/assets/img/user_avatar_2.png";
$userImage = '/assets/img/users/' . $user["profile_image"];
$bg = '_primary_bg';


?>
<nav class="navbar navbar-expand-lg navbar-dark py-0 my-0 fixed-top <?php echo $mode == "dark" ? 'bg-dark' : $bg; ?>"">
    <div class=" container-fluid ">
        <div class=" fw-bold">
    <input type="text" class="form-control" id="file_name" value="<?php echo $doc == '' ? 'Document ' : $doc['file_name']; ?> ">
    </div>

    <div class=" justify-content-end" id="navbarColor01">
        <ul class="navbar-nav d-flex align-items-center flex-row">
            <li class="nav-item">
                <a class="nav-link position-relative text-white" href="#?" id="saveDoc">
                    <span class="fa fa-save"></span>
                    <span id="saveSpan" class="d-none d-lg-inline d-md-none d-sm-none">Save</span>
                </a>
            </li>
            <div class="mx-2"></div>
            <li class="nav-item position-relative left-0 d-none d-lg-inline d-md-none d-sm-none">
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
            <div class="mx-2"></div>
            <li class="nav-item">
                <a class="nav-link text-danger bg-white btn fw-bold shadow px-2 py-1 rounded-pill position-relative" href="/portal/project?project=<?php echo $project['project_id']; ?>" id="closeEditor" style="font-size: 18px">
                    &times;
                </a>
            </li>

        </ul>

    </div>
    </div>
</nav>