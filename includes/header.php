<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous" />
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>

  <link rel="stylesheet" href="/Project/assets/css/header.css" />
  <link rel="stylesheet" href="/Project/assets/css/style.css" />
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid px-4">
      <!-- nav-left -->
      <div class="d-flex align-items-center me-auto">
        <button class="btn btn-outline-light me-3 btn-sm">☰ Danh mục</button>
        <a class="navbar-brand fw-bold" href="/Project/index.php">MINIMART</a>
      </div>

      <!-- nav-middle -->
      <div class="flex-grow-1 d-flex justify-content-center mx-4">
        <form class="d-flex w-100" style="max-width: 500px; position: relative">
          <input
            class="form-control rounded-pill pe-5"
            type="search"
            placeholder="Tìm kiếm sản phẩm..." />
          <button
            class="btn btn-warning rounded-circle position-absolute end-0"
            type="submit"
            style="height: 38px; width: 38px; top: 0">
            🔍
          </button>
        </form>
      </div>

      <!-- nav-right -->
      <div class="d-flex align-items-center ms-auto">
        <!-- <a class="nav-link text-white me-3" href="#">Trang Chủ</a>
        <a class="btn btn-outline-light btn-sm" href="/Project/manager/dang-nhap.php">Đăng nhập</a> -->
        <a href="#" class="nav-link">Trang Chủ</a>

        <?php if (isset($_SESSION['user_id'])): ?>
          <div class="user-box">
            <span class="welcome-text">Chào, <a href="#" class="user-name"><?php echo $_SESSION['ho_ten']; ?></a></span>

            <?php if ($_SESSION['vai_tro'] == 'admin'): ?>
              <a href="/test_project/admin/index.php" class="role-link admin-link">[Quản trị Admin]</a>
            <?php elseif ($_SESSION['vai_tro'] == 'nhan_vien'): ?>
              <a href="/test_project/nhan-vien/index.php" class="role-link staff-link">[Nhân viên]</a>
            <?php else: ?>
              <a href="#" class="nav-link">🛒 Giỏ hàng</a>
              <a href="#" class="nav-link">Lịch sử</a>
            <?php endif; ?>

            <a href="/Project/manager/dang-xuat.php" class="btn-logout" onclick="return confirm('Bạn muốn thoát?')">Thoát</a>
          </div>
        <?php else: ?>
          <a href="/Project/manager/dang-nhap.php" class="nav-link">Đăng nhập</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
</body>

</html>