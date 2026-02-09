<?php
$title = "Log In";
session_start();
include('../inc/db_connect.php');
include '../admin/includes/head-link.php';

if (!empty($_POST) && isset($_POST["submit"])) {
    
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $con->prepare("SELECT * FROM users WHERE email = ? AND user_type = 'admin'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["admin_logged_in"] = true;
            $_SESSION["username"] = $user["first_name"] . " " . $user["last_name"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["success_message"] = "Logged in successfully.";
?>
            <script>
                successToaster("Logged in successfully!");
                setTimeout(function() {
                    window.location.href = "dashboard.php";
                }, 1000);
            </script>
        <?php
        } else {
        ?>
            <script>
                errorToaster("Incorrect password.");
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            errorToaster("Email not found.");
        </script>
<?php
    }
}
?>

<main>
    <section class="vh-xxl-100">
        <div class="container h-100 d-flex px-0 px-sm-4">
            <div class="row justify-content-center align-items-center m-auto">
                <div class="col-12">
                    <div class="bg-mode shadow rounded-3 overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-6 d-flex align-items-center order-2 order-lg-1">
                                <div class="p-2 p-lg-3">
                                    <img src="../assets/images/heros/login-img.jpg" alt="Woman exploring" class="rounded-3">
                                </div>
                                <div class="vr opacity-1 d-none d-lg-block"></div>
                            </div>

                            <div class="col-lg-6 order-1">
                                <div class="p-4 p-sm-7">
                                    <img src="../assets/images/logo/TravSavers-Logo.svg" width="200px;" alt="TravSavers Logo" class="mb-3">
                                    <h1 class="mb-2 h3 text-secondary">Admin Dashboard</h1>


                                    <form class="mt-4 text-start" method="post" id="login-form">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" id="email" class="form-control">
                                            <div class="invalid-feedback" id="email-error"></div>
                                        </div>
                                        <div class="mb-3 position-relative">
                                            <label class="form-label">Password</label>
                                            <input class="form-control fakepassword" type="password" name="password" id="psw-input">
                                            <div class="invalid-feedback" id="password-error"></div>
                                            <span class="position-absolute top-50 end-0 translate-middle-y p-0 mt-3">
                                                <i class="fakepasswordicon fas fa-eye-slash cursor-pointer p-2"></i>
                                            </span>
                                        </div>
                                        <div class="mb-3 d-sm-flex justify-content-between">
                                            <div>
                                                <input type="checkbox" class="form-check-input" id="rememberCheck">
                                                <label class="form-check-label" for="rememberCheck">Remember me?</label>
                                            </div>
                                            <a href="forgot-password.php">Forgot password?</a>
                                        </div>
                                        <div>
                                            <button role="button" type="submit" name="submit" class="btn btn-primary w-100 mb-0">Login</button>
                                        </div>

                                        <div class="text-primary-hover text-body mt-3 text-center"> Copyright ©2025 TravSavers. All Rights Reserved.</div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<div class="back-top"></div>

<?php include('includes/footer.php'); ?>

<script>
    document.getElementById('login-form')?.addEventListener('submit', function(e) {
        const isEmailValid = validateInput(
            document.getElementById('email'),
            document.getElementById('email-error'),
            'Please enter a email'
        );

        const isPasswordValid = validateInput(
            document.getElementById('psw-input'),
            document.getElementById('password-error'),
            'Please enter a password'
        );
        if (!isEmailValid || !isPasswordValid) {
            e.preventDefault();
        }
    });
</script>
</body>

</html>