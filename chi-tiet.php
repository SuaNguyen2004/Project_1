<?php
require_once 'config/db.php';
require_once 'includes/function.php';
include 'includes/header.php';

// 1. Lấy thông tin sản phẩm hiện tại
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT sp.*, dm.ten_danh_muc FROM san_pham sp JOIN danh_muc dm ON sp.danh_muc_id = dm.id WHERE sp.id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
  die("<div class='container py-5 mt-5'><div class='alert alert-danger'>Sản phẩm không tồn tại!</div></div>");
}

// 2. Lấy sản phẩm liên quan
$stmt_related = $pdo->prepare("SELECT * FROM san_pham WHERE danh_muc_id = ? AND id != ? ORDER BY RAND() LIMIT 4");
$stmt_related->execute([$product['danh_muc_id'], $id]);
$related_products = $stmt_related->fetchAll();
?>

<link rel="stylesheet" href="/Project/assets/css/chi-tiet.css">

<div class="container py-4">
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Trang chủ</a></li>
      <li class="breadcrumb-item active"><?php echo htmlspecialchars($product['ten_danh_muc']); ?></li>
    </ol>
  </nav>

  <div class="row g-5 bg-white rounded-4 shadow-sm p-3 p-md-5 mx-0">
    <!-- Ảnh sản phẩm -->
    <div class="col-md-5 text-center bg-light rounded-4 p-4 d-flex align-items-center justify-content-center">
      <img src="assets/images/<?php echo $product['anh']; ?>"
        class="img-fluid product-img-main"
        alt="<?php echo htmlspecialchars($product['ten_san_pham']); ?>">
    </div>

    <!-- Thông tin Chi tiết sản phẩm -->
    <div class="col-md-7">
      <span class="category-badge d-inline-block mb-3">
        <i class="fas fa-tag me-2"></i><?php echo htmlspecialchars($product['ten_danh_muc']); ?>
      </span>
      <h1 class="display-5 fw-bold text-dark mb-2"><?php echo htmlspecialchars($product['ten_san_pham']); ?></h1>
      <div class="h2 fw-bold mb-4" style="color: #e57a8c"><?php echo formatMoney($product['gia_ban']); ?></div>

      <div class="p-3 bg-light rounded-3 mb-4 border-start border-4 border-success">
        <h6 class="fw-bold"><i class="fas fa-info-circle me-2"></i>Mô tả sản phẩm:</h6>
        <p class="text-muted mb-0"><?php echo nl2br(htmlspecialchars($product['mo_ta'])); ?></p>
      </div>

      <p class="mb-4">
        <strong>Trạng thái: </strong>
        <?php if ($product['so_luong_kho'] > 0): ?>
          <span class="text-success fw-bold"><i class="fas fa-check-circle me-1"></i>Còn hàng (Kho: <?php echo $product['so_luong_kho']; ?>)</span>
        <?php else: ?>
          <span class="text-danger fw-bold"><i class="fas fa-times-circle me-1"></i>Hết hàng</span>
        <?php endif; ?>
      </p>

      <?php if ($product['so_luong_kho'] > 0): ?>
        <form action="them-vao-gio.php" method="POST" class="row g-3 align-items-end">
          <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

          <div class="col-auto">
            <label class="form-label fw-bold small">Số lượng mua:</label>
            <div class="input-group" style="width: 140px;">
              <button class="btn btn-outline-secondary" type="button" onclick="changeQty(-1)">-</button>
              <input type="number" name="so_luong" id="input-qty" class="form-control text-center fw-bold bg-light"
                value="1" min="1" max="<?php echo $product['so_luong_kho']; ?>" oninput="validateInput(this)">
              <button class="btn btn-outline-secondary" type="button" onclick="changeQty(1)">+</button>
            </div>
          </div>

          <div class="col-12 col-lg-6">
            <button type="submit" class="btn btn-danger btn-lg w-100 fw-bold rounded-3" style="background-color: #e57a8c;">
              <i class="fas fa-shopping-cart me-2 text-white"></i>THÊM VÀO GIỎ HÀNG
            </button>
          </div>
        </form>
      <?php else: ?>
        <button class="btn btn-secondary btn-lg w-100 py-3 fw-bold" disabled>LIÊN HỆ KHI CÓ HÀNG</button>
      <?php endif; ?>
    </div>
  </div>

  <!--Hiển thị Sản phẩm cùng loại -->
  <?php if (count($related_products) > 0): ?>
    <div class="mt-5 pt-5 bg-light text-center">
      <h3 class="fw-bold mb-4 position-relative pb-2 " style="border-bottom: 3px solid #e57a8c; width: fit-content;">
        Sản phẩm cùng danh mục
      </h3>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
        <?php foreach ($related_products as $item): ?>
          <div class="col">
            <a href="chi-tiet.php?id=<?php echo $item['id']; ?>" class="card h-100 text-decoration-none related-card shadow-sm border-0 rounded-3">
              <div class="p-3 text-center">
                <img src="assets/images/<?php echo $item['anh']; ?>" class="img-fluid" alt="...">
              </div>
              <div class="card-body">
                <h6 class="card-title text-dark fw-bold mb-2 text-truncate"><?php echo htmlspecialchars($item['ten_san_pham']); ?></h6>
                <div class="text-danger fw-bold"><?php echo formatMoney($item['gia_ban']); ?></div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
</div>

<script>
  function changeQty(amount) {
    const input = document.getElementById('input-qty');
    const max = parseInt(input.getAttribute('max'));
    let current = parseInt(input.value) || 1;
    current += amount;
    if (current < 1) current = 1;
    if (current > max) {
      alert("Rất tiếc, trong kho chỉ còn " + max + " sản phẩm!");
      current = max;
    }
    input.value = current;
  }

  function validateInput(input) {
    const max = parseInt(input.getAttribute('max'));
    let val = parseInt(input.value);
    if (val > max) {
      alert("Trong kho chỉ còn " + max + " sản phẩm!");
      input.value = max;
    }
    if (val < 1 || isNaN(val)) input.value = 1;
  }
</script>

<?php include 'includes/footer.php'; ?>