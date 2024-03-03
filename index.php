<!doctype html>
<html lang="en">

<head>
    <?php
    include 'include/link.php';
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
                                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="font-weight-bold">Password</label>
                                    <input type="password" class="form-control" name="password" id="exampleInputPassword1" name="password" placeholder="Password">
                                </div>
                            </form>
                            <button class="btn btn-primary btn-lg btn-block" id="loginBtn">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $("#saveUserBtn").click(function() {
                var formData = new FormData($("#userform")[0]);

                $.ajax({
                    url: 'include/ajax.php',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {

                    },
                    success: function(res) {
                        console.log(res);
                    }
                })
            });


            $("#loginBtn").click(function() {
                var email = $("#exampleInputEmail1").val();
                var password = $("#exampleInputPassword1").val();
                
                $.ajax({
                    url: 'include/ajax.php',
                    type: 'post',
                    data: {
                        email: email,
                        password: password
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
    </script>
    <?php
    include 'include/footer.php';
    ?>