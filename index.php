<?php
session_start();

if (isset($_SESSION['data'])) {
    header("Location: management/index.php");
    exit();
} else {
    header("Location: auth/login.php");
    exit();
}
