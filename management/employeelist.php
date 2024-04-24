<?php
session_start();

require '../functions.php';

if (!isset($_SESSION['data'])) {
    header("Location: ../auth/login.php");
    exit();
}

$sql = "SELECT created_by, COUNT(*) AS total_po_created
        FROM po
        WHERE status = 'Approved' AND MONTH(date_created) = MONTH(CURRENT_DATE()) AND YEAR(date_created) = YEAR(CURRENT_DATE())
        GROUP BY created_by
        ORDER BY total_po_created DESC
        LIMIT 5";

$result = mysqli_query($conn, $sql);
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
            <h1>List of High Achiever Staff This Month</h1>
            
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table>
                    <tr>
                        <th>Staff</th>
                        <th>Total POs Created and Approved</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['created_by'] ?></td>
                            <td><?= $row['total_po_created'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>No high achiever staff found for this month.</p>
            <?php endif; ?>
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