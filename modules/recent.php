<?php
//Check recent read and unread chats
include 'functions.php';
session_start();
if (isset($_GET['read'])) {
    checkRecentRead($_SESSION['id']);
}
if (isset($_GET['unread'])) {
    checkRecentUnread($_SESSION['id']);
}
