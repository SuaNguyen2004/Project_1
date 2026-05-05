<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<!doctype html>
<html lang="vn">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

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
  <nav class="navbar navbar-expand-lg navbar-dark shadow-sm fixed-top">
    <div class="container-fluid px-4">
      <!-- nav-left -->
      <div class="d-flex align-items-center me-auto">
        <button class="btn btn-light me-3 btn-sm"><i class="fa-solid fa-align-justify text-black"></i> Danh mục</button>
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
            style="height: 35px; width: 35px; top: 0">
            <i class="fas fa-search"></i>
          </button>
        </form>
      </div>

      <!-- nav-right -->
      <div class="d-flex align-items-center ms-auto gap-3">
        <!-- Trang Chủ -->
        <a href="index.php" class="nav-link text-white "><i class="fa-solid fa-house me-2 text-white"></i></i>Trang Chủ</a>

        <?php if (isset($_SESSION['user_id'])): ?>
          <!-- Hiển thị tên người dùng (Màu vàng theo mẫu) -->
          <div class="text-warning fw-bold d-flex flex-column lh-sm">
            <small class="text-white fw-normal">Chào,</small>
            <span><?php echo $_SESSION['ho_ten']; ?></span>
          </div>

          <!-- Giỏ hàng -->
          <a href="gio-hang.php" class="nav-link text-white d-flex align-items-center">
            <i class="fa-solid fa-cart-shopping me-2 text-white"></i>Giỏ hàng
          </a>

          <!-- Lịch sử -->
          <a href="lich-su.php" class="nav-link text-white d-flex align-items-center">
            <i class="fa-solid fa-clock-rotate-left me-2 text-white"></i>Lịch sử
          </a>

          <!-- Nút Thoát (Border trắng theo mẫu) -->
          <a href="manager/dang-xuat.php"
            class="btn btn-light btn-sm px-3"
            onclick="return confirm('Bạn muốn thoát?')">Thoát</a>

        <?php else: ?>
          <!-- Nếu chưa đăng nhập -->
          <a href="manager/dang-nhap.php" class="btn btn-light btn-sm px-4">Đăng nhập</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>
</body>

</html>