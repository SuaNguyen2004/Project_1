<?php
require_once '../config/db.php';
require_once '../includes/function.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  $sql = "SELECT * FROM nguoi_dung WHERE ten_dang_nhap = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$username]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['mat_khau'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['ten_dang_nhap'];
    $_SESSION['ho_ten'] = $user['ho_ten'];
    $_SESSION['vai_tro'] = $user['vai_tro'];

    if ($user['vai_tro'] == 'admin') {
      header("Location: ../admin/index.php");
    } elseif ($user['vai_tro'] == 'nhan_vien') {
      header("Location: ../nhan-vien/index.php");
    } else {
      header("Location: /Project/index.php");
    }
    exit();
  } else {
    $error = "Tên đăng nhập hoặc mật khẩu không chính xác!";
  }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập hệ thống - MINIMART</title>
  <!-- Bootstrap 5 & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      background-color: #f4f7f6;
    }

    .login-card {
      max-width: 400px;
      border: none;
      border-radius: 15px;
    }

    .btn-login {
      background-color: #2c3e50;
      border: none;
      transition: 0.3s;
    }

    .btn-login:hover {
      background-color: #1a252f;
      transform: translateY(-2px);
    }

    .form-control:focus {
      border-color: #2c3e50;
      box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.25);
    }
  </style>
</head>

<body class="d-flex align-items-center min-vh-100" style="background-color: #e57a8c">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-4">
        <div class="card login-card shadow-lg p-4">
          <div class="card-body">
            <div class="text-center mb-4">
              <h2 class="fw-bold text-uppercase" style="color: #2c3e50;">Đăng Nhập</h2>
              <p class="text-muted small">Hệ thống quản lý MINIMART</p>
            </div>

            <?php if ($error): ?>
              <div class="alert alert-danger d-flex align-items-center py-2" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div style="font-size: 0.85rem;"><?php echo $error; ?></div>
              </div>
            <?php endif; ?>

            <form method="POST">
              <div class="mb-3">
                <label class="form-label fw-bold small">Tên đăng nhập</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                  <input type="text" name="username" class="form-control bg-light border-start-0"
                    placeholder="Nhập tài khoản..." required>
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold small">Mật khẩu</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                  <input type="password" name="password" class="form-control bg-light border-start-0"
                    placeholder="Nhập mật khẩu..." required>
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-login w-100 py-2 fw-bold mb-3">
                Đăng nhập <i class="fas fa-sign-in-alt ms-2"></i>
              </button>
            </form>

            <div class="text-center mt-3 border-top pt-3">
              <p class="small mb-1">Chưa có tài khoản? <a href="dang-ky.php" class="text-decoration-none fw-bold">Đăng ký ngay</a></p>
              <a href="../index.php" class="text-secondary small text-decoration-none">
                <i class="fas fa-arrow-left me-1"></i> Quay lại trang chủ
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>