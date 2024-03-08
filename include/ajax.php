<?php
include "../database.php";
session_start();
$db = new Database();
//Add Data
if (isset($_POST['action']) && $_POST['action'] == "add") {
    $photo = $_FILES['photo'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $uploadDir = "../uploads/";
    if (!file_exists($uploadDir) || !is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            die("Failed to create upload directory | add");
        }
    }

    $token = uniqid();
    $uploadPath = $uploadDir . $token . $photo['name'];

    if (!move_uploaded_file($photo['tmp_name'], $uploadPath)) {
        die("Failed to move uploaded file");
    }

    $result = $db->Insert('users', [
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastName'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'password' => $hashedPassword,
        'photo' => $uploadPath
    ]);

    echo $result ? "ok|Added" : "Error inserting into database";
}
//Edit Data
if (isset($_POST['action']) && $_POST['action'] == "edit") {
    $values = [
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastName'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
        'password' => $_POST['password']
    ];

    if ($_FILES['photo']['error'] == 0) {
        $uploadDir = "../uploads/";
        if (!file_exists($uploadDir) || !is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                die("Failed to create upload directory");
            }
        }
        $token = uniqid();
        $uploadPath = $uploadDir . $token . $_FILES['photo']['name'];
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath)) {
            die("Failed to move uploaded file");
        }
        $values['photo'] = $uploadPath;
    }

    $where = ['id' => $_POST['userId']];
    $result = $db->Update('users', $values, $where);

    echo $result ? "ok|Edited" : "Error updating database";
}
//Delete Data
if (isset($_POST['action']) && $_POST['action'] == "delete") {
    $userId = $_POST['userId'];
    $result = $db->Delete('users', ['id' => $userId]);
    echo $result ? "ok|Deleted" : "Error deleting user";
}
//User Login
// User Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rememberMe = isset($_POST['rememberMe']) && ($_POST['rememberMe'] === 'true' || $_POST['rememberMe'] === true);

    $user = $db->GET('users', ['email' => $email]);

    if (!empty($user) && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];

        if ($rememberMe) {
            setcookie('remember_email', $email, time() + 86400, '/');
            setcookie('remember_password', $password, time() + 86400, '/');
        } else {
            setcookie('remember_email', '', time() - 3600, '/');
            setcookie('remember_password', '', time() - 3600, '/');
        }

        echo 'success';
        exit;
    } else {
        echo 'error';
        exit;
    }
}
//Change the Password after Forgot password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password !== $cpassword) {
        echo 'Passwords do not match';
        exit;
    }

    $token = $_POST['token'];
    $resetData = $db->GET('password_reset', ['token' => $token]);

    if (empty($resetData)) {
        echo 'Your Link has expired or Invalid';
        exit;
    }

    $userId = $resetData['user_id'];
    $userEmail = $resetData['email'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $updatePassword = $db->Update('users', ['password' => $hashedPassword], ['id' => $userId]);

    if ($updatePassword) {
        $db->Delete('password_reset', ['email' => $userEmail]);
        echo 'Password changed successfully! Go to the Login Page';
        exit;
    } else {
        echo 'Failed to change password';
    }
}
// Forgot password Mail Send
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if email exists in the 'users' table
    $user = $db->GET('users', ['email' => $email]);

    if (!empty($user) && isset($user['email'])) {
        $userId = $user['id'];
        $userEmail = $user['email'];

        $token = bin2hex(random_bytes(50));
        $existingToken = $db->GET('password_reset', ['email' => $userEmail]);

        if (empty($existingToken)) {
            $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            $db->INSERT('password_reset', ['user_id' => $userId, 'email' => $userEmail, 'token' => $token, 'expires_at' => $expiresAt]);
        } else {
            $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            $db->UPDATE('password_reset', ['token' => $token, 'expires_at' => $expiresAt], ['email' => $userEmail]);
        }         

        require '../Mail/phpmailer/PHPMailerAutoload.php';

        $mail = new PHPMailer;
        
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';

        $mail->Username = 'jkalariya487@rku.ac.in'; // Your Gmail username
        $mail->Password = 'Rku@123456'; // Your Gmail password

        $mail->setFrom('jkalariya487@rku.ac.in', 'Password Reset');
        $mail->addAddress($userEmail); // Add recipient email

        $mail->isHTML(true);
        $mail->Subject = "Recover your password";
        $mail->Body = "<b>Dear User,</b>
        <h3>We received a request to reset your password.</h3>
        <p>Kindly click the below link to reset your password</p>
        http://localhost/telephone_list/reset_password.php?token=$token
        <p style='color:red'><strong>WARNING:</strong> This link is valid for only 10 Minutes!</p>
        <br><br>
        <p>With regards,</p>
        <b>Jigar Kalariya</b>";

        if (!$mail->send()) {
            echo 'error Email sending failed';
        } else {
            echo 'success'; //Email sent successfully
        }
    } else {
        echo 'error Email not found in the database or email field is not set';
    }
}

?>