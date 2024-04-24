<?php
session_start();

require '../functions.php';

if (!isset($_SESSION['data'])) {
    header("Location: ../auth/login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "poms");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM exp";
$result = $conn->query($sql);

$exp = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $exp[] = $row;
    }
}

if (isset($_POST['ADDEXP'])) {
    addExp($_POST);
    echo "<script>alert('Success! A new supplier has been added.');window.location.href='coba.php'</script>";
}

if (isset($_POST['EDITEXP'])) {
    editExp($_POST);
    echo "<script>alert('Success! A supplier has been updated.');window.location.href='coba.php'</script>";
}

// Close the connection after all operations
$conn->close();
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

    <!-- CONTENT -->
    <div class="content text-center">
        <div class="card">
            <h1>Expenditure</h1>
            <button id="modalAddExpBtn">Add new data</button>

            <!-- ADD NEW EXPENDITURE -->
            <div id="modalAddExp" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Add New Data</h2>
                    <!-- form in coba.php -->
                    <form id="expForm" action="" method="POST">
                        <label for="date">Date:</label><br>
                        <input type="date" id="date" name="date" required autocomplete="off"><br>
                        <label for="category">Category:</label><br>
                        <input type="text" id="category" name="category" required autocomplete="off"><br>
                        <label for="amount">Amount:</label><br>
                        <input type="number" id="amount" name="amount" required autocomplete="off"><br>
                        <label for="pay_method">Payment Method:</label><br>
                        <input type="text" id="pay_method" name="pay_method" required autocomplete="off"><br>
                        <label for="pic">PIC:</label><br>
                        <input type="text" id="pic" name="pic" required autocomplete="off"><br>
                        <label for="dept">Department:</label><br>
                        <input type="text" id="dept" name="dept" required autocomplete="off"><br>
                        <label for="invoice_num">Invoice Number:</label><br>
                        <input type="text" id="invoice_num" name="invoice_num" required autocomplete="off"><br>
                        <label for="approval">Approval:</label><br>
                        <input type="text" id="approval" name="approval" required autocomplete="off"><br>
                        <label for="tax_inf">Tax Information:</label><br>
                        <input type="text" id="tax_inf" name="tax_inf" required autocomplete="off"><br>
                        <label for="notes">Notes:</label><br>
                        <textarea id="notes" name="notes" required></textarea><br>
                        <button type="submit" class="submitBtn" name="ADDEXP" id="ADDEXP">Save</button>
                    </form>
                </div>
            </div>

            <table>
                <tr>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>PIC</th>
                    <th>Department</th>
                    <th>Invoice Number</th>
                    <th>Approval</th>
                    <th>Tax Information</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($exp as $s) { ?>
                    <tr>
                        <td><?= $s['date'] ?></td>
                        <td><?= $s['category'] ?></td>
                        <td><?= $s['amount'] ?></td>
                        <td><?= $s['pay_method'] ?></td>
                        <td><?= $s['pic'] ?></td>
                        <td><?= $s['dept'] ?></td>
                        <td><?= $s['invoice_num'] ?></td>
                        <td><?= $s['approval'] ?></td>
                        <td><?= $s['tax_inf'] ?></td>
                        <td><?= $s['notes'] ?></td>
                        <td>
                            <button class="editBtn" id="modalEditExpBtn<?= $s['id'] ?>">Edit</button>
                            <!-- MODAL EDIT SUPPLIER -->
                            <div id="modalEditExp<?= $s['id'] ?>" class="modal">
                                <div class="modal-content">
                                    <span class="closeEdit<?= $s['id'] ?>" style=" color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor:pointer">&times;</span>
                                    <h2>Edit Data</h2>
                                    <form id="expForm" action="" method="POST">
                                        <input type="hidden" id="id" name="id" value="<?= $s['id'] ?>">
                                        <label for="date">Date:</label><br>
                                        <input type="date" id="date" name="date" required autocomplete="off" value="<?= $s['date'] ?>"><br>
                                        <label for="category">Category:</label><br>
                                        <input type="text" id="category" name="category" required autocomplete="off" value="<?= $s['category'] ?>"><br>
                                        <label for="amount">Amount:</label><br>
                                        <input type="number" id="amount" name="amount" required autocomplete="off" value="<?= $s['amount'] ?>"><br>
                                        <label for="pay_method">Payment Method:</label><br>
                                        <input type="text" id="pay_method" name="pay_method" required autocomplete="off" value="<?= $s['pay_method'] ?>"><br>
                                        <label for="pic">PIC:</label><br>
                                        <input type="text" id="pic" name="pic" required autocomplete="off" value="<?= $s['pic'] ?>"><br>
                                        <label for="dept">Department:</label><br>
                                        <input type="text" id="dept" name="dept" required autocomplete="off" value="<?= $s['dept'] ?>"><br>
                                        <label for="invoice_num">Invoice Number:</label><br>
                                        <input type="text" id="invoice_num" name="invoice_num" required autocomplete="off" value="<?= $s['invoice_num'] ?>"><br>
                                        <label for="approval">Approval:</label><br>
                                        <input type="text" id="approval" name="approval" required autocomplete="off" value="<?= $s['approval'] ?>"><br>
                                        <label for="tax_inf">Tax Information:</label><br>
                                        <input type="text" id="tax_inf" name="tax_inf" required autocomplete="off" value="<?= $s['tax_inf'] ?>"><br>
                                        <label for="notes">Notes:</label><br>
                                        <textarea id="notes" name="notes" required><?= $s['notes'] ?></textarea><br>
                                        <button type="submit" class="submitBtn" name="EDITEXP" id="EDITEXP">Save</button>
                                    </form>
                                </div>
                            </div>

                            <!-- EDIT EXPENDITURE MODAL -->
                            <script>
                                var modalEdit = document.getElementById("modalEditExp<?= $s['id'] ?>");
                                var btnEdit = document.getElementById("modalEditExpBtn<?= $s['id'] ?>");
                                var spanEdit = document.getElementsByClassName("closeEdit<?= $s['id'] ?>");

                                btnEdit.onclick = function() {
                                    modalEdit.style.display = "block";
                                }

                                spanEdit.onclick = function() {
                                    modalEdit.style.display = "none";
                                }

                                window.onclick = function(event) {
                                    if (event.target == modal) {
                                        modalEdit.style.display = "none";
                                    }
                                }
                            </script>

                            <a href="delete.php?id=<?= $s['id'] ?>" class="deleteBtn">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
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

    <!-- ADD SUPPLIER MODAL -->
    <script>
        var modal = document.getElementById("modalAddExp");
        var btn = document.getElementById("modalAddExpBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>