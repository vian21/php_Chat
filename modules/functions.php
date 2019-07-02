<?php
//Function to echo json - It takes an array as parameter
function echoJson($data)
{
    if ($data != "") {
        echo json_encode($data);
    }
}
//Fetch the image location of a specific user
function fetchImage($id)
{
    include 'config.php';
    $img_get = $connect->query("SELECT img FROM users WHERE id=$id");
    $img = mysqli_fetch_array($img_get);
    if (empty($img['img'])) {
        return "../user.png";
    } else {
        return $img['img'];
    }
}
//Fetch the email address of a user
function fetchEmail($id)
{
    include 'config.php';
    $email_get = $connect->query("SELECT email FROM users WHERE id=$id");
    $email = mysqli_fetch_array($email_get);
    return $email['email'];
}
//Fetch the phone number of a user
function fetchPhone($id)
{
    include 'config.php';
    $tel_get = $connect->query("SELECT tel FROM users WHERE id=$id");
    $tel = mysqli_fetch_array($tel_get);
    return $tel['tel'];
}
//Fetch name of a user
function fetchName($id)
{
    include 'config.php';
    $name_get = $connect->query("SELECT name FROM users WHERE id=$id");
    $name = mysqli_fetch_array($name_get);
    return $name['name'];
}
//Update the message status from unread to read - Takes in your id to confirm you have read a message
function update($id)
{
    include 'config.php';
    $connect->query("UPDATE  msg set status=2 WHERE id=$id");
}
//Checks the number of unread messages you have from a certain user($id)
function numberOfUnreadMessages($user_id, $id)
{
    include 'config.php';
    $msg_get = $connect->query("SELECT * FROM msg WHERE sender=$id and receiver=$user_id and status=1");
    $messageNumber = mysqli_num_rows($msg_get);
    if ($messageNumber > 0) {
        return $messageNumber;
    } else {
        return " ";
    }
}
//Checks for recent people who wrote to you
function checkRecentUnread($user_id)
{
    include 'config.php';
    $queryRecent = $connect->query("SELECT * FROM recent WHERE receiver =$user_id ORDER BY `recent`.`id` DESC");
    $data = array();
    foreach ($queryRecent as $column) {
        $sub_data = array();
        $chatId = $column['self'];
        if (numberOfUnreadMessages($user_id, $chatId) > 0) {
            $chatId = $column['self'];
            $sub_data[] = $chatId;
            $sub_data[] = fetchName($chatId);
            $sub_data[] = fetchImage($chatId);
            $sub_data[] = numberOfUnreadMessages($user_id, $chatId);
            $data[] = $sub_data;
        }
    }
    echoJson($data);
}
//Checks for people whom you have recently chatted with and you have read their messages
function checkRecentRead($user_id)
{
    include 'config.php';
    $queryRecent = $connect->query("SELECT * FROM recent WHERE self =$user_id ORDER BY `recent`.`id` DESC");
    $data = array();
    foreach ($queryRecent as $column) {
        $sub_data = array();
        $chatId = $column['receiver'];
        if (numberOfUnreadMessages($user_id, $chatId) == 0) {
            $chatId = $column['receiver'];
            $sub_data[] = $chatId;
            $sub_data[] = fetchName($chatId);
            $sub_data[] = fetchImage($chatId);
            $sub_data[] = numberOfUnreadMessages($user_id, $chatId);
            $data[] = $sub_data;
        }
    }
    echoJson($data);
}
