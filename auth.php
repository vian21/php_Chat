<?php
//Authentication handler
session_start();
include 'modules/config.php';
if (isset($_POST)) {
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    $query = "SELECT*FROM users where email='$email' LIMIT 1";
    $result = mysqli_fetch_array($connect->query($query));
    $hashedPassword = $result['password'];
    $numRows = mysqli_num_rows($result);
    if (password_verify($password, $hashedPassword)) {
        $_SESSION['id'] = $result['id'];
        header("location:index.php");
    }
    if ($numRows == 0) {
        header("location:login.php");
    } else {
        foreach ($result as $row) {
            $_SESSION['id'] = $row['id'];
            header("location:index.php");
        }
    }
} else {
    header("location:login.php");
}
