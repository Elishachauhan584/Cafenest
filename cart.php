<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Your Cart</h2>
<div id="cart-container"></div>
<h3 id="total">Total: ₹0</h3>

<div style="margin-top:20px;">
  <input type="text" id="cust-name" placeholder="Your name" style="padding:8px; margin:5px; width:200px; display:block;">
  <input type="text" id="cust-phone" placeholder="Your phone" style="padding:8px; margin:5px; width:200px; display:block; margin-top:10px;">
  <button onclick="checkout()" class="btn" style="margin-top:10px;">Checkout</button>
</div>

<script>
let cart = JSON.parse(localStorage.getItem("cart")) || [];

function loadCart() {
  let container = document.getElementById("cart-container");
  let totalEl = document.getElementById("total");
  let total = 0;
  container.innerHTML = "";

  if (cart.length === 0) {
    container.innerHTML = "<p>Your cart is empty. <a href='menu.php'>Go to menu</a></p>";
    totalEl.innerText = "Total: ₹0";
    return;
  }

  cart.forEach((item, index) => {
    total += item.price * item.qty;
    container.innerHTML += `
      <div style="border:1px solid #ccc; padding:10px; margin:10px 0; border-radius:8px;">
        <b>${item.name}</b> — ₹${item.price}
        <button onclick="changeQty(${index}, -1)">-</button>
        <span>${item.qty}</span>
        <button onclick="changeQty(${index}, 1)">+</button>
        <button onclick="removeItem(${index})">Remove</button>
      </div>
    `;
  });

  totalEl.innerText = "Total: ₹" + total;
}

function changeQty(index, change) {
  cart[index].qty += change;
  if (cart[index].qty <= 0) cart.splice(index, 1);
  localStorage.setItem("cart", JSON.stringify(cart));
  loadCart();
}

function removeItem(index) {
  cart.splice(index, 1);
  localStorage.setItem("cart", JSON.stringify(cart));
  loadCart();
}

function checkout() {
  cart = JSON.parse(localStorage.getItem("cart")) || [];

  if (cart.length === 0) {
    alert("Your cart is empty! Add items from menu first.");
    return;
  }

  const name  = document.getElementById("cust-name").value.trim();
  const phone = document.getElementById("cust-phone").value.trim();

  if (!name || !phone) {
    alert("Please enter your name and phone.");
    return;
  }

  fetch("/cafenest/php/order.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ name, phone, cart })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert("Order placed successfully!");
      localStorage.removeItem("cart");
      cart = [];
      window.location.href = "menu.php";
    } else {
      alert("Error: " + data.message);
    }
  })
  .catch(err => {
    console.error(err);
    alert("Something went wrong");
  });
}

loadCart();
</script>
</body>
</html>