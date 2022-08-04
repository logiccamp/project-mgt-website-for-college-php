<?php
$user = User\User::Where("matric_no", "=", $_SESSION["user_id"]);
$projects = User\User::Projects($user["id"]);

$avatar = "/assets/img/user_avatar_2.png";
$userImage = '/assets/img/users/' . $user["profile_image"];
?>

<div class="col-lg-4">
    <div class="p-2 py-5 text-center">
        <div class="user_avatar">
            <img src="<?php echo if__else($user["profile_image"], "", $avatar, $userImage); ?>" class=" rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: fill" alt="Avatar" />
            <h5 class="mb-2 <?php echo $modeTheme; ?>"><strong><?php echo $user["full_name"]; ?></strong></h5>
            <h6 class="mb-2 <?php echo $modeTheme; ?>"><strong><?php echo $user["matric_no"]; ?></strong></h6>
            <p class=" text-muted">
                <span class="badge <?php echo 'bg_' . $user['role_name']; ?>">
                    <span class="fa fa-crown"></span> <?php echo $user['role_name']; ?></span>
            </p>
            <div class="d-flex justify-content-evenly">
                <p class="text-muted small-font"><span class="fa fa-briefcase"></span> Project(s) - <?php echo count($projects); ?></span></p>
                <!-- <p class="text-muted small-font"><span class="fa fa-briefcase"></span> Members - 2</span></p> -->
            </div>
        </div>
    </div>
</div>