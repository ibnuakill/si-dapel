<?php
require_once "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $nkk = $_POST['nkk'] ?? '';
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $umur = $_POST['umur'] ?? '';
    $tgl_lahir = $_POST['tgl_lahir'] ?? '';

    if (empty($nik) || empty($nama) || empty($nkk) || empty($jenis_kelamin) || empty($umur) || empty($tgl_lahir)) {
        echo "Semua field harus diisi.";
        exit;
    }

    $sql = "INSERT INTO pemilih (nik, nama, nkk, jenis_kelamin, umur, tgl_lahir) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssis", $nik, $nama, $nkk, $jenis_kelamin, $umur, $tgl_lahir);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
! $conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pemilih</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <style>
        /* Background gradient */
        body {
            background: linear-gradient(135deg, #CECECE, #a3c0f7);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #343a40;
            padding: 0 15px;
        }

        /* Styling for card */
        .card {
            max-width: 100%;
            border: none;
            border-radius: 12px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.15);
        }

        /* Proportional header */
        .card-header {
            background: #4285f4;
            border-radius: 12px 12px 0 0;
            padding: 8px 0;
        }

        .card-header h4 {
            font-size: 1.25rem;
            margin: 0;
        }

        /* Compact input fields */
        .form-control,
        .form-select {
            height: calc(1.5em + 0.75rem + 2px);
            font-size: 0.9rem;
            padding: 0.375rem 0.75rem;
        }

        /* Smaller buttons with consistent margins */
        .btn-primary,
        .btn-secondary {
            margin: 3px;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.9rem;
        }

        .btn-primary:hover {
            background-color: #1c5cd1;
        }

        .btn-secondary:hover {
            background-color: #5c6bc0;
        }

        /* Reduce padding in card body */
        .card-body {
            padding: 1rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header text-white text-center">
                        <h4>Tambah Data Pemilih</h4>
                    </div>
                    <div class="card-body">
                        <form action="tambah_pemilih.php" method="POST">
                            <div class="mb-2">
                                <label for="nik" class="form-label">NIK:</label>
                                <input type="text" name="nik" class="form-control" placeholder="Masukkan NIK" required>
                            </div>

                            <div class="mb-2">
                                <label for="nama" class="form-label">Nama:</label>
                                <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama" required>
                            </div>

                            <div class="mb-2">
                                <label for="nkk" class="form-label">NKK:</label>
                                <input type="text" name="nkk" class="form-control" placeholder="Masukkan NKK" required>
                            </div>

                            <div class="mb-2">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin:</label>
                                <select name="jenis_kelamin" class="form-select" required>
                                    <option value="" disabled selected>Pilih jenis kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <label for="umur" class="form-label">Umur:</label>
                                <input type="number" name="umur" class="form-control" placeholder="Masukkan Umur" required>
                            </div>

                            <div class="mb-2">
                                <label for="tgl_lahir" class="form-label">Tanggal Lahir:</label>
                                <input type="date" name="tgl_lahir" class="form-control" required>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Tambah Data Pemilih</button>
                                <a href="index.php" class="btn btn-secondary">Kembali ke Daftar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>