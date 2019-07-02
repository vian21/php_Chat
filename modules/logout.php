<?php
//Delete current session to log out and redirect to index.php -->login.php
session_start();
session_unset();
session_destroy();
header("location:../index.php");
