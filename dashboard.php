<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$conn = new mysqli("localhost", "root", "", "cafenest_db", 3307);

if ($conn->connect_error) {
    die("❌ DB Error: " . $conn->connect_error);
}

// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $oid    = intval($_POST['order_id']);
    $status = $_POST['status'];
    $allowed = ['pending','preparing','ready','delivered','cancelled'];
    if (in_array($status, $allowed)) {
        $conn->query("UPDATE orders SET status='$status' WHERE id=$oid");
    }
    header('Location: dashboard.php');
    exit();
}

// Live stats
$total_orders  = $conn->query("SELECT COUNT(*) FROM orders")->fetch_row()[0] ?? 0;
$today_orders  = $conn->query("SELECT COUNT(*) FROM orders WHERE DATE(created_at)=CURDATE()")->fetch_row()[0] ?? 0;
$today_revenue = $conn->query("SELECT COALESCE(SUM(total),0) FROM orders WHERE DATE(created_at)=CURDATE()")->fetch_row()[0] ?? 0;
$pending_count = $conn->query("SELECT COUNT(*) FROM orders WHERE status='pending'")->fetch_row()[0] ?? 0;

// All orders
$orders_result = $conn->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 50");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - CafeNest</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Poppins', sans-serif; background: #faf4ec; color: #2c1a0e; }
.sidebar { position: fixed; top: 0; left: 0; width: 240px; height: 100vh; background: #3b1f0e; padding: 30px 20px; display: flex; flex-direction: column; gap: 8px; z-index: 100; }
.sidebar-logo { font-size: 20px; color: #f5c97a; font-weight: 700; margin-bottom: 30px; text-align: center; }
.sidebar a { display: flex; align-items: center; gap: 12px; text-decoration: none; color: #e8d5b7; font-size: 14px; font-weight: 500; padding: 12px 16px; border-radius: 12px; transition: 0.2s; }
.sidebar a:hover, .sidebar a.active { background: #c07a2c; color: white; }
.sidebar .logout { margin-top: auto; color: #ff8888; }
.sidebar .logout:hover { background: #c0392b; color: white; }
.main { margin-left: 240px; padding: 40px; min-height: 100vh; }
.top-bar { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 36px; flex-wrap: wrap; gap: 12px; }
.top-bar h1 { font-size: 26px; color: #1a0e05; margin-bottom: 4px; }
.top-bar p { color: #9a7a5a; font-size: 14px; }
.refresh-btn { background: #3b1f0e; color: white; border: none; padding: 10px 20px; border-radius: 25px; font-size: 13px; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif; }
.refresh-btn:hover { background: #c07a2c; }
.cards-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px,1fr)); gap: 20px; margin-bottom: 40px; }
.dash-card { background: white; border-radius: 18px; padding: 24px; box-shadow: 0 4px 18px rgba(107,62,38,0.08); border: 1px solid #f0e8dc; }
.dash-card .icon { font-size: 28px; margin-bottom: 12px; }
.dash-card .number { font-size: 32px; font-weight: 700; color: #3b1f0e; margin-bottom: 4px; }
.dash-card .label { font-size: 13px; color: #9a7a5a; }
.dash-card.gold  { border-top: 4px solid #f5c97a; }
.dash-card.brown { border-top: 4px solid #c07a2c; }
.dash-card.green { border-top: 4px solid #4caf50; }
.dash-card.red   { border-top: 4px solid #e74c3c; }
.section-title { font-size: 18px; font-weight: 600; color: #1a0e05; margin-bottom: 18px; display: flex; justify-content: space-between; align-items: center; }
.section-title span { font-size: 13px; color: #9a7a5a; font-weight: 400; }
.table-wrap { background: white; border-radius: 18px; padding: 28px; box-shadow: 0 4px 18px rgba(107,62,38,0.08); border: 1px solid #f0e8dc; overflow-x: auto; margin-bottom: 40px; }
table { width: 100%; border-collapse: collapse; min-width: 700px; }
th { text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: .8px; color: #9a7a5a; padding: 0 16px 14px; font-weight: 600; }
td { padding: 14px 16px; font-size: 13px; border-top: 1px solid #faf4ec; }
tr:hover td { background: #fffdf9; }
.order-id { font-weight: 700; color: #c07a2c; }
.items-cell { max-width: 200px; color: #9a7a5a; font-size: 12px; }
.badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.badge-pending   { background: #fef3c7; color: #92400e; }
.badge-preparing { background: #dbeafe; color: #1e40af; }
.badge-ready     { background: #d1fae5; color: #065f46; }
.badge-delivered { background: #f1f5f9; color: #475569; }
.badge-cancelled { background: #fee2e2; color: #dc2626; }
.status-form { display: flex; gap: 6px; align-items: center; }
.status-select { padding: 5px 10px; border-radius: 20px; border: 1px solid #e8d5b7; font-size: 12px; cursor: pointer; font-family: 'Poppins', sans-serif; background: white; outline: none; }
.save-btn { background: #3b1f0e; color: white; border: none; padding: 5px 13px; border-radius: 20px; font-size: 11px; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif; }
.save-btn:hover { background: #c07a2c; }
.empty-state { text-align: center; padding: 50px; color: #9a7a5a; }
.empty-state .e-icon { font-size: 44px; margin-bottom: 14px; }
.quick-title { font-size: 18px; font-weight: 600; color: #1a0e05; margin-bottom: 16px; }
.quick-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px,1fr)); gap: 16px; }
.quick-card { background: white; border-radius: 16px; padding: 22px 18px; text-align: center; border: 1px solid #f0e8dc; box-shadow: 0 4px 14px rgba(107,62,38,0.07); text-decoration: none; color: #1a0e05; transition: transform 0.2s, box-shadow 0.2s; display: block; }
.quick-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(107,62,38,0.14); color: #c07a2c; }
.quick-card .q-icon { font-size: 30px; margin-bottom: 10px; }
.quick-card .q-label { font-size: 13px; font-weight: 600; }
</style>
</head>
<body>

<div class="sidebar">
  <div class="sidebar-logo">☕ CafeNest</div>
  <a href="dashboard.php" class="active">🏠 Dashboard</a>
  <a href="../menu.php">📋 View Menu</a>
  <a href="../cart.php">🛒 View Cart</a>
  <a href="../index.php">🌐 View Website</a>
  <a href="logout.php" class="logout">🚪 Logout</a>
</div>

<div class="main">

  <div class="top-bar">
    <div>
      <h1>Welcome Back, Admin 👋</h1>
      <p>Here's what's happening at CafeNest — <?= date('D, d M Y') ?></p>
    </div>
    <button class="refresh-btn" onclick="location.reload()">↻ Refresh</button>
  </div>

  <!-- LIVE STAT CARDS -->
  <div class="cards-grid">
    <div class="dash-card gold">
      <div class="icon">🛒</div>
      <div class="number"><?= $total_orders ?></div>
      <div class="label">Total Orders</div>
    </div>
    <div class="dash-card brown">
      <div class="icon">📅</div>
      <div class="number"><?= $today_orders ?></div>
      <div class="label">Orders Today</div>
    </div>
    <div class="dash-card green">
      <div class="icon">💰</div>
      <div class="number">₹<?= number_format($today_revenue) ?></div>
      <div class="label">Revenue Today</div>
    </div>
    <div class="dash-card red">
      <div class="icon">⏳</div>
      <div class="number"><?= $pending_count ?></div>
      <div class="label">Pending Orders</div>
    </div>
  </div>

  <!-- LIVE ORDERS TABLE -->
  <div class="section-title">
    Recent Orders
    <span>Latest 50 orders</span>
  </div>

  <div class="table-wrap">
    <?php if ($orders_result->num_rows === 0): ?>
      <div class="empty-state">
        <div class="e-icon">📋</div>
        <p style="font-size:16px; margin-bottom:8px;">No orders yet!</p>
        <p style="font-size:13px;">When customers place orders they will appear here.</p>
      </div>
    <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Customer</th>
          <th>Phone</th>
          <th>Items</th>
          <th>Total</th>
          <th>Status</th>
          <th>Time</th>
          <th>Update</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($order = $orders_result->fetch_assoc()):
          $items_arr = json_decode($order['items'], true) ?: [];
          $item_list = implode(', ', array_map(function($i) {
              return ($i['name'] ?? 'Item') . ' x' . ($i['qty'] ?? 1);
          }, $items_arr));
          $badge_map = [
            'pending'   => 'badge-pending',
            'preparing' => 'badge-preparing',
            'ready'     => 'badge-ready',
            'delivered' => 'badge-delivered',
            'cancelled' => 'badge-cancelled',
          ];
          $badge_cls = $badge_map[$order['status']] ?? 'badge-pending';
        ?>
        <tr>
          <td class="order-id">#CN<?= str_pad($order['id'], 4, '0', STR_PAD_LEFT) ?></td>
          <td style="font-weight:500"><?= htmlspecialchars($order['customer_name']) ?></td>
          <td><?= htmlspecialchars($order['phone']) ?></td>
          <td class="items-cell"><?= htmlspecialchars($item_list) ?></td>
          <td style="font-weight:700; color:#c07a2c;">₹<?= number_format($order['total']) ?></td>
          <td><span class="badge <?= $badge_cls ?>"><?= ucfirst($order['status']) ?></span></td>
          <td style="color:#9a7a5a; font-size:12px;"><?= date('d M, h:i A', strtotime($order['created_at'])) ?></td>
          <td>
            <form method="POST" class="status-form">
              <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
              <select name="status" class="status-select">
                <option value="pending"   <?= $order['status']==='pending'   ? 'selected':'' ?>>⏳ Pending</option>
                <option value="preparing" <?= $order['status']==='preparing' ? 'selected':'' ?>>🔥 Preparing</option>
                <option value="ready"     <?= $order['status']==='ready'     ? 'selected':'' ?>>✅ Ready</option>
                <option value="delivered" <?= $order['status']==='delivered' ? 'selected':'' ?>>🚀 Delivered</option>
                <option value="cancelled" <?= $order['status']==='cancelled' ? 'selected':'' ?>>❌ Cancelled</option>
              </select>
              <button type="submit" class="save-btn">Save</button>
            </form>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>

  <!-- QUICK LINKS -->
  <p class="quick-title">Quick Actions</p>
  <div class="quick-grid">
    <a href="../menu.php"  class="quick-card"><div class="q-icon">📋</div><div class="q-label">View Menu</div></a>
    <a href="../cart.php"  class="quick-card"><div class="q-icon">🛒</div><div class="q-label">View Cart</div></a>
    <a href="../index.php" class="quick-card"><div class="q-icon">🌐</div><div class="q-label">Live Website</div></a>
    <a href="logout.php"   class="quick-card"><div class="q-icon">🚪</div><div class="q-label">Logout</div></a>
  </div>

</div>
</body>
</html>
<?php $conn->close(); ?>