<?php
session_start();
require('database.php');
if(!isset($_POST['submit'])) {
    header('location:edit.php');
} else {
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $id = $_POST['id'];
    $note = test_input($_POST['note']);
    if($note != '') {
        $update_note = "UPDATE `notes` SET `notes`='$note' WHERE id=$id";
        $result = mysqli_query($connection, $update_note);
        $_SESSION['update'] = "Note Update Success";
        header('location:index.php');
    } else {
        $_SESSION['required'] = "This felid are required!";
        header('location:index.php');
    }
}
?>