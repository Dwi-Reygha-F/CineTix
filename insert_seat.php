<?php
require 'koneksi.php';

$seat_number = $_POST['seat_number'] ?? null;
$mall_name = $_POST['mall_name'] ?? null;
$film_name = $_POST['film_name'] ?? null;

if (!$seat_number || !$mall_name || !$film_name) {
    echo json_encode(["error" => "Data tidak lengkap"]);
    exit;
}

// Cek apakah kursi sudah diambil
$stmtCheck = $conn->prepare("SELECT id FROM seats WHERE seat_number = ? AND mall_name = ? AND film_name = ?");
$stmtCheck->bind_param("sss", $seat_number, $mall_name, $film_name);

if (!$stmtCheck->execute()) {
    echo json_encode(["error" => "Query cek kursi gagal: " . $stmtCheck->error]);
    exit;
}

$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows > 0) {
    echo json_encode(["error" => "Kursi sudah terisi"]);
    exit;
}

// Debugging: cek query insert sebelum eksekusi
$query = "INSERT INTO seats (seat_number, mall_name, film_name, status) VALUES ('$seat_number', '$mall_name', '$film_name', 'occupied')";
error_log("DEBUG INSERT QUERY: " . $query);

// Insert kursi jika belum ada
$stmtInsert = $conn->prepare("INSERT INTO seats (seat_number, mall_name, film_name, status) VALUES (?, ?, ?, 'occupied')");
$stmtInsert->bind_param("sss", $seat_number, $mall_name, $film_name);

if (!$stmtInsert->execute()) {
    echo json_encode(["error" => "Gagal insert kursi: " . $stmtInsert->error]);
    exit;
}

echo json_encode(["success" => true]);