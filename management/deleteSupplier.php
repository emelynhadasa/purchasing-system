<?php
session_start();

require '../functions.php';

if (!isset($_SESSION['data'])) {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];

if (!isset($id)) {
    header("Location: supplier.php");
    exit();
}

$supplier = mysqli_query($conn, "SELECT * FROM supplier WHERE id='$id'");
if (mysqli_num_rows($supplier) === 0) {
    header("Location: supplier.php");
    exit();
}

mysqli_query($conn, "DELETE FROM supplier WHERE id='$id'");
echo "<script>alert('Success! Some supplier has been deleted.');window.location.href='supplier.php'</script>";
