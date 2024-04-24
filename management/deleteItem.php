<?php
session_start();

require '../functions.php';

if (!isset($_SESSION['data'])) {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

if (!isset($id)) {
    header("Location: item.php");
    exit();
}

$item = mysqli_query($conn, "SELECT * FROM item WHERE id='$id'");
if (mysqli_num_rows($item) === 0) {
    header("Location: item.php");
    exit();
}

mysqli_query($conn, "DELETE FROM item WHERE id='$id'");
echo "<script>alert('Success! Some item has been deleted.');window.location.href='item.php'</script>";
