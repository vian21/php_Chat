<?php
//This file creates new users
if (isset($_POST['name']) and isset($_POST['email']) and isset($_POST['password'])) {
    include 'config.php';
    $name = htmlentities($_POST['name']);
    $tel = htmlentities($_POST['tel']);
    $email = htmlentities($_POST['email']);
    //Hash the password
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    //img name is empty by default in case the user entered no image
    $imgName = "";
    //Check if email is not taken
    $existingUsers = $connect->query("SELECT email FROM users WHERE email='$email'");
    //If user set an image
    if (isset($_FILES['img'])) {
        $imgName = $_FILES['img']['name'];
        $location = "../src/img/uploaded/" . $imgName;
        $imgType = pathinfo($location, PATHINFO_EXTENSION);
        $validExt = array('png', 'jpg', 'jpeg');
        /*
        * 'K' : For failed
        * 'O' : For success
        */
        if (!in_array(strtolower($imgType), $validExt)) {
            echo "k";
        } else {
            if (move_uploaded_file($_FILES['img']['tmp_name'], $location)) {
                echo "o";
            } else {
                echo "k";
            }
        }
    } else {
        echo "o";
    }
    if (mysqli_num_rows($existingUsers) < 1) {
        $createUser = $connect->query("INSERT INTO users(name,tel,email,password,img) VALUES('$name','$tel','$email','$password','$imgName')");
        /*
        * 'O' : For failed
        * 'K' : For success
        */
        if (!$createUser) {
            echo "o";
        } else {
            echo "k";
        }
    } else {
        echo "exists";  //If user already exists/email taken
    }
}
/*
 * This code will generate:
 * 'OK' : If user created successfull
 * 'KO' : If failed to create user
 */
