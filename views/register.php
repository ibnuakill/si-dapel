<?php
require_once "../koneksi.php";

$registerSuccess = false; // Status untuk cek apakah registrasi sukses

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing password untuk keamanan

    $sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        $registerSuccess = true; // Set status ke sukses
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>

<body class="bg-dark d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 shadow-lg" style="width: 400px;">
        <h3 class="card-title text-center mb-5 fw-bold">Register Akun Si-Dapel</h3>

        <?php if ($registerSuccess): ?>
            <!-- Tampilkan pesan sukses dan tombol kembali ke login -->
            <div class="alert alert-success text-center">
                Registrasi berhasil!
            </div>
            <div class="text-center mt-3">
                <a href="login.php" class="btn btn-primary w-100">Kembali ke Login</a>
            </div>
        <?php else: ?>
            <!-- Tampilkan form registrasi jika belum sukses -->
            <form method="POST" action="register.php">

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <a href="login.php" class="text-decoration-none">Sudah Punya Akun?</a>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>