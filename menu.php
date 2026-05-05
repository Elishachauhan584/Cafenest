<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Menu - CafeNest</title>
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

<div class="stats-bar">
  <div class="stat"><strong>9+</strong><span>Menu Items</span></div>
  <div class="stat-divider"></div>
  <div class="stat"><strong>2.4k</strong><span>Happy Customers</span></div>
  <div class="stat-divider"></div>
  <div class="stat"><strong>4.9★</strong><span>Average Rating</span></div>
</div>

<h2 class="title">Our <span class="highlight">Popular</span> Picks</h2>

<div class="filter-tabs">
  <button class="tab active" onclick="filterMenu('all', this)">All</button>
  <button class="tab" onclick="filterMenu('coffee', this)">Coffee</button>
  <button class="tab" onclick="filterMenu('food', this)">Food</button>
 
</div>

<div class="menu-container" id="menuGrid">

  <div class="menu-card" data-category="coffee">
    <p class="category">HOT COFFEE</p>
    <img src="images/cappuccino.jpg" alt="Cappuccino">
    <h3>Cappuccino</h3>
    <p class="price">₹250</p>
    <button onclick="addToCart('Cappuccino',250)">+</button>
  </div>

  <div class="menu-card" data-category="coffee">
    <p class="category">HOT COFFEE</p>
    <img src="images/mocha.jpg" alt="Mocha">
    <h3>Mocha</h3>
    <p class="price">₹280</p>
    <button onclick="addToCart('Mocha',280)">+</button>
  </div>

  <div class="menu-card" data-category="coffee">
    <p class="category">HOT COFFEE</p>
    <img src="images/latte.jpg" alt="Cafe Latte">
    <h3>Cafe Latte</h3>
    <p class="price">₹260</p>
    <button onclick="addToCart('Cafe Latte',260)">+</button>
  </div>

  <div class="menu-card" data-category="coffee">
    <p class="category">HOT COFFEE</p>
    <img src="images/espresso.jpg" alt="Espresso">
    <h3>Espresso</h3>
    <p class="price">₹200</p>
    <button onclick="addToCart('Espresso',200)">+</button>
  </div>

  <div class="menu-card" data-category="food">
    <p class="category">BAKERY</p>
    <img src="images/bagel.jpg" alt="Classic Cream Cheese Bagel">
    <h3>Classic Cream Cheese Bagel</h3>
    <p class="price">₹220</p>
    <button onclick="addToCart('Classic Cream Cheese Bagel',220)">+</button>
  </div>

  <div class="menu-card" data-category="food">
    <p class="category">BAKERY</p>
    <img src="images/croissant.jpg" alt="Croissant">
    <h3>Croissant</h3>
    <p class="price">₹180</p>
    <button onclick="addToCart('Croissant',180)">+</button>
  </div>

  <div class="menu-card" data-category="food">
    <p class="category">DESSERT</p>
    <img src="images/nutella_cheesecake_cake.jpg" alt="Nutella Cheesecake">
    <h3>Nutella Cheesecake</h3>
    <p class="price">₹320</p>
    <button onclick="addToCart('Nutella Cheesecake',320)">+</button>
  </div>

  <div class="menu-card" data-category="food">
    <p class="category">DESSERT</p>
    <img src="images/belgium_chocolate_cake.jpg" alt="Belgium Chocolate Cake">
    <h3>Belgium Chocolate Cake</h3>
    <p class="price">₹350</p>
    <button onclick="addToCart('Belgium Chocolate Cake',350)">+</button>
  </div>

  <div class="menu-card" data-category="food">
    <p class="category">FOOD</p>
    <img src="images/lasagna.jpg" alt="Lasagna">
    <h3>Lasagna</h3>
    <p class="price">₹400</p>
    <button onclick="addToCart('Lasagna',400)">+</button>
  </div>

  <div class="menu-card" data-category="food">
    <p class="category">FOOD</p>
    <img src="images/spaghetti.jpg" alt="Spaghetti Aglio e Olio">
    <h3>Spaghetti Aglio e Olio</h3>
    <p class="price">₹370</p>
    <button onclick="addToCart('Spaghetti Aglio e Olio',370)">+</button>
  </div>

</div>

<footer class="footer">
  <p>© 2024 CafeNest &nbsp;•&nbsp; Made with ☕ & ❤️</p>
</footer>

<script src="/cafenest/js/main.js"></script>
<script>
function filterMenu(cat, el) {
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  document.querySelectorAll('.menu-card').forEach(card => {
    card.style.display = (cat === 'all' || card.dataset.category === cat) ? 'block' : 'none';
  });
}
</script>
</body>
</html>