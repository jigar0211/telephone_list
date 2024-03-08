<!doctype html>
<html lang="en">

<head>
    <?php
    include 'include/link.php';
    ?>
    <title>Recover Password</title>
</head>

<body>
    <section class="user-list-login">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-lg mb-5" style="border-radius: 1rem;">
                        <div class="card-body p-5">
                            <h3 class="mb-3">Reset Password</h3>
                            <hr class="my-4">
                            <form method="post" id="recoverpass">
                                <div class="form-group">
                                    <label for="password" class="font-weight-bold">Enter New Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                                </div>
                                <div class="form-group">
                                    <label for="cpassword" class="font-weight-bold">Confirm Password</label>
                                    <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Repeat the Password" required>
                                </div>
                                <a href="index.php">
                                    <p class="text-sm-left font-weight-bold">Back to Login</p>
                                </a>
                                <button type="button" class="btn btn-success btn-lg btn-block" id="changePassword">Change Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $("#changePassword").click(function() {
                var password = $("#password").val();
                var cpassword = $("#cpassword").val();

                if (password !== cpassword) {
                    alert('Passwords do not match');
                    return;
                }

                var formData = new FormData($("#recoverpass")[0]);
                formData.append('token', '<?php echo $_GET["token"]; ?>');

                $.ajax({
                    url: 'include/ajax.php',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {},
                    success: function(res) {
                        alert(res);
                        if (res === 'Password changed successfully! Go to the Login Page') {
                            window.location.replace("index.php");
                        }
                    },
                    complete: function() {}
                });
            });
        });
    </script>
    <?php
    include 'include/footer.php';
    ?>