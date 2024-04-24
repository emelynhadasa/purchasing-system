<?php
session_start();

require '../functions.php';

if (!isset($_SESSION['data'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user = dataUser();

if (isset($_POST['ADDUSER'])) {
    addUser($_POST);
    echo "<script>alert('Success! A new user has been added.');window.location.href='userlist.php'</script>";
}

if (isset($_POST['EDITUSER'])) {
    editUser($_POST);
    echo "<script>alert('Success! An user has been updated.');window.location.href='userlist.php'</script>";
}

$counter = 1;

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
            <h1>List of Users</h1>
            <button id="modalAddUserBtn">Add User</button>

            <!-- MODAL ADD USER -->
            <div id="modalAddUser" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Add User</h2>
                    <form id="userForm" action="" method="POST">
                        <label for="name">Name:</label><br>
                        <input type="text" id="name" name="name" required autocomplete="off"><br>
                        <label for="username">Username:</label><br>
                        <input type="text" id="username" name="username" required autocomplete="off"><br>
                        <label for="password">Password:</label><br>
                        <input type="password" id="password" name="password" required autocomplete="off"><br>
                        <label for="role">Login Type:</label><br>
                        <select id="role" name="role" required>
                            <option value="1">Staff</option>
                            <option value="2">Admin</option>
                        </select><br><br>
                        <button type="submit" class="submitBtn" name="ADDUSER" id="ADDUSER">Save</button>
                    </form>
                </div>
            </div>

            <table>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($user as $u) { ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><?= $u['name'] ?></td>
                        <td><?= $u['username'] ?></td>
                        <?php
                            if ($u['role'] == 1) {
                                echo "<td>Staff</td>";
                            } elseif ($u['role'] == 2) {
                                echo "<td>Admin</td>";
                            } else {
                                echo "Unknown";
                            }
                        ?>
                        <td>
                            <button class="editBtn" id="modalEditUserBtn<?= $u['id'] ?>">Edit</button>
                            <!-- MODAL EDIT USER -->
                            <div id="modalEditUser<?= $u['id'] ?>" class="modal">
                                <div class="modal-content">
                                    <span class="closeEdit<?= $u['id'] ?>" style=" color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor:pointer">&times;</span>
                                    <h2>Edit User</h2>
                                    <form id="userForm<?= $u['id'] ?>" action="" method="POST">
                                        <input type="hidden" id="id" name="id" value="<?= $u['id'] ?>">
                                        <label for="name<?= $u['id'] ?>">Name:</label><br>
                                        <input type="text" id="name<?= $u['id'] ?>" name="name" required autocomplete="off" value="<?= $u['name'] ?>"><br>
                                        <label for="username<?= $u['id'] ?>">Username:</label><br>
                                        <input type="text" id="username<?= $u['id'] ?>" name="username" required autocomplete="off" value="<?= $u['username'] ?>"><br>
                                        <label for="password<?= $u['id'] ?>">Password:</label><br>
                                        <input type="password" id="password<?= $u['id'] ?>" name="password" required autocomplete="off" value="<?= $u['password'] ?>"><br>
                                        <label for="role<?= $u['id'] ?>">Login Type:</label><br>
                                        <select id="role<?= $u['id'] ?>" name="role" required>
                                            <option value="1" <?php if ($u['role'] === "1") { ?> selected <?php } ?>>Staff</option>
                                            <option value="2" <?php if ($u['role'] === "2") { ?> selected <?php } ?>>Admin</option>
                                        </select><br><br>
                                        <button type="submit" class="submitBtn" name="EDITUSER" id="EDITUSER">Save</button>
                                    </form>
                                </div>
                            </div>

                            <!-- EDIT USER MODAL -->
                            
                            <script>
                                var modalEdit<?= $u['id'] ?> = document.getElementById("modalEditUser<?= $u['id'] ?>");
                                var btnEdit<?= $u['id'] ?> = document.getElementById("modalEditUserBtn<?= $u['id'] ?>");
                                var spanEdit<?= $u['id'] ?> = document.getElementsByClassName("closeEdit<?= $u['id'] ?>")[0];

                                btnEdit<?= $u['id'] ?>.onclick = function() {
                                    modalEdit<?= $u['id'] ?>.style.display = "block";
                                }

                                spanEdit<?= $u['id'] ?>.onclick = function() {
                                    modalEdit<?= $u['id'] ?>.style.display = "none";
                                }

                                window.onclick = function(event) {
                                    if (event.target == modal) {
                                        modalEdit<?= $u['id'] ?>.style.display = "none";
                                    }
                                }

                            </script>

                            <a href="deleteUser.php?id=<?= $u['id'] ?>" class="deleteBtn">Delete</a>
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

    <!-- ADD USER MODAL -->
    <script>
        var modal = document.getElementById("modalAddUser");
        var btn = document.getElementById("modalAddUserBtn");
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