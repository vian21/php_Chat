<?php
if (isset($_POST['changeSettings'])) {
    include 'config.php';
    include 'functions.php';
    session_start();
    $id = $_SESSION['id'];
    //Prevent XSS by makin sure all input are not html tags
    $name = htmlentities($_POST['name']);
    $phone = htmlentities($_POST['phone']);
    //Update query template
    $changeQuery = "UPDATE users SET name='$name' , tel='$phone'";
    //If the user wants to change his profile picture also
    if (isset($_FILES['img'])) {
        $oldImgLocation = "../src/img/uploaded/" . fetchImage($id);
        $imgName = $_FILES['img']['name'];
        $location = "../src/img/uploaded/" . $imgName;
        $imgType = pathinfo($location, PATHINFO_EXTENSION);
        $validExt = array('jpg', 'png', 'jpeg');
        //Check if sent files are images
        if (!in_array(strtolower($imgType), $validExt)) {
            echo "k";
        } else {
            if (move_uploaded_file($_FILES['img']['tmp_name'], $location)) {
                //Delete the image if they don't have same name because by default it will replace the old one
                if ($location != $oldImgLocation) {
                    unlink($oldImgLocation);
                }
                echo "o";
            } else {
                echo "k";
            }
        }
        //Change image location in database
        $changeQuery .= ",img='" . $imgName . "' ";
    } else {
        echo 'o';
    }
    $changeQuery .= "where id=" . $id;
    $updateInfoQuery = $connect->query($changeQuery);
    /*
     * 'O' : For failed
     * 'K' : For success
     */
    if (!$updateInfoQuery) {
        echo "o";
    } else {
        echo "k";
    }
}
/*
 * This code will generate:
 * 'OK' : If changed successfull
 * 'KO' : If failed
 */
