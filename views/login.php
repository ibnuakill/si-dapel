<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Form</title>
  <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/login.css" />
</head>

<body class="bg-dark d-flex justify-content-center align-items-center">
  <div class="container login-container d-flex justify-content-center align-items-center">
    <div class="card p-4 shadow-lg login-card">
      <div class="card-body">
        <h3 class="card-title text-center mb-4 fw-bold">Login Si-Dapel</h3>

        <!-- Menampilkan pesan error jika ada -->
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required />
          </div>
          <div class="mb-3 create-account">
            <a href="register.php" class="text-decoration-none">Tidak punya akun?</a>
          </div>
          <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>