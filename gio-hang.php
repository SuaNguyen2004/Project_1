<?php
require_once 'config/db.php';
require_once 'includes/function.php';

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
  $id = $_GET['id'];
  if (isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
  }
  header("Location: gio-hang.php");
  exit();
}

include 'includes/header.php';
?>

<style>
  body {
    background-color: #f8f9fa;
    padding-top: 100px !important;
  }

  .cart-table-img {
    width: 80px;
    height: 80px;
    object-fit: contain;
  }

  .table middle td,
  .table middle th {
    vertical-align: middle;
  }

  .summary-card {
    border: none;
    border-radius: 15px;
    background-color: #fff;
  }
</style>

<div class="container py-5" style="margin-top: 100px;">
  <div class="d-flex align-items-center mb-4">
    <h2 class="fw-bold mb-0"><i class="fas fa-shopping-cart text-warning me-3"></i>Giỏ hàng của bạn</h2>
  </div>

  <?php if (empty($_SESSION['cart'])): ?>
    <div class="text-center py-5 shadow-sm bg-white rounded-4">
      <p class="fs-5 text-muted">Giỏ hàng của bạn đang trống kìa bạn hãy mua gì đó đi.</p>
      <a href="index.php" class="btn btn-warning px-4 py-2 mt-2">
        <i class="fas fa-arrow-left me-2" style="color: #000"></i>Tiếp tục mua sắm
      </a>
    </div>
  <?php else: ?>
    <div class="row g-4">
      <!-- Danh sách sản phẩm -->
      <div class="col-lg-8">
        <div class="table-responsive shadow-sm bg-white rounded-4 p-3">
          <table class="table align-middle mb-0">
            <thead class="table-light text-secondary">
              <tr>
                <th>Sản phẩm</th>
                <th class="text-center">Giá</th>
                <th class="text-center">Số lượng</th>
                <th class="text-end">Thành tiền</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $total = 0;
              foreach ($_SESSION['cart'] as $item):
                $subtotal = $item['gia'] * $item['so_luong'];
                $total += $subtotal;
              ?>
                <tr>
                  <td>
                    <div class="d-flex align-items-center">
                      <img src="assets/images/<?php echo $item['anh']; ?>" class="cart-table-img rounded-3 border me-3">
                      <div class="fw-bold text-dark text-truncate" style="max-width: 150px;">
                        <?php echo $item['ten']; ?>
                      </div>
                    </div>
                  </td>
                  <td class="text-center text-muted"><?php echo formatMoney($item['gia']); ?></td>
                  <td class="text-center">
                    <span class="badge bg-light text-dark border px-3 py-2 fw-bold"><?php echo $item['so_luong']; ?></span>
                  </td>
                  <td class="text-end fw-bold text-danger"><?php echo formatMoney($subtotal); ?></td>
                  <td class="text-end">
                    <a href="gio-hang.php?action=delete&id=<?php echo $item['id']; ?>"
                      onclick="return confirm('Xóa sản phẩm này khỏi giỏ?')"
                      class="btn btn-outline-warning border-0">
                      <i class="fas fa-trash-alt"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="mt-4">
          <a href="index.php" class="text-decoration-none text-secondary fw-bold">
            <i class="fas fa-chevron-left me-2"></i>Tiếp tục chọn thêm sản phẩm
          </a>
        </div>
      </div>

      <!-- Tóm tắt đơn hàng -->
      <div class="col-lg-4">
        <div class="card summary-card shadow-sm p-3">
          <div class="card-body">
            <h5 class="card-title fw-bold mb-4">Tạm tính</h5>
            <div class="d-flex justify-content-between mb-3">
              <span class="fw-bold">Tổng tiền hàng</span>
              <span class="fw-bold"><?php echo formatMoney($total); ?></span>
            </div>
            <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
              <span class="text-success fw-bold">Phí vận chuyển sẽ được tính ở trang thanh toán</span>
            </div>
            <a href="thanh-toan.php" class="btn btn-warning w-100 py-3 text-uppercase fw-bold rounded-3 shadow-sm">
              Tiến hành thanh toán <i class="fas fa-chevron-right ms-2" style="color: #000"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>