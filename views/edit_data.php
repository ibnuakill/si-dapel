<?php
require_once "../koneksi.php";

// Ambil ID dari URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Jika ID tidak ditemukan, arahkan kembali ke halaman utama
if ($id == 0) {
    header("Location: index.php");
    exit();
}

// Ambil data pemilih berdasarkan ID
$sql = "SELECT * FROM pemilih WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Proses update data jika form disubmit
// Proses update data jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $nkk = $_POST['nkk'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $umur = $_POST['umur'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $status = $_POST['status'];

    // Update data ke database
    $updateSql = "UPDATE pemilih SET nik = ?, nama = ?, nkk = ?, jenis_kelamin = ?, tgl_lahir = ?, umur = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("sssssisi", $nik, $nama, $nkk, $jenis_kelamin, $tgl_lahir, $umur, $status, $id);

    if ($stmt->execute()) {
        header("Location: index.php"); // Arahkan kembali ke halaman utama setelah berhasil mengedit
        exit();
    } else {
        $error = "Gagal memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pemilih</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            padding: 20px;
            margin-top: 50px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control,
        .form-select {
            margin-bottom: 20px;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mb-4 text-center">Edit Data Pemilih</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="mb-3">
                <label for="nik" class="form-label">NIK</label>
                <input type="text" class="form-control" id="nik" name="nik" value="<?= $data['nik'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $data['nama'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="nkk" class="form-label">NKK</label>
                <input type="text" class="form-control" id="nkk" name="nkk" value="<?= $data['nkk'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-Laki" <?= $data['jenis_kelamin'] == "Laki-Laki" ? "selected" : "" ?>>Laki-Laki</option>
                    <option value="Perempuan" <?= $data['jenis_kelamin'] == "Perempuan" ? "selected" : "" ?>>Perempuan</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="umur" class="form-label">Umur</label>
                <input type="number" class="form-control" id="umur" name="umur" value="<?= $data['umur'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir"
                    value="<?= $data['tgl_lahir'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Belum Sinkron" <?= $data['status'] == "Belum Sinkron" ? "selected" : "" ?>>Belum Sinkron</option>
                    <option value="Tersinkronisasi" <?= $data['status'] == "Tersinkronisasi" ? "selected" : "" ?>>Tersinkronisasi</option>
                </select>
            </div>

            <div class="btn-container">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="index.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>