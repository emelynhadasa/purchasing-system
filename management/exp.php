<?php
session_start();

require '../functions.php';

if (!isset($_SESSION['data'])) {
    header("Location: ../auth/login.php");
    exit();
}
$newexp = addNewExp();

if (isset($_POST['ADDSUPPLIER'])) {
    addSupplier($_POST);
    echo "<script>alert('Success! A new supplier has been added.');window.location.href='supplier.php'</script>";
}

if (isset($_POST['EDITSUPPLIER'])) {
    editSupplier($_POST);
    echo "<script>alert('Success! A supplier has been updated.');window.location.href='supplier.php'</script>";
}
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
            <h1>Expenditure</h1>
            <button id="modalAddDataBtn">Add New Data</button>

            <!-- MODAL ADD DATA -->
            <div id="modalAddData" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Add new data</h2>
                    <form id="expForm" action="" method="POST">
                        <label for="date">Date:</label><br>
                        <input type="text" id="date" name="date" required autocomplete="off"><br>
                        
                        <label for="category">Category:</label><br>
                        <input type="text" id="category" name="category" required autocomplete="off"><br>
                        
                        <label for="amount">Amount:</label><br>
                        <input type="number" id="amount" name="amount" required autocomplete="off"><br>
                        
                        <label for="pay_method">Pay Method:</label><br>
                        <select id="pay_method" name="pay_method" required>
                            <option value="1">1</option>
                            <option value="2">2</option>

                        <label for="pic">PIC:</label><br>
                        <input type="text" id="pic" name="pic" required autocomplete="off"><br>
                        
                        <label for="dept">Department:</label><br>
                        <input type="text" id="dept" name="dept" required autocomplete="off"><br>
                        
                        <label for="invoice_num">Invoice Number:</label><br>
                        <input type="number" id="invoice_num" name="invoice_num" required autocomplete="off"><br>
                        
                        <label for="approval">Approval:</label><br>
                        <select id="approval" name="approval" required>
                            <option value="approve">Approve</option>
                            <option value="pending">Pending</option>
                        
                        <label for="tax_inf">Tax Information:</label><br>
                        <input type="text" id="tax_inf" name="tax_inf" required autocomplete="off"><br>
                       
                        <label for="notes">Notes:</label><br>
                        <textarea id="notes" name="notes" required></textarea><br>
                                      
                        </select><br><br>
                        <button type="submit" class="submitBtn" name="ADDSUPPLIER" id="ADDSUPPLIER">Save</button>
                    </form>
                </div>
            </div>

            <table>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Contact Person</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Date Created</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($supplier as $s) { ?>
                    <tr>
                        <td><?= $s['id'] ?></td>
                        <td><?= $s['name'] ?></td>
                        <td><?= $s['cp'] ?><br><?= $s['phone'] ?></td>
                        <td><?= $s['address'] ?></td>
                        <td><?= $s['status'] ?></td>
                        <td><?= $s['date_created'] ?></td>
                        <td>
                            <button class="editBtn" id="modalEditSupplierBtn<?= $s['id'] ?>">Edit</button>
                            <!-- MODAL EDIT SUPPLIER -->
                            <div id="modalEditSupplier<?= $s['id'] ?>" class="modal">
                                <div class="modal-content">
                                    <span class="closeEdit<?= $s['id'] ?>" style=" color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor:pointer">&times;</span>
                                    <h2>Edit Supplier</h2>
                                    <form id="supplierForm" action="" method="POST">
                                        <input type="hidden" id="id" name="id" value="<?= $s['id'] ?>">
                                        <label for="name">Name:</label><br>
                                        <input type="text" id="name" name="name" required autocomplete="off" value="<?= $s['name'] ?>"><br>
                                        <label for="cp">Contact Name:</label><br>
                                        <input type="text" id="cp" name="cp" required autocomplete="off" value="<?= $s['cp'] ?>"><br>
                                        <label for="phone">Phone:</label><br>
                                        <input type="number" id="phone" name="phone" required autocomplete="off" value="<?= $s['phone'] ?>"><br>
                                        <label for="address">Address:</label><br>
                                        <textarea id="address" name="address" required><?= $s['address'] ?></textarea><br>
                                        <label for="status">Status:</label><br>
                                        <select id="status" name="status" required>
                                            <option value="Active" <?php if ($s['status'] === "Active") { ?> selected <?php } ?>>Active</option>
                                            <option value="Inactive" <?php if ($s['status'] === "Inactive") { ?> selected <?php } ?>>Inactive</option>
                                        </select><br><br>
                                        <button type="submit" class="submitBtn" name="EDITSUPPLIER" id="EDITSUPPLIER">Save</button>
                                    </form>
                                </div>
                            </div>

                            <!-- EDIT SUPPLIER MODAL -->
                            <script>
                                var modalEdit = document.getElementById("modalEditSupplier<?= $s['id'] ?>");
                                var btnEdit = document.getElementById("modalEditSupplierBtn<?= $s['id'] ?>");
                                var spanEdit = document.getElementsByClassName("closeEdit<?= $s['id'] ?>")[0];

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

                            <a href="deleteSupplier.php?id=<?= $s['id'] ?>" class="deleteBtn">Delete</a>
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
        var modal = document.getElementById("modalAddSupplier");
        var btn = document.getElementById("modalAddSupplierBtn");
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