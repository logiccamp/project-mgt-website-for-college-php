<?php

use Auth\Auth;

$formError = "";
$pagetype = "auth";
$title = "REGISTER - ";
require("shared/_header.php");
require("shared/functions.php");
if (isset($_POST['register'])) :
    $registerUser = Auth::Register($_POST, "supervisor");
    if ($registerUser) {
        if ($registerUser["status"] === true) {
            session_start();
            $_SESSION["user_id"] = $_POST["matric_no"];
            header("Location: /portal/dashboard");
        } else {
            $formError = $registerUser["message"];
        }
    } else {
        $formError = "";
    }
endif;



?>

<main>
    <div class="page container auth">
        <div class="_min_space"></div>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="container flex-column justify-content-center align-items-center">
                    <form action="/register-supervisor" method="POST" class="form mx-auto text-center" style="width:95%; max-width: 400px">
                        <div class="w-100">
                            <h2 class="text-dark fs-1 fw-bold text-uppercase">SuperVISE</h2>
                            <h3 class="text-dark my-2">Create New Account</h3>
                            <hr>
                        </div>
                        <?php if ($formError != "") echo "<div class='alert alert-danger w-100'>" . $formError . "</div>"; ?>

                        <div class="form-group my-3">
                            <label class="form-label">Fullname</label>
                            <input type="text" class="form-control w-100" name="full_name">
                        </div>
                        <div class="form-group w-100">
                            <label class="form-label">Email Address</label>
                            <input type="text" class="form-control w-100" name="matric_no">
                        </div>

                        <div class="form-group my-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control w-100" name="password">
                        </div>

                        <div class="form-group my-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control w-100" name="password_confirmation">
                        </div>
                        <div class="buttons my-4">
                            <button name="register" type="submit" class="btn btn-success _primary_bg">
                                <i class="fa fa-briefcase"></i> &nbsp;
                                Create
                            </button>
                            <a href="/login" class="btn btn-link">
                                <span class="badge bg-secondary">
                                    <i class="fa fa-lock"></i>
                                    Login here
                                </span>
                            </a>
                        </div>

                    </form>

                    <div class="mt-5">
                        <p>Developed by: ND 3 Computer Science 2021/2022</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
require("shared/_footer.php");
?>