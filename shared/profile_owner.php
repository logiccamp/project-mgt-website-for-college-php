<?php
$UserClass = new User\User;
$user = User\User::Where("matric_no", '=', $_SESSION["user_id"]);
$profilesList = Profile\Student::Where("user_id", "=", $user["id"]);
$hasProfile = count($profilesList) > 0;
$profile = $hasProfile ? $profilesList[0] : [];
$showUploadPic = false;
$hasProfilePicture = $UserClass::Has("profile_image", $user["id"]);

if ($hasProfile) {
    if (!$hasProfilePicture) {
        $showUploadPic = true;
    }
}
$schools = Schools\Schools::All();
$departments = Schools\Departments::All();


$formError = "";
$formSuccess = "";
if (isset($_POST['updateProfile'])) {
    $level = $_POST["level"];
    $program = $_POST["program"];
    $school = $_POST["school"];
    $department = $_POST["department"];
    $gender = $_POST["gender"];

    $profilePost = array(
        "level" => $level,
        "program" => $program,
        "school" => $school,
        "department" => $department,
        "gender" => $gender,
    );
    if (!$hasProfile) {
        $studentProfile = Profile\Student::Add($profilePost, $user["id"]);
    } else {
        $studentProfile = Profile\Student::Add($profilePost, $user["id"]);
    }

    if ($studentProfile) {
        if ($studentProfile["status"] == true) {
            $formError = "";
            $formSuccess = "New profile updated. redirecting...";
            echo "<script> setTimeout(()=>{window.location.assign('/portal/dashboard')},1000) </script>";
        } else {
            $formError = "Unable to update profile";
            $formSuccess = "";
        }
    } else {
        loadError("Something went wrong, please reload the page");
    }
}
?>

