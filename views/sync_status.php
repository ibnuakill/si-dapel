<?php
require_once "../koneksi.php";

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Query untuk mengambil status saat ini dari database
    $sql = "SELECT status FROM pemilih WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    // Tentukan status baru berdasarkan status saat ini
    $newStatus = ($data['status'] == "Belum Sinkron") ? "Tersinkronisasi" : "Belum Sinkron";

    // Query untuk memperbarui status
    $updateSql = "UPDATE pemilih SET status = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("si", $newStatus, $id);

    if ($updateStmt->execute()) {
        echo json_encode(['status' => $newStatus]);
    } else {
        echo json_encode(['error' => 'Gagal memperbarui status']);
    }
}
