<div class="sidebar" id="sidebar">
    <ul class="">
        <li>
            <a href="index.php">Dashboard</a>
        </li>
        <li>
            <a href="supplier.php">Suppliers</a>
        </li>
        <li>
            <a href="item.php">Items</a>
        </li>
        <li>
            <a href="purchaseOrder.php">Purchase Orders</a>
        </li>
        <li>
            <a href="billsPayment.php">Bills</a>
        </li>
        <li>
            <a href="coba.php">Expenditure</a>
        </li>
        <hr>

        <?php if ($_SESSION['data']['role'] == 2): ?>
        <li>
            <a href="userlist.php">User List</a>
        </li>
        <li>
            <a href="employeelist.php">Employee List</a>
        </li>
        <?php endif; ?>

        <li>
            <a href="../auth/logout.php" class="logout">Logout</a>
        </li>
    </ul>
</div>