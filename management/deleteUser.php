<?php
session_start();

require '../functions.php';

if (!isset($_SESSION['data'])) {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

if (!isset($id)) {
    header("Location: userlist.php");
    exit();
}

$user = mysqli_query($conn, "SELECT * FROM user WHERE id='$id'");
if (mysqli_num_rows($user) === 0) {
    header("Location: userlist.php");
    exit();
}

mysqli_query($conn, "DELETE FROM user WHERE id='$id'");
echo "<script>alert('Success! Some user has been deleted.');window.location.href='userlist.php'</script>";
