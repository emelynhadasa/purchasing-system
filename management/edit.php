<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "expenditure";

//create connection
$connection = new mysqli($servername, $username, $password, $database);



$id = "";
$date = "";
$category = "";
$amount = "";
$pay_method = "";
$pic = "";
$dept = "";
$invoice_num = "";
$approval = "";
$tax_inf = "";
$notes = "";

$errorMassage = "";
$successMassage = "";

if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
    //GET METHOD -> SHOW DATA OF CLIENT

    IF ( !isset($_GET["id"]) ) {
        header("location: /serenora31/index.php");
        exit;
    }

    $id = $_GET["id"];

    //read the row of selected id from the table
    $sql = "SELECT * FROM exp WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header ("location: ./coba.php");
        exit;
    }

    $date = $row["date"];
    $category = $row["category"];
    $amount = $row["amount"];
    $pay_method = $row["pay_method"];
    $pic = $row["pic"];
    $dept = $row["dept"];
    $invoice_num = $row["invoice_num"];
    $approval = $row["approval"];
    $tax_inf = $row["tax_inf"];
    $notes = $row["notes"];

    }else {
    //POST METHOD -> UPDATE DATA OF CLIENT
    $date = $_POST["date"];
    $category = $_POST["category"];
    $amount = $_POST["amount"];
    $pay_method = $_POST["pay_method"];
    $pic = $_POST["pic"];
    $dept = $_POST["dept"];
    $invoice_num = $_POST["invoice_num"];
    $approval = $_POST["approval"];
    $tax_inf = $_POST["tax_inf"];
    $notes = $_POST["notes"];
    
    do {
        if ( empty($date) || empty($category) || empty($amount) || empty($pay_method) || empty($pic) || empty($dept) 
        || empty($invoice_num) || empty($approval) || empty($tax_inf) || empty($notes) ) {
            $errorMassage = "All the fields are required";
            break;
        }

        $sql = "UPDATE exp " . 
        "SET date = '$date', category = '$category', payment method = '$pay_method', pic = '$pic', department = '$dept', 
        invoice number = '$invoice_num', approval = '$approval', tax information = '$tax_inf', notes = '$notes'";
        
        $result = $connection->query($sql);

        if (!$result) {
            $errorMassage = "Invalid query: " . $connection->error;
            break;
        }

        $successMassage = "Client updated correctly";

        header("location: ./coba.php");
        exit;

    }while (false);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-widht, initial-scale=1.0">
    <title>Serenora</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Serenora</h2>

        <?php
        if ( !empty($errorMassage) ) {
            echo "
            <div class='alert alert-warning alert-dismissilbe fade show' role='alert'>
                <strong>$errorMassage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class='row mb-3'>
                <label class="col-sm-3 col-form-label">Date</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="date" value="<?php echo $date; ?>">
                </div>
            </div>
            <div class='row mb-3'>
                <label class="col-sm-3 col-form-label">Category</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="category" value="<?php echo $category; ?>">
                </div>
            </div>
            <div class='row mb-3'>
                <label class="col-sm-3 col-form-label">Amount</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="amount" value="<?php echo $amount; ?>">
                </div>
            </div>
            <div class='row mb-3'>
                <label class="col-sm-3 col-form-label">Payment Method</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="pay_method" value="<?php echo $pay_method; ?>">
                </div>
            </div>
            <div class='row mb-3'>
                <label class="col-sm-3 col-form-label">PIC</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="pic" value="<?php echo $pic; ?>">
                </div>
            </div>
            <div class='row mb-3'>
                <label class="col-sm-3 col-form-label">Department</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="dept" value="<?php echo $dept; ?>">
                </div>
            </div>
            <div class='row mb-3'>
                <label class="col-sm-3 col-form-label">Invoice Number</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="invoice_num" value="<?php echo $invoice_num; ?>">
                </div>
            </div>
            <div class='row mb-3'>
                <label class="col-sm-3 col-form-label">Approval</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="approval" value="<?php echo $approval; ?>">
                </div>
            </div>
            <div class='row mb-3'>
                <label class="col-sm-3 col-form-label">Tax Information</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="tax_inf" value="<?php echo $tax_inf; ?>">
                </div>
            </div>
            <div class='row mb-3'>
                <label class="col-sm-3 col-form-label">notes</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="notes" value="<?php echo $notes; ?>">
                </div>
            </div>

            <?php
            if ( !empty($successMassage) ) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-warning alert-dismissilbe fade show' role='alert'>
                            <strong>$successMassage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>
            <div class="row mb-3">
                <label class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</label>
                </div>
                <div class="col-sm-3 offset-sm-3 d-grid">
                    <a class="btn btn-primary" href="/serenora31/index.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>