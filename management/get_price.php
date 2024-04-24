<?php
// Koneksi ke database
require '../functions.php';

$itemName = $_GET['itemName'];

// Query untuk mendapatkan harga item dari database
$sql = "SELECT price FROM item WHERE name = '$itemName'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ambil hasil query dan kirimkan sebagai respons
    $row = $result->fetch_assoc();
    $price = $row['price'];
    echo $price;
} else {
    echo "Harga tidak ditemukan";
}

$conn->close();
