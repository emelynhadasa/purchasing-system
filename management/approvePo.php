<?php
session_start();

require '../functions.php';

if (!isset($_SESSION['data'])) {
    header("Location: ../auth/login.php");
    exit();
}

$po_number = $_GET['po_number'];

if (!isset($po_number)) {
    header("Location: purchaseOrder.php");
    exit();
}

$po = mysqli_query($conn, "SELECT * FROM po WHERE po_number='$po_number'");
if (mysqli_num_rows($po) === 0) {
    header("Location: purchaseOrder.php");
    exit();
}

mysqli_query($conn, "UPDATE po SET status='Approved' WHERE po_number='$po_number'");
echo "<script>alert('Success! Some purchase order has been approved.');window.location.href='purchaseOrder.php'</script>";
