<?php

date_default_timezone_set("Asia/Jakarta");

$conn = mysqli_connect("localhost", "root", "", "poms");

function register($data)
{
    global $conn;

    $name = htmlspecialchars($data['name']);
    $username = htmlspecialchars(strtolower($data['username']));
    $user = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
    if (mysqli_num_rows($user) > 0) {
        return 300; // USER ALREADY EXIST
    }

    $password = $data['password'];
    $confirmPassword = $data['confirmPassword'];
    if ($password !== $confirmPassword) {
        return 400; // PASSWORD DOESN'T MATCH
    }

    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $last_login = NULL;
    $role = 1;
    $date_added = date("Y-m-d H:i:s");
    $date_updated = NULL;

    $query = "INSERT INTO user VALUES ('', '$name', '$username', '$password', '$last_login', '$role', '$date_added', '$date_updated')";
    mysqli_query($conn, $query);
    return 200;
}

function login($data)
{
    global $conn;

    $username = htmlspecialchars(strtolower($data['username']));
    $password = $data['password'];

    $user = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
    $user = mysqli_fetch_assoc($user);

    if ((!$user)) {
        return 300; // USER NOT REGISTERED
    }

    if (!password_verify($password, $user['password'])) {
        return 400; // WRONG PASSWORD
    }

    $last_login = date("Y-m-d H:i:s");

    mysqli_query($conn, "UPDATE user SET last_login='$last_login' WHERE username='$username'");
    return 200; // BERHASIL
}

function total_suppliers()
{
    global $conn;

    $total_suppliers = mysqli_query($conn, "SELECT * FROM supplier");
    $total_suppliers = mysqli_num_rows($total_suppliers);

    return $total_suppliers;
}

function total_items()
{
    global $conn;

    $total_items = mysqli_query($conn, "SELECT * FROM item");
    $total_items = mysqli_num_rows($total_items);

    return $total_items;
}

function total_purchase_orders()
{
    global $conn;

    $total_purchase_orders = mysqli_query($conn, "SELECT * FROM po");
    $total_purchase_orders = mysqli_num_rows($total_purchase_orders);

    return $total_purchase_orders;
}

function dataUser()
{
    global $conn;

    $user = mysqli_query($conn, "SELECT * FROM user");
    return $user;
}

