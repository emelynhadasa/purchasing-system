<?php
session_start();

require '../functions.php';

if (!isset($_SESSION['data'])) {
    header("Location: ../auth/login.php");
    exit();
}
$item = dataItem();

if (isset($_POST['ADDITEM'])) {
    addItem($_POST);
    echo "<script>alert('Success! A new item has been added.');window.location.href='item.php'</script>";
}

if (isset($_POST['EDITITEM'])) {
    editItem($_POST);
    echo "<script>alert('Success! Some item has been updated.');window.location.href='item.php'</script>";
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
            <h1>Items</h1>
            <?php if ($_SESSION['data']['role'] == 1): ?>
                <button id="modalAddItemBtn">Add Item</button>
            <?php endif; ?>
            

            <!-- MODAL ADD ITEM -->
            <div id="modalAddItem" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Add Item</h2>
                    <form id="itemForm" action="" method="POST">
                        <label for="name">Name:</label><br>
                        <input type="text" id="name" name="name" required autocomplete="off"><br>
                        <label for="description">Description:</label><br>
                        <textarea id="description" name="description" required></textarea><br>
                        <label for="price">Price: Rp.</label><br>
                        <input type="number" id="price" name="price" required autocomplete="off"><br>
                        <label for="status">Status:</label><br>
                        <select id="status" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select><br><br>
                        <button type="submit" class="submitBtn" name="ADDITEM" id="ADDITEM">Save</button>
                    </form>
                </div>
            </div>

            <table>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Date Created</th>
                    <?php if ($_SESSION['data']['role'] == 1): ?>
                        <th>Action</th>
                    <?php endif; ?>
                </tr>
                <?php foreach ($item as $i) { ?>
                    <tr>
                        <td><?= $i['id'] ?></td>
                        <td><?= $i['name'] ?></td>
                        <td><?= $i['description'] ?></td>
                        <td>Rp. <?= $i['price'] ?></td>
                        <td><?= $i['status'] ?></td>
                        <td><?= $i['date_created'] ?></td>
                        <?php if ($_SESSION['data']['role'] == 1): ?>
                        <td>
                            <button class="editBtn" id="modalEditItemBtn<?= $i['id'] ?>">Edit</button>
                            <!-- MODAL EDIT ITEM -->
                            <div id="modalEditItem<?= $i['id'] ?>" class="modal">
                                <div class="modal-content">
                                    <span class="closeEdit<?= $i['id'] ?>" style=" color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor:pointer">&times;</span>
                                    <h2>Edit Item</h2>
                                    <form id="itemForm" action="" method="POST">
                                        <input type="hidden" id="id" name="id" value="<?= $i['id'] ?>">
                                        <label for="name">Name:</label><br>
                                        <input type="text" id="name" name="name" required autocomplete="off" value="<?= $i['name'] ?>"><br>
                                        <label for="description">Description:</label><br>
                                        <textarea id="description" name="description" required><?= $i['description'] ?></textarea><br>
                                        <label for="price">Price: Rp.</label><br>
                                        <input type="number" id="price" name="price" required autocomplete="off" value="<?= $i['price'] ?>"><br>
                                        <label for="status">Status:</label><br>
                                        <select id="status" name="status" required>
                                            <option value="Active" <?php if ($i['status'] === "Active") { ?> selected <?php } ?>>Active</option>
                                            <option value="Inactive" <?php if ($i['status'] === "Inactive") { ?> selected <?php } ?>>Inactive</option>
                                        </select><br><br>
                                        <button type="submit" class="submitBtn" name="EDITITEM" id="EDITITEM">Save</button>
                                    </form>
                                </div>
                            </div>

                            <!-- EDIT ITEM MODAL -->
                            <script>
                                var modalEdit = document.getElementById("modalEditItem<?= $i['id'] ?>");
                                var btnEdit = document.getElementById("modalEditItemBtn<?= $i['id'] ?>");
                                var spanEdit = document.getElementsByClassName("closeEdit<?= $i['id'] ?>")[0];

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

                            <a href="deleteItem.php?id=<?= $i['id'] ?>" class="deleteBtn">Delete</a>
                        </td>
                        <?php endif; ?>
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

    <!-- ADD ITEM MODAL -->
    <script>
        var modal = document.getElementById("modalAddItem");
        var btn = document.getElementById("modalAddItemBtn");
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