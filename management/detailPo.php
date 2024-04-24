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

$purchaseOrder = dataPurchaseOrderByPo_number($po_number);
$purchaseOrder = mysqli_fetch_assoc($purchaseOrder);
$item_po = dataItemPoByPo_number($po_number);

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
            <h1>Purchase Order <br><?= $purchaseOrder['date_created'] ?></h1>
            <a href="purchaseOrder.php" class="buttonLink">Purchase Order List</a>
            <br>

            <label>Supplier</label>
            <?= $purchaseOrder['supplier'] ?>
            <table id="itemTable">
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($item_po as $ipo) { ?>
                        <tr>
                            <td>
                                <?= $ipo['qty'] ?>
                            </td>
                            <td>
                                <?= $ipo['unit'] ?>
                            </td>
                            <td>
                                <?= $ipo['item'] ?>
                            </td>
                            <td>
                                <p><?= $ipo['description'] ?></p>
                            </td>
                            <td>
                                Rp. <?= $ipo['price'] ?>
                            </td>
                            <td>
                                Rp. <?= $ipo['total'] ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tr>
                    <td colspan="5" style="text-align: right;">Sub Total</td>
                    <td>
                        Rp. <?= $purchaseOrder['subTotal'] ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right;">
                        Discount
                    </td>
                    <td><?= $purchaseOrder['percentDiscount'] ?>%</td>
                    <td>
                        Rp. <?= $purchaseOrder['priceDiscount'] ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right;">
                        Tax Inclusive
                    </td>
                    <td><?= $purchaseOrder['percentTaxInclusive'] ?>%</td>
                    <td>
                        Rp. <?= $purchaseOrder['priceTaxInclusive'] ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align: right;">Total</td>
                    <td>
                        Rp. <?= $purchaseOrder['totalAll'] ?>
                    </td>
                </tr>
            </table>
            <br>
            <label for="note">Notes</label>
            <p>
                <?= $purchaseOrder['note'] ?>
            </p>
            <br>
            <label for="status">Status</label>
            <p>
                <?= $purchaseOrder['status'] ?>
            </p>
            <br><br>
            <button id="btnGeneratePDF" class="submitBtn">Generate PDF</button>
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

    <!-- Add this inside the head tag -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('btnGeneratePDF').addEventListener('click', function() {
                var doc = new jsPDF({
                    orientation: 'landscape'
                });
                var card = document.querySelector('.card');
                var cardContent = card.innerHTML;
                cardContent = cardContent.replace('<button id="btnGeneratePDF" class="submitBtn">Generate PDF</button>', '');

                // Set margin
                var margin = 15;

                // Set font
                doc.setFont('helvetica');
                doc.setFontSize(12);

                // Set text color
                doc.setTextColor(0, 0, 0);

                // Add card content to PDF with margin
                doc.fromHTML(cardContent, margin, margin);

                // Save PDF
                doc.save('purchase_order.pdf');
            });
        });
    </script>


</body>

</html>