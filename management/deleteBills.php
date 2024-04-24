<?php
session_start();

require '../functions.php';

if (!isset($_SESSION['data'])) {
    header("Location: ../auth/login.php");
    exit();
}

$po_number = $_GET['po_number'];

if (!isset($po_number)) {
    header("Location: billsPayment.php");
    exit();
}

$po = mysqli_query($conn, "SELECT * FROM po WHERE po_number='$po_number'");
if (mysqli_num_rows($po) === 0) {
    header("Location: billsPayment.php");
    exit();
}

mysqli_query($conn, "DELETE FROM po WHERE po_number='$po_number'");
mysqli_query($conn, "DELETE FROM item_po WHERE po_number='$po_number'");
echo "<script>alert('Success! Some bills has been deleted.');window.location.href='billsPayment.php'</script>";
