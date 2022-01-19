<?php 
session_start();
require("database.php");

if(isset($_POST['submit'])) {
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $note = test_input($_POST['note']);
    if($note != '') {
        $insert_qry = "INSERT INTO `notes`(`notes`) VALUES ('$note')";
        $result = mysqli_query($connection, $insert_qry);
        $_SESSION['success'] = "Note Submit Success";
        header('location:index.php');
    } else {
        $_SESSION['required'] = "This felid are required!";
        header('location:index.php');
    }
} else {
    header('location:index.php');
}
?>