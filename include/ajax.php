<?php
include "../database.php";
session_start();
$db = new Database();
if (isset($_POST['action']) && $_POST['action'] == "add") {
    $photo = $_FILES['photo'];

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
        'password' => $_POST['password'],
        'photo' => $uploadPath
    ]);

    echo $result ? "ok|Added" : "Error inserting into database";
}

if (isset($_POST['action']) && $_POST['action'] == "edit") {
    $values = [
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastName'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone']
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

if (isset($_POST['action']) && $_POST['action'] == "delete") {
    $userId = $_POST['userId'];
    $result = $db->Delete('users', ['id' => $userId]);
    echo $result ? "ok|Deleted" : "Error deleting user";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $db->GET('users', ['email' => $email, 'password' => $password]);

    if (!empty($user)) {
        $_SESSION['user_id'] = $user[0]->id; 
        echo 'success';
        exit;
    } else {
        echo 'error';
        exit; 
    }
}


?>