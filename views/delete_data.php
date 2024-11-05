<?php
require_once "../koneksi.php"; // Pastikan path koneksi sesuai

// Periksa apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Pastikan parameter adalah angka untuk menghindari SQL Injection

    // Query untuk menghapus data berdasarkan id
    $sql = "DELETE FROM pemilih WHERE id = ?";

    // Persiapkan statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // "i" menunjukkan tipe data integer

    // Eksekusi dan cek apakah query berhasil
    if ($stmt->execute()) {
        echo "Data berhasil dihapus.";
        header("Location: index.php"); // Arahkan kembali ke halaman daftar pemilih
        exit;
    } else {
        echo "Terjadi kesalahan saat menghapus data.";
    }

    // Tutup statement
    $stmt->close();
} else {
    echo "ID tidak ditemukan.";
}

// Tutup koneksi
$conn->close();
