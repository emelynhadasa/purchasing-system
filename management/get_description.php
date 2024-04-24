<?php
// Koneksi ke database
require '../functions.php';

$itemName = $_GET['itemName'];

// Query untuk mendapatkan deskripsi item dari database
$sql = "SELECT description FROM item WHERE name = '$itemName'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ambil hasil query dan kirimkan sebagai respons
    $row = $result->fetch_assoc();
    $description = $row['description'];
    echo $description;
} else {
    echo "Deskripsi tidak ditemukan";
}

$conn->close();
