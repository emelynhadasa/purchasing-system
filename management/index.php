<?php
session_start();

require '../functions.php';

if (!isset($_SESSION['data'])) {
    header("Location: ../auth/login.php");
    exit();
}

$total_suppliers = total_suppliers();
$total_items = total_items();
$total_purchase_orders = total_purchase_orders();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Purchase Order Management System</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter&display=swap">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- NAVBAR -->
    <?php include 'templates/navbar.php' ?>

    <!-- SIDEBAR -->
    <?php include 'templates/sidebar.php' ?>

    <!-- CONTETNT -->
    <div class="content text-center">
        <div class="minicard">
            <div class="minicard-header">Total Suppliers</div>
            <div class="minicard-content">
                <h1><?= $total_suppliers ?></h1>
            </div>
        </div>
        <div class="minicard">
            <div class="minicard-header">Total Items</div>
            <div class="minicard-content">
                <h1><?= $total_items ?></h1>
            </div>
        </div>
        <div class="minicard">
            <div class="minicard-header">Total Purchase Orders</div>
            <div class="minicard-content">
                <h1><?= $total_purchase_orders ?></h1>
            </div>
        </div>
    </div>

    <!-- SIDEBAR -->
    <script>
        // Get the sidebar and content elements
        const sidebar = document.querySelector('.sidebar');
        const content = document.querySelector('.content');
        const sidebarCollapse = document.getElementById('sidebarCollapse');

        // Toggle sidebar and content when button is clicked
        sidebarCollapse.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            content.classList.toggle('active');
        });
    </script>
</body>

</html>