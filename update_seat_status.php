<?php
require 'koneksi.php'; // Koneksi ke database

$seatNumber = $_POST['seat_number']; // Mendapatkan nomor kursi yang dipilih

// Update status kursi menjadi 'occupied'
$query = "UPDATE seats SET status = 'occupied' WHERE seat_number = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $seatNumber);
$stmt->execute();

echo json_encode(["status" => "success"]);
