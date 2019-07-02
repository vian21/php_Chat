<?php
session_start();
if (isset($_SESSION['id'])) {
	include 'modules/mainHtml.php';
} else {
	header("location:login.php");
}
