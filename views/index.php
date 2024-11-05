<?php
require_once "../koneksi.php";

// Inisialisasi variabel $pemilih sebagai array kosong
$pemilih = [];

// Inisialisasi variabel pencarian
$query = isset($_GET['query']) ? $_GET['query'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

// Query dengan filter status dan pencarian
if ($statusFilter || $query) {
  $sql = "SELECT * FROM pemilih WHERE 1=1";
  $params = [];
  $types = "";

  // Tambahkan kondisi untuk pencarian
  if ($query) {
    $sql .= " AND (nik LIKE ? OR nama LIKE ?)";
    $searchTerm = "%" . $query . "%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $types .= "ss";
  }

  // Tambahkan kondisi untuk filter status
  if ($statusFilter === "tersinkronisasi") {
    $sql .= " AND status = 'Tersinkronisasi'";
  } elseif ($statusFilter === "belum_sinkron") {
    $sql .= " AND status = 'Belum Sinkron'";
  }

  $stmt = $conn->prepare($sql);
  if (!empty($types)) {
    $stmt->bind_param($types, ...$params);
  }
} else {
  // Jika tidak ada pencarian atau filter, ambil semua data
  $sql = "SELECT * FROM pemilih";
  $stmt = $conn->prepare($sql);
}

// Eksekusi query
$stmt->execute();
$result = $stmt->get_result();

// Ambil data hasil query
$pemilih = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $pemilih[] = $row;
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Pemilih</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css" />
  <style>
    .gap-2 {
      gap: 0.5rem;
    }

    /* Style untuk tombol cetak */
    #printButton {
      padding: 6px 12px;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    #printButton:hover {
      background-color: #0dcaf0;
      transform: translateY(-1px);
    }

    /* Style untuk tombol tambah */
    .btn-success {
      padding: 6px 12px;
      font-size: 14px;
      transition: all 0.3s ease;
    }

    .btn-success:hover {
      background-color: #157347;
      transform: translateY(-1px);
    }

    /* Style untuk ikon */
    .bi {
      margin-right: 4px;
    }

    /* Tambahkan styling untuk tombol sync */
    .sync-button {
      background-color: red;
      color: white;
      border: none;
      padding: 3px 8px;
      /* Kurangi padding untuk memperkecil ukuran tombol */
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px;
      /* Ukuran font yang lebih kecil */
    }

    .sync-button.synced {
      background-color: green;
    }

    .edit-button,
    .delete-button {
      padding: 3px 8px;
      /* Sesuaikan padding tombol edit dan hapus */
      font-size: 14px;
      /* Ukuran font yang sama untuk keselarasan */
    }

    .edit-button {
      background-color: blue;
      /* Warna untuk edit */
    }

    .delete-button {
      background-color: red;
      /* Warna untuk hapus */
    }

    .edit-button:hover {
      background-color: darkblue;
      /* Gaya saat hover */
    }

    .delete-button:hover {
      background-color: darkred;
      /* Gaya saat hover */
    }

    /* Modified print styles */
    @media print {
      body {
        margin: 0;
        padding: 20px;
        font-size: 12px;
      }

      .container {
        width: 100%;
        margin: 0;
        padding: 0;
      }

      .navbar,
      .btn,
      .button-container,
      #printButton,
      .no-print {
        display: none !important;
      }

      /* Style untuk tabel saat dicetak */
      .print-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
      }

      .print-table th,
      .print-table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
      }

      .print-table th {
        background-color: #f2f2f2 !important;
        -webkit-print-color-adjust: exact;
      }

      /* Sembunyikan kolom Detail saat mencetak */
      .print-table .detail-column {
        display: none;
      }

      /* Tampilkan status sebagai teks */
      .status-text {
        display: inline !important;
      }

      .sync-button {
        display: none !important;
      }
    }

    /* Tambahkan class untuk status text yang hanya muncul saat print */
    .status-text {
      display: none;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="True">
              Filter
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="index.php?status=tersinkronisasi">Pemilih Tersinkronisasi</a></li>
              <li><a class="dropdown-item" href="index.php?status=belum_sinkron">Pemilih Belum Sinkron</a></li>
            </ul>
          </li>
        </ul>
        <form class="d-flex" role="search" method="GET" action="index.php">
          <input class="form-control me-2" type="search" name="query" placeholder="Search by NIK or Name" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <a href="logout.php" class="btn btn-danger" style="margin: 10px;">Logout</a>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <?php if ($statusFilter === "tersinkronisasi"): ?>
      <h4>Daftar Pemilih Tersinkronisasi</h4>
    <?php elseif ($statusFilter === "belum_sinkron"): ?>
      <h4>Daftar Pemilih Belum Sinkron</h4>
    <?php else: ?>
      <h4>Daftar Semua Pemilih</h4>
    <?php endif; ?>

    <div class="d-flex justify-content-start gap-2 mb-3">
      <button id="printButton" class="btn btn-info btn-sm">
        <i class="bi bi-printer"></i> Cetak Data
      </button>
      <a href="tambah_pemilih.php" class="btn btn-success btn-sm">
        <i class="bi bi-plus-circle"></i> Tambah Data
      </a>
    </div>

    <div class="table-responsive">
      <?php if (!empty($pemilih)): ?>
        <table class="table table-bordered table-hover print-table">
          <thead class="table-light text-center">
            <tr>
              <th>No</th>
              <th>NIK</th>
              <th>NKK</th>
              <th>Nama</th>
              <th>Jenis Kelamin</th>
              <th>Umur</th>
              <th>Tanggal Lahir</th>
              <th>Status</th>
              <th class="detail-column no-print">Detail</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($pemilih as $index => $p): ?>
              <tr>
                <td><?= $index + 1 ?></td>
                <td><?= $p['nik'] ?></td>
                <td><?= $p['nkk'] ?></td>
                <td><?= $p['nama'] ?></td>
                <td><?= $p['jenis_kelamin'] ?></td>
                <td><?= $p['umur'] ?></td>
                <td><?= $p['tgl_lahir'] ?></td>
                <td>
                  <!-- Status text yang hanya muncul saat print -->
                  <span class="status-text"><?= $p['status'] ?></span>

                  <!-- Button yang hanya muncul di layar -->
                  <?php
                  $buttonClass = $p['status'] === "Tersinkronisasi" ? 'btn-success synced' : 'btn-danger';
                  $buttonText = $p['status'] === "Tersinkronisasi" ? 'Data Tersinkronisasi' : 'Data Belum Sinkron';
                  ?>
                  <button class="sync-button btn <?= $buttonClass ?> btn-sm" id="sync-<?= $p['id'] ?>" onclick="syncData(this, <?= $p['id'] ?>)">
                    <?= $buttonText ?>
                  </button>
                </td>
                <td class="detail-column no-print">
                  <div class="d-flex justify-content-start align-items-center">
                    <a href="edit_data.php?id=<?= $p['id'] ?>" class="edit-button btn btn-primary btn-sm ms-2">Edit</a>
                    <a href="delete_data.php?id=<?= $p['id'] ?>" class="delete-button btn btn-danger btn-sm ms-2" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>Data pemilih tidak ditemukan.</p>
      <?php endif; ?>
    </div>
  </div>


  </div>

  <!-- jQuery (dibutuhkan untuk Bootstrap) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap Bundle dengan Popper (untuk fungsi dropdown) -->
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Fungsi untuk mencetak data
    document.getElementById('printButton').addEventListener('click', function() {
      window.print();
    });

    // Fungsi untuk sinkronisasi data
    function syncData(button, id) {
      fetch('sync_status.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: 'id=' + id
        })
        .then(response => response.json())
        .then(data => {
          if (data.status) {
            button.classList.toggle('synced');
            button.textContent = data.status === "Tersinkronisasi" ? 'Data Tersinkronisasi' : 'Data Belum Sinkron';
            button.classList.toggle('btn-danger', data.status !== "Tersinkronisasi");
            button.classList.toggle('btn-success', data.status === "Tersinkronisasi");
          } else {
            alert('Gagal memperbarui status: ' + data.error);
          }
        })
        .catch(error => console.error('Error:', error));
    }
  </script>
</body>

</html>