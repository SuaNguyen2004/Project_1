<?php
require_once 'config/db.php';
require_once 'includes/function.php';

include 'includes/header.php';

$search = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;

if ($category_id > 0) {
  $sql_cate = "SELECT * FROM danh_muc WHERE id = ?";
  $stmt_cate = $pdo->prepare($sql_cate);
  $stmt_cate->execute([$category_id]);
  $categories = $stmt_cate->fetchAll();
} else {
  $sql_cate = "SELECT DISTINCT dm.* FROM danh_muc dm 
                 JOIN san_pham sp ON dm.id = sp.danh_muc_id 
                 WHERE sp.ten_san_pham LIKE ? ORDER BY dm.id ASC";
  $stmt_cate = $pdo->prepare($sql_cate);
  $stmt_cate->execute(["%$search%"]);
  $categories = $stmt_cate->fetchAll();
}
?>

<link rel="stylesheet" href="/Project/assets/css/index.css">

<div class="container pb-5 bg-light" style="margin-top: 100px;">
  <!-- Danh sách sản phẩm -->
  <div class="text-center my-5">
    <h2 class="fw-bold display-6" style="color: #2c3e50;">
      <?php
      if ($search) echo "KẾT QUẢ TÌM KIẾM: \"" . htmlspecialchars($search) . "\"";
      elseif ($category_id && isset($categories[0])) echo "DANH MỤC: " . $categories[0]['ten_danh_muc'];
      else echo "DANH SÁCH SẢN PHẨM";
      ?>
    </h2>
  </div>

  <?php if (empty($categories)): ?>
    <div class="alert alert-light shadow-sm text-center py-5">
      <i class="fas fa-search fa-3x mb-3 text-muted"></i>
      <p class="fs-5 text-secondary">Rất tiếc, chúng tôi không tìm thấy sản phẩm nào phù hợp.</p>
      <a href="index.php" class="btn btn-outline-primary rounded-pill px-4">Xem tất cả sản phẩm</a>
    </div>
  <?php endif; ?>

  <!-- Duyệt qua từng danh mục -->
  <?php foreach ($categories as $cat): ?>
    <div class="d-flex align-items-center mb-4 mt-5">
      <h3 class="category-title h4 mb-0"><?php echo $cat['ten_danh_muc']; ?></h3>
      <div class="flex-grow-1 ms-4 border-top opacity-25"></div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <?php
      // Lấy tối đa 4 sản phẩm nếu là trang chủ, lấy hết nếu chọn danh mục
      $limit = ($category_id > 0) ? "" : "LIMIT 4";
      $sql_sp = "SELECT * FROM san_pham WHERE danh_muc_id = ? AND ten_san_pham LIKE ? ORDER BY id DESC $limit";
      $stmt_sp = $pdo->prepare($sql_sp);
      $stmt_sp->execute([$cat['id'], "%$search%"]);

      while ($row = $stmt_sp->fetch()):
      ?>
        <div class="col">
          <div class="card h-100 product-card shadow-sm rounded-3">
            <!-- Hình ảnh sản phẩm -->
            <a href="chi-tiet.php?id=<?php echo $row['id']; ?>" class="product-img-box">
              <img src="assets/images/<?php echo $row['anh']; ?>" alt="<?php echo $row['ten_san_pham']; ?>">
            </a>

            <div class="card-body d-flex flex-column">
              <a href="chi-tiet.php?id=<?php echo $row['id']; ?>" class="text-decoration-none">
                <h5 class="card-title fs-6 text-dark fw-bold mb-2" style="height: 40px; overflow: hidden;">
                  <?php echo htmlspecialchars($row['ten_san_pham']); ?>
                </h5>
              </a>

              <p class="fs-5 fw-bold text-danger mb-3">
                <?php echo formatMoney($row['gia_ban']); ?>
              </p>

              <!-- Nút thêm vào giỏ hàng -->
              <form action="them-vao-gio.php" method="POST" class="mt-auto">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="so_luong" value="1">
                <button type="submit" class="btn btn-buy w-100 py-2 d-flex justify-content-between align-items-center px-3">
                  <span>THÊM VÀO GIỎ</span>
                  <i class="fas fa-cart-plus"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php endforeach; ?>
</div>

<?php

include 'includes/footer.php';
?>