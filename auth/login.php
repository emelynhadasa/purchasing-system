<?php
session_start();

require '../functions.php';

if (isset($_SESSION['data'])) {
    header("Location: ../management/index.php");
    exit();
}

if (isset($_POST['LOGIN'])) {
    $result = login($_POST);
    if ($result === 300) {
        echo "<script>alert('Login failed! User not registered.');window.location.href='login.php'</script>";
    } else if ($result === 400) {
        echo "<script>alert('Login failed! Invalid Username or Password.');window.location.href='login.php</script>";
    } else {
        $username = $_POST['username'];
        $user = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
        $user = mysqli_fetch_assoc($user);

        $data = [
            'id' => $user['id'],
            'name' => $user['name'],
            'username' => $user['username'],
            'role' => $user['role']
        ];
        $_SESSION['data'] = $data;

        $role = $user['role'];

        if ($role == 1) {
            header("Location: ../management/index.php");
        } else if ($role == 2) {
            header("Location: ../management/indexa.php");
        }
        
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Purchase Order Management System</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter&display=swap">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Purchase Order Management System</h1>
        <div class="card">
            <p>Login</p>
            <form action="" method="post">
                <input type="text" name="username" id="username" placeholder="Username" autocomplete="off" required>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <input type="submit" name="LOGIN" id="LOGIN" value="Login">
            </form>
            <br><br>
            Have no account yet? <a href="register.php" style="color: #687eff;">Register!</a>
        </div>
    </div>
</body>

</html>