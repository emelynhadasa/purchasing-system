<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serenora</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

</head>
<body>
    <div class="container my-5">
        <h2>Serenora</h2>
        <a class="btn btn-primary" href="/serenora31/create.php" role="button">New Client</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
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
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "shop_db";

                //create connection
                $connection = new mysqli($servername, $username, $password, $database);

                //check connection
                if ($connection->connect_error) {
                    die("Connection failed: " . $connection->connect_error);
                }

                //read table from db
                $sql = "SELECT * FROM exp";
                $result = $connection->query($sql);

                if(!$result) {
                    die("Invalid query: " . $connection->error);
                }

                //read data of each row
                while($row = $result->fetch_assoc()) {
                    echo "
                    <tr>
                    <td>$row[id]</td>
                    <td>$row[date]</td>
                    <td>$row[category]</td>
                    <td>$row[amount]</td>
                    <td>$row[pay_method]</td>
                    <td>$row[pic]</td>
                    <td>$row[dept]</td>
                    <td>$row[invoice_num]</td>
                    <td>$row[approval]</td>
                    <td>$row[tax_inf]</td>
                    <td>$row[notes]</td>
                    <td>
                        <a class='btn btn-primary btn-sm' href='/serenora31/edit.php?id=$row[id]'>Edit</a>
                        <a class='btn btn-danger btn-sm' href='/serenora31/delete.php?id=$row[id]'>Delete</a>
                    </td>
                </tr>
                    ";
                }
                ?>

                
        </table>
    </div>
</body>
</html>