<div class="modal fade" id="domainForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header text-center">
                <div class="w-100">
                    <h3 class="modal-title my-2 w-100 font-weight-bold">ADD DOMAIN</h3>
                </div>
            </div> -->
            <form action="/portal/profile.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="exampleModalLabel">Update Profile</h5>
                    <button type="button" class="close btn rounded btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-3">
                        <label for="level">Level</label>
                        <select name="level" class="form-control form-select" id="level">
                            <option value="">Select</option>
                            <option <?php echo $hasProfile && $profile['level'] == 'ND2' ? 'selected' : ''; ?> value="ND2">ND2</option>
                            <option <?php echo $hasProfile && $profile['level'] == 'ND3' ? 'selected' : ''; ?> value="ND3">ND3</option>
                            <option <?php echo $hasProfile && $profile['level'] == 'HND2' ? 'selected' : ''; ?> value="HND2">HND2</option>
                            <option <?php echo $hasProfile && $profile['level'] == 'HND3' ? 'selected' : ''; ?> value="HND3">HND3</option>
                            <option <?php echo $hasProfile && $profile['level'] == 'BSc 400L' ? 'selected' : ''; ?> value="HND3" value="BSc 400L">BSc 400L</option>
                            <option <?php echo $hasProfile && $profile['level'] == 'BSc 500L' ? 'selected' : ''; ?> value="BSc 500L">BSc 500L</option>
                        </select>
                        <div class="invalid-feedback" id="meta_title_error"></div>
                    </div>

                    <div class="md-form mb-3">
                        <label for="program">Program</label>
                        <select name="program" class="form-control form-select" id="program">
                            <option value="">Select</option>
                            <option <?php echo $hasProfile && $profile['program'] == 'ND Full Time' ? 'selected' : ''; ?> value="ND Full Time">ND Full Time</option>
                            <option <?php echo $hasProfile && $profile['program'] == 'HND Full Time' ? 'selected' : ''; ?> value="HND Full Time">HND Full Time</option>
                            <option <?php echo $hasProfile && $profile['program'] == 'ND Part Time' ? 'selected' : ''; ?> value="ND Part Time">ND Part Time</option>
                            <option <?php echo $hasProfile && $profile['program'] == 'HND Part Time' ? 'selected' : ''; ?> value="HND Part Time">HND Part Time</option>
                            <option <?php echo $hasProfile && $profile['program'] == 'BSc' ? 'selected' : ''; ?> value="BSc">BSc</option>
                        </select>
                        <div class="invalid-feedback" id="meta_title_error"></div>
                    </div>
                    <div class="md-form mb-3">

                        <label for="school">School</label>
                        <select name="school" class="form-control form-select" id="school">
                            <option value="">Select</option>
                            <?php

                            foreach ($schools as $school) { ?>
                                <option <?php echo $hasProfile && $profile['school'] == $school['id'] ? 'selected' : ''; ?> value="<?php echo $school['id']; ?>"><?php echo $school["title"]; ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback" id="meta_title_error"></div>
                    </div>

                    <div class="md-form mb-3">
                        <label for="department">Department</label>
                        <select name="department" class="form-select form-control" id="department">
                            <option value="">Select</option>
                            <?php
                            foreach ($departments as $department) { ?>
                                <option <?php echo $hasProfile && $profile['department'] == $department['id'] ? 'selected' : ''; ?> value="<?php echo $department['id']; ?>"><?php echo $department["title"];; ?></option>
                            <?php } ?>
                        </select>
                        <div class="invalid-feedback" id="meta_title_error"></div>
                    </div>

                    <div class="md-form mb-3">
                        <label for="gender">Gender</label>
                        <select name="gender" class="form-select form-control" id="gender">
                            <option value="">Select</option>
                            <option <?php echo $hasProfile && $profile['gender'] == 'Male' ? 'selected' : ''; ?> value="Male">Male</option>
                            <option <?php echo $hasProfile && $profile['gender'] == 'Female' ? 'selected' : ''; ?> value="Female">Female</option>

                        </select>
                        <div class="invalid-feedback" id="meta_title_error"></div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button name="updateProfile" id="updateDomain" class="btn _primary_bg text-white">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="overlay_container" id="uploadProfileImageOverlay" style='display: <?php echo $showUploadPic ? "block" : "none"; ?>'>
    <div class="overlay_inner">
        <div class="shadow w-100 rounded-0 bg-white p-3 mx-auto position-relative">
            <div class="alert alert-success fileSuccess" style="display: none">Upload success</div>
            <div class="alert alert-danger fileError" style="display: none">Unable to upload</div>
            <h3 class="text-dark text-center fw-bold fs-5">Upload Profile Picture</h3>
            <a href="#?" id="closeOverlay" class="rounded-pill shadow-sm bg-white p-2 py-1 text-danger position-absolute" style="right: -10px; top: -10px"><i class="fa fa-close"></i></a>
            <div id="owner_error" class="text-danger text-center"></div>
            <div class="upload-preview" for="profileImage" id="uploadFile">
                <label for="uploadImage">Click here to select file</label>
            </div>
            <div align="center">
                <input data-action="profile" accept=".jpg, .png, .gif, .jpeg" type="file" hidden name="uploadImage" id="uploadImage">
                <label for="uploadImage" class="btn btn-info my-2" id="submit-all">Select File</label> <span class="mx-2"></span>
                <a href="#?" class="btn btn-danger my-2 removeall" id="removeall">Clear</a>
                <a href="#?" class="btn btn-success my-2 change-profile" id="upload">Upload</a>
            </div>
        </div>
    </div>
</div>

<div class="p-2 my-4">
    <div class="row m-0 flex_rotate">
        <div class="col-md-8 ">
            <div class="card py-3 px-2">
                <?php if ($formError != "") echo "<div class='alert alert-danger w-100'>" . $formError . "</div>"; ?>
                <?php if ($formSuccess != "") echo "<div class='alert alert-success w-100'>" . $formSuccess . "</div>"; ?>
                <table class="table table-stripped">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td><?php echo $user["full_name"]; ?></td>
                        </tr>
                        <?php
                        if ($user["role_name"] == 'student') { ?>
                            <tr>
                                <td>Matric No</td>
                                <td><?php echo $user["matric_no"]; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td>Level</td>
                            <td><?php echo $hasProfile ? $profile["level"] : ''; ?></td>
                        </tr>

                        <tr>
                            <td>Program</td>
                            <td><?php echo $hasProfile ? $profile["program"] : ''; ?></td>
                        </tr>

                        <tr>
                            <td>School</td>
                            <td><?php echo $hasProfile ? Schools\Schools::Get($profile["school"])["title"] : '' ?></td>
                        </tr>

                        <tr>
                            <td>Department</td>
                            <td><?php echo $hasProfile ? Schools\Departments::Get($profile["department"])["title"] : '' ?></td>
                        </tr>

                        <tr>
                            <td>Gender</td>
                            <td><?php echo $hasProfile ? $profile["gender"] : ''; ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    <a class="btn _primary_bg text-white _btn-fit" data-toggle="modal" data-target="#domainForm" type="button">Update</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card py-3 px-2 text-center align-items-center justify-content-center">

                <img src="<?php echo $hasProfilePicture ? '/assets/img/users/' . $user["profile_image"] : '/assets/img/user_avatar_2.png' ?>" class="rounded-circle" alt="Avatar" width="200px" height="200px" /> <span class="mx-1"></span>
                <div class="mt-3">
                    <a href="#?" id="showDropZonePicture" class="btn"> <span class="fa fa-edit"></span> &nbsp; Change</a>
                </div>
            </div>
        </div>

    </div>
</div>





<script>

</script>