function addUser($data)
{
    global $conn;

    $name = $data['name'];
    $username = $data['username'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $role = $data['role'];

    mysqli_query($conn, "INSERT INTO user VALUES('', '$name', '$username', '$password', '', '$role', '', '')");
}

function editUser($data)
{
    global $conn;

    $id = $data['id'];
    $name = $data['name'];
    $username = $data['username'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $role = $data['role'];

    mysqli_query($conn, "UPDATE user SET name='$name', username='$username', password='$password', role='$role' WHERE id='$id'");
}

function dataSupplier()
{
    global $conn;


    $supplier = mysqli_query($conn, "SELECT * FROM supplier");
    return $supplier;
}

function addSupplier($data)
{
    global $conn;

    $name = $data['name'];
    $cp = $data['cp'];
    $phone = $data['phone'];
    $address = $data['address'];
    $status = $data['status'];
    $bank = $data['bank'];
    $date_created = date("Y-m-d H:i:s");

    mysqli_query($conn, "INSERT INTO supplier VALUES('', '$name', '$cp', '$phone', '$address', '$status', '$bank', '$date_created')");
}

function editSupplier($data)
{
    global $conn;

    $id = $data['id'];
    $name = $data['name'];
    $cp = $data['cp'];
    $phone = $data['phone'];
    $address = $data['address'];
    $status = $data['status'];
    $bank = $data['bank'];

    mysqli_query($conn, "UPDATE supplier SET name='$name', cp='$cp', phone='$phone', address='$address', status='$status', bank='$bank' WHERE id='$id'");
}

function dataItem()
{
    global $conn;


    $item = mysqli_query($conn, "SELECT * FROM item");
    return $item;
}

function addItem($data)
{
    global $conn;

    $name = $data['name'];
    $description = $data['description'];
    $price = $data['price'];
    $status = $data['status'];
    $date_created = date("Y-m-d H:i:s");

    mysqli_query($conn, "INSERT INTO item VALUES('', '$name', '$description', '$price', '$status', '$date_created')");
}

function editItem($data)
{
    global $conn;

    $id = $data['id'];
    $name = $data['name'];
    $description = $data['description'];
    $price = $data['price'];
    $status = $data['status'];

    mysqli_query($conn, "UPDATE item SET name='$name', description='$description', price='$price', status='$status' WHERE id='$id'");
}

function dataPurchaseOrder()
{
    global $conn;


    $po = mysqli_query($conn, "SELECT * FROM po");
    return $po;
}

function dataPurchaseOrderByPo_number($po_number)
{
    global $conn;

    $po = mysqli_query($conn, "SELECT * FROM po WHERE po_number='$po_number'");
    return $po;
}

function dataItemPoByPo_number($po_number)
{
    global $conn;

    $item_po = mysqli_query($conn, "SELECT * FROM item_po WHERE po_number='$po_number'");
    return $item_po;
}

function newPurchaseOrder($data)
{
    global $conn;

    $created_by = $_SESSION['data']['name'];

    $result = mysqli_query($conn, "SELECT po_number FROM po ORDER BY id DESC LIMIT 1");
    if ($row = mysqli_fetch_assoc($result)) {
        $lastNumber = $row['po_number'];
        $nextNumber = preg_replace('/\d+/', '', $lastNumber) . sprintf('%010d', preg_replace('/\D/', '', $lastNumber) + 1);
        $po_number = $nextNumber;
    } else {
        $po_number = "PO0000000001";
    }

    $supplier = mysqli_real_escape_string($conn, $data['supplier']);
    $status = mysqli_real_escape_string($conn, "Pending");
    $subTotal = mysqli_real_escape_string($conn, $data['subTotal']);
    $percentDiscount = mysqli_real_escape_string($conn, $data['percentDiscount']);
    $priceDiscount = mysqli_real_escape_string($conn, $data['priceDiscount']);
    $percentTaxInclusive = mysqli_real_escape_string($conn, $data['percentTaxInclusive']);
    $priceTaxInclusive = mysqli_real_escape_string($conn, $data['priceTaxInclusive']);
    $totalAll = mysqli_real_escape_string($conn, $data['totalAll']);
    $note = mysqli_real_escape_string($conn, $data['note']);
    $date_created = date("Y-m-d H:i:s");

    $query = "INSERT INTO po (po_number, supplier, status, subtotal, percentDiscount, priceDiscount, percentTaxInclusive, priceTaxInclusive, note, totalAll, date_created, created_by) 
              VALUES ('$po_number', '$supplier', '$status', '$subTotal', '$percentDiscount', '$priceDiscount', '$percentTaxInclusive', '$priceTaxInclusive', '$note', '$totalAll', '$date_created', '$created_by')";

    mysqli_query($conn, $query);

    for ($i = 0; $i < count($data['qty']); $i++) {
        $qty = mysqli_real_escape_string($conn, $data['qty'][$i]);
        $unit = mysqli_real_escape_string($conn, $data['unit'][$i]);
        $item = mysqli_real_escape_string($conn, $data['item'][$i]);
        $description = mysqli_real_escape_string($conn, $data['description'][$i]);
        $price = mysqli_real_escape_string($conn, $data['price'][$i]);
        $total = mysqli_real_escape_string($conn, $data['total'][$i]);

        // Query to insert data into database
        $query = "INSERT INTO item_po (po_number, qty, unit, item, description, price, total) 
                  VALUES ('$po_number', '$qty', '$unit', '$item', '$description', '$price', '$total')";

        mysqli_query($conn, $query);
    }
}

function addExp($data)
{
    $conn = new mysqli("localhost", "root", "", "poms");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $date = $conn->real_escape_string($data['date']);
    $category = $conn->real_escape_string($data['category']);
    $amount = $conn->real_escape_string($data['amount']);
    $pay_method = $conn->real_escape_string($data['pay_method']);
    $pic = $conn->real_escape_string($data['pic']);
    $dept = $conn->real_escape_string($data['dept']);
    $invoice_num = $conn->real_escape_string($data['invoice_num']);
    $approval = $conn->real_escape_string($data['approval']);
    $tax_inf = $conn->real_escape_string($data['tax_inf']);
    $notes = $conn->real_escape_string($data['notes']);

    $sql = "INSERT INTO exp (date, category, amount, pay_method, pic, dept, invoice_num, approval, tax_inf, notes)
            VALUES ('$date', '$category', '$amount', '$pay_method', '$pic', '$dept', '$invoice_num', '$approval', '$tax_inf', '$notes')";

    if ($conn->query($sql) === TRUE) {
        // Record inserted successfully
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

function dataBills()
{
    global $conn;


    $bills = mysqli_query($conn, "SELECT * FROM bills");
    return $bills;
}

function editExp($data)
{
    global $conn;

    $id = $data['id'];
    $date = $data['date'];
    $category = $data['category'];
    $amount = $data['amount'];
    $pay_method = $data['pay_method'];
    $pic = $data['pic'];
    $dept = $data['dept'];
    $invoice_num = $data['invoice_num'];
    $approval = $data['approval'];
    $tax_inf = $data['tax_inf'];
    $notes = $data['notes'];

    mysqli_query($conn, "UPDATE exp 
                         SET date='$date', category='$category', amount='$amount', pay_method='$pay_method', 
                             pic='$pic', dept='$dept', invoice_num='$invoice_num', approval='$approval', 
                             tax_inf='$tax_inf', notes='$notes' 
                         WHERE id='$id'");
}

function registerPayment($data)
{
    global $conn;

    $po_number = $data['po_number'];
    $supplier = mysqli_real_escape_string($conn, $data['supplier']);
    $employee = $data['employee'];
    $payment_date = date("Y-m-d");
    $payment_method = $data['payment_method'];
    $recipient_bank = $data['recipient_bank'];
    $amount = $data['amount'];
    $currency= $data['currency'];
    $status = "Paid";
    

    mysqli_query($conn, "INSERT INTO bills (po_number, supplier, employee, payment_date, payment_method, recipient_bank, amount, currency, status)
    VALUES('$po_number', '$supplier', '$employee', '$payment_date', '$payment_method', '$recipient_bank', '$amount', '$currency', '$status')");
}
?>



<?php



