let cart = JSON.parse(localStorage.getItem("cart")) || [];

function addToCart(name, price) {
  let item = cart.find(i => i.name === name);
  if (item) {
    item.qty++;
  } else {
    cart.push({ name, price, qty: 1 });
  }
  localStorage.setItem("cart", JSON.stringify(cart));
  alert(name + " added to cart!");
}

function loadCart() {
  let container = document.getElementById("cart-container");
  if (!container) return;
  
  cart = JSON.parse(localStorage.getItem("cart")) || [];
  
  let total = 0;
  container.innerHTML = "";

  if (cart.length === 0) {
    container.innerHTML = "<p>Your cart is empty. Go to menu and add items.</p>";
    document.getElementById("total").innerText = "Total: ₹0";
    return;
  }

  cart.forEach((item, index) => {
    total += item.price * item.qty;
    container.innerHTML += `
      <div class="cart-item">
        <h3>${item.name}</h3>
        <p>₹${item.price}</p>
        <button onclick="changeQty(${index}, -1)">-</button>
        ${item.qty}
        <button onclick="changeQty(${index}, 1)">+</button>
        <button onclick="removeItem(${index})">Remove</button>
      </div>
    `;
  });

  document.getElementById("total").innerText = "Total: ₹" + total;
}

function changeQty(index, change) {
  cart = JSON.parse(localStorage.getItem("cart")) || [];
  cart[index].qty += change;
  if (cart[index].qty <= 0) cart.splice(index, 1);
  localStorage.setItem("cart", JSON.stringify(cart));
  loadCart();
}

function removeItem(index) {
  cart = JSON.parse(localStorage.getItem("cart")) || [];
  cart.splice(index, 1);
  localStorage.setItem("cart", JSON.stringify(cart));
  loadCart();
}

function checkout() {
  cart = JSON.parse(localStorage.getItem("cart")) || [];

  console.log("Cart at checkout:", cart);

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

  const payload = { name: name, phone: phone, cart: cart };
  console.log("Sending payload:", JSON.stringify(payload));

  fetch("/cafenest/php/order.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload)
  })
  .then(res => res.json())
  .then(data => {
    console.log("Response:", data);
    if (data.success) {
      alert("Order placed successfully!");
      localStorage.removeItem("cart");
      cart = [];
      location.reload();
    } else {
      alert("Error: " + data.message);
    }
  })
  .catch(err => {
    console.error(err);
    alert("Something went wrong");
  });
}