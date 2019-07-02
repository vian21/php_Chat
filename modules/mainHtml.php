<?php
//This the main page that loads when the user logins in
//store logged in user's id
$user_id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Chat</title>
	<?php include 'config.php' //Load app configurations ?>
	<meta name='viewport' content='width=device-width, initial-scale=1.0' />
	<?php include 'functions.php'//Load functions ?>
	<link rel="stylesheet" type="text/css" href="src/css/main.css">
	<script src="src/js/jquery.js"></script>
	<script src="src/js/main.js"></script>
</head>
<body>
	<!-- Image popup -->
	<div id="popup" style="display:none;">
		<span id="closePopup">&times;</span>
		<img src="" id="popupImg">
	</div>
	<!-- The fixed navbar -->
	<div id="menu">
		<div id="navbarImage">
			<img src="src/img/uploaded/<?php echo fetchImage($user_id); ?>" alt="" onclick="pop()">
		</div>
		<div id="navbarSearch">
			<input type="text" name="search" id="inputBox">
		</div>
		<div class='drop-settings'>
			<span class="settings"></span>
			<div class="dropdown-content">
				<a href="settings.php">Settings</a>
				<a href="about.html">About</a>
				<a href="modules/logout.php">Logout</a>
			</div>
		</div>
	</div>
	<!-- The main div -->
	<div id="main">
	</div>
</body>

</html>