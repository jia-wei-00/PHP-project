<?php
include_once 'header.php';
?>
<style>
    .login-form {
        width: 340px;
        margin: 50px auto;
    }

    .login-form form {
        margin-bottom: 15px;
        background: #f7f7f7;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }

    .login-form h2 {
        margin: 0 0 15px;
    }

    .form-control,
    .btn {
        min-height: 38px;
        border-radius: 2px;
    }

    .btn {
        font-size: 15px;
        font-weight: bold;
    }
</style>

<section class="signup-form mt-5">
    <div class="row justify-content-center">
        <div class="login-form">
            <form action="includes/login.inc.php" method="POST">
                <div class="row justify-content-center">
                    <img style="width: 200px;" src="img/icon.png" />
                    <h2 class="text-center">Log in</h2>
                    <div class="form-group mt-4">
                        <input type="text" class="form-control" name="name" placeholder="Username/Email...">
                    </div>
                    <div class="form-group mt-3">
                        <input type="password" class="form-control" name="pass" placeholder="Password...">
                    </div>
                    <div class="form-group mt-4 text-center">
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Log In</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php
if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
        echo "<p style='text-align: center;'>Fill in all field!</p>";
    } else if ($_GET["error"] == "wronglogininfo") {
        echo "<p style='text-align: center;'>Incorrect login information!</p>";
    } else if ($_GET["error"] == "stmtfailed") {
        echo "<p style='text-align: center;'>Something went wrong please try again!</p>";
    }
}
?>

<?php
include_once 'footer.php';
?>