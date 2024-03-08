<!doctype html>
<html lang="en">

<head>
    <?php
    include 'include/link.php';
    // print_r($_COOKIE);
    ?>
    <title>User Login</title>
</head>

<body>
    <section class="user-list-login">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-lg mb-5" style="border-radius: 1rem;">
                        <div class="card-body p-5">
                            <h3 class="mb-3">Login</h3>
                            <hr class="my-4">
                            <form method="post">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="font-weight-bold">Email address</label>
                                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="<?php echo isset($_COOKIE['remember_email']) ? $_COOKIE['remember_email'] : ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="font-weight-bold">Password</label>
                                    <div class="input-group mb-2">
                                        <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password" value="<?php echo isset($_COOKIE['remember_password']) ? $_COOKIE['remember_password'] : ''; ?>">
                                        <div class="input-group-append" style="display: flex; justify-content: center; align-items: center;">
                                            <span class="input-group-text text-center">
                                                <button type="button" id="peekButton" style="background: none; border: 0;">
                                                    <i id="peekIcon" class="fas fa-eye"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe" <?php echo isset($_COOKIE['remember_email']) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="rememberMe">Remember Me</label>
                                </div>
                                <a href="forgotpass.php">
                                    <p class="text-sm-left font-weight-bold">Forgot Password?</p>
                                </a>
                                <button type="button" class="btn btn-primary btn-lg btn-block" id="loginBtn">Login</button>
                            </form>
                        </div>


                        <!-- </a>
                        <a href="#">
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" name="rememberme" id="customCheck1">
                                <label class="custom-control-label font-weight-bold" for="customCheck1">Remember Me</label>
                            </div>
                        </a> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $("#loginBtn").click(function() {
                var email = $("#exampleInputEmail1").val();
                var password = $("#exampleInputPassword1").val();
                var rememberMe = $("#rememberMe").is(":checked");

                $.ajax({
                    url: 'include/ajax.php',
                    type: 'post',
                    data: {
                        email: email,
                        password: password,
                        rememberMe: rememberMe
                    },
                    beforeSend: function() {},
                    success: function(res) {
                        if (res === 'success') {
                            alert('Login successful');
                            window.location.href = 'user_list.php';
                        } else {
                            alert('Login failed');
                        }
                    },
                    error: function() {
                        alert('Error occurred during login');
                    }
                });
            });
        });
        $(document).ready(function() {
            const $passwordInput = $("#exampleInputPassword1");
            const $peekButton = $("#peekButton");
            const $peekIcon = $("#peekIcon");

            $peekButton.on("click", function() {
                if ($passwordInput.attr("type") === "password") {
                    $passwordInput.attr("type", "text");
                    $peekIcon.removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    $passwordInput.attr("type", "password");
                    $peekIcon.removeClass("fa-eye-slash").addClass("fa-eye");
                }
            });
        });
    </script>
    <?php
    include 'include/footer.php';
    ?>