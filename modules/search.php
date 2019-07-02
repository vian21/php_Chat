<?php
//This file generates json for search
session_start();
include 'config.php';
include 'functions.php';
if (isset($_GET['search']) and $_GET['search'] != "") {
    $search = mysqli_real_escape_string($connect, $_GET['search']);
    $searchQuery = $connect->query("SELECT*FROM users WHERE name like '%$search%'");
    $data = array();
    /*
     * 0 : id
     * 1 : name
     * 2 : img
     * 3 : number of messages
     */
    foreach ($searchQuery as $column) {
        $sub_data = array();
        if ($column['id'] != $_SESSION['id']) {
            $sub_data[] = $column['id'];
            $sub_data[] = fetchName($column['id']);
            $sub_data[] = fetchImage($column['id']);
            $sub_data[] = numberOfUnreadMessages($_SESSION['id'], $column['id']);
            $data[] = $sub_data;
        }
    }
    if (!empty($data)) {
        echoJson($data);
    } else {
        echo "ko"; //No results
    }
} else {
    echo "null"; //If search field was empty
}
