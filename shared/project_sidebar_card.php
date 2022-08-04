<?php
$supervisor = User\User::Where("id", "=", $project["supervisor"]);
$leaders = Project\Project::GetMultiple("groupleaders", $project["id"]);
$membersList = Project\Project::GetMultiple("membersList", $project["id"]);
$supervisor = User\User::Where("id", "=", $project["supervisor"]);
$avatar = "/assets/img/user_avatar_2.png";
?>

<div class="col-lg-4">
    <div class='p-2 py-5 text-center'>
        <h6 class="mb-2 <?php echo $modeTheme; ?>"><strong>Topic</strong></h6>
        <p class="<?php echo $modeTheme; ?>"><?php echo $project['project_title']; ?>.</p>
        <hr>
        <div class=" user_avatar">
            <h6 class="mb-3 <?php echo $modeTheme; ?>"><strong>Supervisor</strong></h6>
            <img src="<?php echo if__else($supervisor['profile_image'], '', $avatar, '../assets/img/users/' . $supervisor['profile_image']); ?>" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover" alt="Avatar" />
            <h5 class="mb-2 <?php echo $modeTheme; ?>"><strong><?php echo $supervisor["full_name"]; ?></strong></h5>
            <!-- <small class="mb-2 <?php echo $modeTheme; ?>"><strong>Dept. Computer Sci.</strong></small> -->
        </div>
        <hr>
        <div class=" user_avatar">
            <h6 class="mb-3 <?php echo $modeTheme; ?>"><strong>Group Leader</strong></h6>
            <?php
            foreach ($leaders as $lead) {
                $thisImage = "../assets/img/users/" . $lead['profile_image'];
            ?>
                <img src="<?php echo if__else($lead["profile_image"], "", $avatar, $thisImage); ?>" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover" alt="Avatar" />
                <h5 class="mb-2 <?php echo $modeTheme; ?>"><strong><?php echo $lead['full_name']; ?></strong></h5>
                <small class="mb-2 <?php echo $modeTheme; ?>"><strong><?php echo $lead['matric_no']; ?></strong></small>
            <?php } ?>
        </div>

        <hr>
        <div class=" user_avatar">
            <h6 class="mb-3 <?php echo $modeTheme; ?>"><strong>Group Members</strong></h6>
            <?php

            foreach ($membersList as $member) {
                $thisImage = "../assets/img/users/" . $member['profile_image'];
            ?>
                <div class='d-flex align-items-center student-card card flex-row p-2 my-2 <?php echo 'bg-' . $mode; ?>'>
                    <div>
                        <img src="<?php echo if__else($member["profile_image"], "", $avatar, $thisImage); ?>" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover" alt="Avatar" />
                    </div>
                    <div class="mx-2"></div>
                    <div class="text-start">
                        <h6 class="mb-2 <?php echo $modeTheme; ?>"><strong><?php echo $member['full_name']; ?></strong></h6>
                        <small class="mb-2 <?php echo $modeTheme; ?>"><strong><?php echo $member['matric_no']; ?></strong></small>
                    </div>
                </div>
            <?php } ?>


        </div>

    </div>
</div>