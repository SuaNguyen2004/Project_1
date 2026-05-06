<?php
require_once '../config/db.php';
require_once '../includes/function.php'; // Đảm bảo đã có session_start() bên trong

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = trim($_POST['username']);
  $fullname = trim($_POST['fullname']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = 'khach_hang';

  try {
    $sql = "INSERT INTO nguoi_dung (ten_dang_nhap, mat_khau, ho_ten, vai_tro) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $password, $fullname, $role]);
    $success = "Đăng ký thành công! <a href='dang-nhap.php' class='fw-bold text-decoration-none'>Đăng nhập ngay</a>";
  } catch (PDOException $e) {
    $error = "Lỗi: Tên đăng nhập có thể đã tồn tại trong hệ thống.";
  }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký thành viên - MINIMART</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="/Project/assets/css/dang-nhap.css">
</head>

<body class="d-flex align-items-center min-vh-100">

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-5">
        <div class="card auth-card shadow-lg p-4 mx-auto">
          <div class="card-body">
            <div class="text-center mb-4">
              <h2 class="fw-bold text-uppercase">Tạo Tài Khoản</h2>
              <p class="small">Hệ thống quản lý MINIMART</p>
            </div>

            <!-- Thông báo lỗi -->
            <?php if ($error): ?>
              <div class="alert alert-danger d-flex align-items-center py-2" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> <?php echo $error; ?>
              </div>
            <?php endif; ?>

            <!-- Thông báo thành công -->
            <?php if ($success): ?>
              <div class="alert alert-success py-2 px-3 small border-0 mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i> <?php echo $success; ?>
              </div>
            <?php endif; ?>

            <form method="POST">
              <div class="mb-3">
                <label class="form-label fw-bold small">Tên đăng nhập</label>
                <div class="input-group shadow-sm">
                  <span class="input-group-text bg-white"><i class="fas fa-user"></i></span>
                  <input type="text" name="username" class="form-control border-start-0"
                    placeholder="Nhập tên đăng nhập mong muốn" required>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label fw-bold small">Họ và tên đầy đủ</label>
                <div class="input-group shadow-sm">
                  <span class="input-group-text bg-white"><i class="fas fa-id-card"></i></span>
                  <input type="text" name="fullname" class="form-control border-start-0"
                    placeholder="Nhập họ tên của bạn" required>
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label fw-bold small">Mật khẩu</label>
                <div class="input-group shadow-sm">
                  <span class="input-group-text bg-white"><i class="fas fa-lock"></i></span>
                  <input type="password" name="password" class="form-control border-start-0"
                    placeholder="Nhập mật khẩu của bạn" required>
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-auth w-100 py-2 fw-bold mb-3 text-uppercase">
                đăng ký tài khoản <i class="fas fa-user-plus ms-2"></i>
              </button>
            </form>

            <div class="text-center mt-3 border-top pt-3">
              <p class="small mb-1">
                Nếu đã có tài khoản?
                <a href="dang-nhap.php" class="text-decoration-none fw-bold" style="color: #e57a8c;">Đăng nhập ngay</a>
              </p>
              <div class="mt-3">
                <a href="../index.php" class="text-secondary small text-decoration-none">
                  <i class="fas fa-arrow-left me-1"></i> Quay lại trang chủ
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>