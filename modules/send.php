<?php
//This file is for sending messages and deleting/creating records in the recent table
include 'config.php';
if (isset($_POST['sender']) and isset($_POST['receiver']) and isset($_POST['msg'])) {
	include 'config.php';
	session_start();
	if (isset($_POST['msg'])) {
		$self = $_SESSION['id'];
		$sender = $self;
		$receiver = $_POST['receiver'];
		$msg = htmlentities($_POST['msg']);
		$time = date('G:i:s');
		$date = date('Y-m-d');
		/*
		 * 1 = unread
		 * 2 = read
		 */
		$status = 1;
		$query = $connect->query("INSERT INTO msg(sender,receiver,msg,time,date,status) values($sender,$receiver,'$msg','$time','$date',$status)");
		addToRecent($self, $receiver);
		if (!$query) {
			echo $connect->error;
		}
	}
} else {
	header("location:chat.php");
}
/*
 * This deletes and create 2 records 
 * One for the sender's recent checks
 * Second for the receiver's recent checks
 */
function addToRecent($self, $receiver)
{
	include 'config.php';
	$connect->query("DELETE FROM recent where self=$self and receiver=$receiver");
	$connect->query("INSERT INTO recent(self,receiver) VALUES($self,$receiver)");
	$connect->query("DELETE FROM recent where self=$receiver and receiver=$self");
	$connect->query("INSERT INTO recent(self,receiver) VALUES($receiver,$self)");
}
