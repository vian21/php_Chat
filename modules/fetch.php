<?php
/*
	*This files generates json for fetch unread and read messages
	* 1 = unread
	* 2 = read
*/
session_start();
include 'config.php';
include 'functions.php';
//Prevent sql injection by removing any sql command in get parameter
$receiver = mysqli_real_escape_string($connect, $_GET['to']);
$sender = $_SESSION['id'];
//Queries for fetching
$queryRead = "SELECT*FROM msg WHERE sender=$sender and  receiver=$receiver and status=2 or sender=$receiver and receiver=$sender and status=2";
$queryUnread = "SELECT*FROM msg WHERE sender=$sender and  receiver=$receiver and status=1 or sender=$receiver and receiver=$sender and status=1";
//If user request is read message and their reciver is numeric(This is to prevent any sql txt command)
if (isset($_GET['read']) and is_numeric($receiver)) {
	$goQueryRead = $connect->query($queryRead);
	$data = array();
	foreach ($goQueryRead as $row) {
		$sub_data = array();
		//id,sender,receiver,msg,time,status
		$sub_data[] = $row['id'];
		//variable to contain id
		$idContainer = $row['id'];
		$sub_data[] = $row['sender'];
		$sub_data[] = $row['receiver'];
		$sub_data[] = $row['msg'];
		$sub_data[] = $row['time'];
		$sub_data[] = $row['status'];
		$data[] = $sub_data;
	}
	echoJson($data);
}
//If user request is unread messages and their reciver is numeric(This is to prevent any sql txt command)
elseif (isset($_GET['unread']) and is_numeric($receiver)) {
	$goQueryUnread = $connect->query($queryUnread);
	//variable to contain array of messages
	$data = array();
	foreach ($goQueryUnread as $row) {
		//Array of message-Each message has its own array
		$sub_data = array();
		//id,sender,receiver,msg,time,status
		$sub_data[] = $row['id'];
		//variable to contain id
		$idContainer = $row['id'];
		$sub_data[] = $row['sender'];
		$sub_data[] = $row['receiver'];
		$sub_data[] = $row['msg'];
		$sub_data[] = $row['time'];
		if ($sender != $row['sender']) { //msgs for u
			update($idContainer); //confirm you have read the msg
			$sub_data[] = $row['status'];
		} else {
			$sub_data[] = $row['status']; //msg written by you which are not yet read
		}
		$data[] = $sub_data;
	}
	echoJson($data);
}
