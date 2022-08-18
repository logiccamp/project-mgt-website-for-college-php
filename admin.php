<?php
$pagetype = "auth";
$title = "LOGIN - ";
require(__DIR__ . "/shared/functions.php");

require("shared/_header.php");
$formError = "";

if (isset($_POST["login_btn"])) {
    $user = [
        "matric_no" => $_POST["matric_no"],
        "password" => $_POST["password"],
    ];

    $isLogin = Auth\Auth::Login($user);

    if ($isLogin) {
        if ($isLogin["status"] == true) {
            session_start();
            $_SESSION["user_id"] = $_POST["matric_no"];
            header("Location: /portal/dashboard");
        } else {
            $formError = $isLogin["message"];
        }
    } else {
        $formError = "";
    }
}
?>

<main>
    <div class="page container auth">
        <div class="row">
            <div class="col-md-6 mx-auto ">
                <div class="container banner_wrapper text-center flex-column justify-content-center align-items-start">
                    <form action="/admin" class="form w-100 mx-auto" method="POST" style="max-width: 400px;">
                        <div class="w-100">
                            <h2 class="text-dark my-3 fs-1 fw-bold text-uppercase">SuperVISE</h2>
                            <h3 class="text-dark">Supervisors' Portal</h3>
                            <hr>
                        </div>
                        <?php if ($formError != "") echo "<div class='alert alert-danger w-100'>" . $formError . "</div>"; ?>

                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="text" class="form-control w-100" name="matric_no">
                        </div>

                        <div class="form-group my-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control w-100" name="password">
                        </div>
                        <div class="buttons my-4">
                            <button name="login_btn" class="btn btn-success px-3 _primary_bg">
                                <i class="fa fa-lock"></i> <span class="mx-1"></span>
                                Login
                            </button>
                            <a href="/register-supervisor" class="btn btn-link">
                                <span class="badge bg-secondary">
                                    <i class="fa fa-check"></i>
                                    Create an Account
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