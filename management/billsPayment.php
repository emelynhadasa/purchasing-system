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
            <a href="billsPaid.php" class="buttonLink">Paid Bills</a>
            <table>
                <tr>
                    <th>Id</th>
                    <th>PO Number</th>
                    <th>Supplier</th>
                    <th>Discount</th>
                    <th>Tax Inclusive</th>
                    <th>Total</th>
                    <th>Note</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
                <?php
                $num = 1;
                foreach ($purchaseOrder as $po) {
                    if ($po['status'] == "Approved") {
                        ?>
                        <tr>
                            <td><?= $num++ ?></td>
                            <td><?= $po['po_number'] ?></td>
                            <td><?= $po['supplier'] ?></td>
                            <td><?= $po['percentDiscount'] ?>%</td>
                            <td><?= $po['percentTaxInclusive'] ?>%</td>
                            <td>Rp. <?= $po['totalAll'] ?></td>
                            <td><?= $po['note'] ?></td>
                            <td><?= $po['date_created'] ?></td>
                            <td>
                                <br>
                                <a href="deleteBills.php?po_number=<?= $po['po_number'] ?>" class="deleteBtn">Delete</a>
                            
                                <?php
                    // Check if the bill has been paid
                    $paid = false;
                    foreach ($bills as $bill) {
                        if ($bill['po_number'] == $po['po_number'] && $bill['status'] == 'Paid') {   
                            $paid = true;
                            break; ?>
                            <tr>
                                <td><?= $po['status'] = "Paid" ?></td> 
                            </tr>
                            <?php
                        }
                    }
                                // If the bill has not been paid, show Payment link
                        if (!$paid) { ?>
                            <a href="detailBills.php?po_number=<?= $po['po_number'] ?>" class="buttonLink">Payment</a>
                            
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
 
                ?>                
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