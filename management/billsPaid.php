<?php
session_start();

require '../functions.php';

if (!isset($_SESSION['data'])) {
    header("Location: ../auth/login.php");
    exit();
}

$purchaseOrder = dataPurchaseOrder();
$bills = dataBills();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Purchase Order Management System</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- NAVBAR -->
    <?php include 'templates/navbar.php' ?>

    <!-- SIDEBAR -->
    <?php include 'templates/sidebar.php' ?>

    <!-- CONTETNT -->
    <div class="content text-center">
        <div class="card">
            <h1>Bills</h1>
            <a href="billsPayment.php" class="buttonLink">Bill List</a>
            <table>
                <tr>
                    <th>Id</th>
                    <th>PO Number</th>
                    <th>Employee</th>
                    <th>Payment Date</th>
                    <th>Payment Method</th>
                    <th>Recipient</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
                <?php
                $num = 1;
                    foreach ($bills as $bills) {
                        if ($bills['status'] == "Paid") { ?>
                        <tr>
                            <td><?= $num++ ?></td>
                            <td><?= $bills['po_number'] ?></td>
                            <td><?= $bills['employee'] ?></td>
                            <td><?= $bills['payment_date'] ?></td>
                            <td><?= $bills['payment_method'] ?></td>
                            <td><?= $bills['recipient_bank'] ?></td>
                            <td>Rp. <?= $bills['amount'] ?></td>
                            <td><?= $bills['status'] ?></td>
                            <td>
                                <br>
                            </td>
                        </tr>
                    <?php } }  ?>
                </table>
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