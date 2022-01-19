<?php
session_start();
require('database.php');

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_qry = "DELETE FROM `notes` WHERE id=$id";
    $result = mysqli_query($connection, $delete_qry);
    $_SESSION['delete_success'] = "Note Delete Success";
    header('location:index.php');
} else {
    header('location:index.php');
}

?>