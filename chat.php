<?php
session_start();
if (!isset($_SESSION['id'])) {
	header("location:index.php");
}
//if there are no get parameter and the sender is not self --> Redirect to main page
if (!isset($_GET['to']) or $_GET['to'] == $_SESSION['id'] or !isset($_SESSION['id'])) {
	header("location:index.php");
}
//Used is_numeric to avoid SQL insjections in url
if (isset($_SESSION['id']) and isset($_GET['to']) and !empty($_GET['to']) and is_numeric($_GET['to'])) {
	include 'modules/config.php';
	$receiver = mysqli_real_escape_string($connect, $_GET['to']);
	$self = $_SESSION['id'];
	?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Chat</title>
		<?php include 'modules/config.php' ?>
		<?php include 'modules/staticFiles.php' ?>
		<link rel="stylesheet" type="text/css" href="src/css/chat.css">
		<?php include 'modules/functions.php'; ?>
	</head>

	<body>
		<div id="popup" style="display:none;">
			<span id="closePopup">&times;</span>
			<img src="" id="popupImg">
		</div>
		<div id="menu">
			<img src='src/img/uploaded/<?php echo fetchImage($receiver) ?>'>
			<span><?php echo fetchName($receiver); ?></span>
		</div>
		<br>
		<br>
		<br>
		<center>
			<!-- Message container -->
			<div id="msg-div">
			</div>
			<form onsubmit="return send();" id="msg-form">
				<input type="text" name="msg" id="msg-input" autocomplete="off" required>
				<button type="submit" name="submit">Send</button>
			</form>
			<script type="text/javascript">
				//variable to contain self id
				var self = '<?php echo $_SESSION["id"] ?>';
				//variable to contain id of receiver
				var receiver = '<?php echo $_GET["to"] ?>';
			</script>
		</center>
	</body>
	<script type="text/javascript" src="src/js/chat.js"></script>

	</html>
<?php
} else {
	header("location:index.php");
}
?>