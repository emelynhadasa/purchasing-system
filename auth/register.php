<?php
session_start();

require '../functions.php';

if (isset($_SESSION['data'])) {
    header("Location: ../management/index.php");
    exit();
}

if (isset($_POST['REGISTER'])) {
    $result = register($_POST);
    if ($result === 200) {
        echo "<script>alert('Regiser succsess!');window.location.href='login.php'</script>";
    } else if ($result === 300) {
        echo "<script>alert('Register failed! User already exist.');window.location.href='register.php'</script>";
    } else if ($result === 400) {
        echo "<script>alert('Register failed! Password and Confirmation Password does not match.');window.location.href='register.php'</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Purchase Order Management System</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter&display=swap">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Purchase Order Management System</h1>
        <div class="card">
            <p>Register</p>
            <form action="" method="post">
                <input type="text" name="name" id="name" placeholder="Name" autocomplete="off" required>
                <input type="text" name="username" id="username" placeholder="Username" autocomplete="off" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <input type="password" name="confirmPassword" id="password" placeholder="Confirm password" required>
                <input type="submit" name="REGISTER" id="REGISTER" value="Register">
            </form>
            <br><br>
            Have an account? <a href="login.php" style="color: #687eff;">Login!</a>
        </div>
    </div>
</body>

</html>