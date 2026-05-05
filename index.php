<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CafeNest</title>
<link rel="stylesheet" href="css/style.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<header class="navbar">
  <h2 class="logo">☕ CafeNest</h2>
  <nav>
    <a href="index.php">Home</a>
    <a href="menu.php">Menu</a>
    <a href="cart.php">Cart</a>
  </nav>
  <a href="cart.php" class="btn-nav">Order Now</a>
</header>

<section class="hero">
  <div class="hero-left">
    <p class="tag">✦ EST. 2026 &nbsp;•&nbsp; FRESH DAILY</p>
    <h1>Where Every Cup <br> Tells a <span>Story</span></h1>
    <p class="hero-sub">Handcrafted beverages, artisan pastries, and a warm atmosphere where time slows down. Your neighbourhood nest, reimagined.</p>
    <div class="buttons">
      <a href="menu.php" class="btn-primary">Explore Our Menu</a>
      <a href="admin/login.php" class="btn-outline">Admin Panel →</a>
    </div>
  </div>

  <div class="hero-right">

    <div class="product-card">
      <div class="badge">⭐ 4.9 &nbsp;<small>Top Pick</small></div>
      <div class="product-img-box">
        <img src="images/latte.jpg" alt="Signature Latte">
      </div>
      <h3>Latte</h3>
      <p class="product-desc">Velvety espresso with steamed oat milk and a hint of vanilla bean.</p>
      <div class="product-footer">
        <span><span class="live-dot"></span>12 orders today</span>
        <button onclick="addToCart('Signature Latte',320)">Add to Cart</button>
      </div>
    </div>

    <div class="product-card card-small">
      <div class="badge">🥐 Bestseller</div>
      <div class="product-img-box">
        <img src="images/croissant.jpg" alt="Croissant">
      </div>
      <h3> Croissant</h3>
      <p class="product-desc">Flaky, golden, baked fresh every morning.</p>
      <div class="product-footer">
        <span><span class="live-dot"></span>₹180</span>
        <button onclick="addToCart('Butter Croissant',180)">Add to Cart</button>
      </div>
    </div>

    <div class="product-card card-small">
      <div class="badge">☕ Fan Favourite</div>
      <div class="product-img-box">
        <img src="images/cappuccino.jpg" alt="Cappuccino">
      </div>
      <h3>Cappuccino</h3>
      <p class="product-desc">Perfectly balanced espresso with velvety foam on top.</p>
      <div class="product-footer">
        <span><span class="live-dot"></span>₹250</span>
        <button onclick="addToCart('Cappuccino',250)">Add to Cart</button>
      </div>
    </div>

  </div>
</section>

<div class="stats-bar">
  <div class="stat"><strong>9+</strong><span>Menu Items</span></div>
  <div class="stat-divider"></div>
  <div class="stat"><strong>2.4k</strong><span>Happy Customers</span></div>
  <div class="stat-divider"></div>
  <div class="stat"><strong>4.9★</strong><span>Average Rating</span></div>
</div>

<footer class="footer">
  <p>© 2026 CafeNest &nbsp;•&nbsp; Made with ☕ & ❤️</p>
</footer>

<script src="js/main.js"></script>
</body>
</html>