<!doctype html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>MINIMART - Tạp Hóa Thông Minh</title>
  <!-- Bootstrap 5 & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- CSS Tùy chỉnh (Đường dẫn từ gốc dự án) -->
  <link rel="stylesheet" href="/Project/assets/css/header.css" />
  <link rel="stylesheet" href="/Project/assets/css/style.css" />
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #2c3e50;">
    <div class="container-fluid px-4">
      <div class="d-flex align-items-center me-auto">
        <button class="btn btn-outline-light me-3 btn-sm">☰ Danh mục</button>
        <a class="navbar-brand fw-bold" href="index.php">MINIMART</a>
      </div>
      <div class="flex-grow-1 d-flex justify-content-center mx-4">
        <form action="index.php" method="GET" class="d-flex w-100" style="max-width: 500px; position: relative">
          <input class="form-control rounded-pill pe-5" name="keyword" type="search" placeholder="Tìm kiếm sản phẩm...">
          <button class="btn btn-warning rounded-circle position-absolute end-0" type="submit" style="height: 38px; width: 38px; top: 0">🔍</button>
        </form>
      </div>
      <div class="d-flex align-items-center ms-auto">
        <a class="nav-link text-white me-3" href="index.php">Trang Chủ</a>
        <a class="btn btn-outline-light btn-sm" href="manager/dang-nhap.php">Đăng nhập</a>
      </div>
    </div>
  </nav>