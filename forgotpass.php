<!doctype html>
<html lang="en">

<head>
    <?php
    include 'include/link.php';
    ?>
    <title>Forgot Password</title>
</head>

<body>
    <section class="user-list-forgot-pass">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-lg mb-5" style="border-radius: 1rem;">
                        <div class="card-body p-5">
                            <h3 class="mb-3">Forgot Password</h3>
                            <hr class="my-4">
                            <form method="post" action="forgotpass.php" id="userform">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="font-weight-bold">Enter Registered Email Address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email">
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-12">
                                    <a href="index.php">
                                        <p class="text-sm-left font-weight-bold">Back to Login</p>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="https://mail.google.com/">
                                        <p class="text-sm-left font-weight-bold">Go to the mail <i class="fa-regular fa-envelope"></i></p>
                                    </a>
                                </div>
                            </div>
                            <button class="btn btn-success btn-lg btn-block font-weight-bold" id="sendemail">Send Password Reset Link</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $("#sendemail").click(function() {
                var formData = new FormData($("#userform")[0]);

                $.ajax({
                    url: 'include/ajax.php',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $("#loading").show();
                    },
                    success: function(res) {
                        if (res === 'success') {
                            alert('Password reset link sent successfully');
                        } else if (res === 'error') {
                            alert('Email not found in the database');
                        } else {
                            alert('Password reset link sent successfully, Please check your email');
                        }
                    },
                    complete: function() {
                        // Hide loading animation
                        $("#loading").hide();
                    }
                })
            });
        });
    </script>
    <?php
    include 'include/footer.php';
    ?>