<?php
session_start();
if(isset($_SESSION['admin'])) {
  header('Location: dashboard.php');
  exit();
}

$error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user = $_POST['username'];
  $pass = $_POST['password'];
  
  // Change these credentials to whatever you want
  if($user === 'admin' && $pass === 'cafe123') {
    $_SESSION['admin'] = true;
    header('Location: dashboard.php');
    exit();
  } else {
    $error = 'Wrong username or password!';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login - CafeNest</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
  font-family: 'Poppins', sans-serif;
  background: #faf4ec;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}
.login-box {
  background: white;
  padding: 50px 40px;
  border-radius: 20px;
  box-shadow: 0 10px 40px rgba(107,62,38,0.15);
  width: 100%;
  max-width: 400px;
  border: 1px solid #f0e8dc;
  text-align: center;
}
.login-box h2 {
  font-size: 14px;
  color: #c07a2c;
  letter-spacing: 2px;
  margin-bottom: 8px;
}
.login-box h1 {
  font-size: 26px;
  color: #1a0e05;
  margin-bottom: 30px;
}
.input-group {
  text-align: left;
  margin-bottom: 18px;
}
.input-group label {
  display: block;
  font-size: 12px;
  font-weight: 600;
  color: #6b3e26;
  margin-bottom: 6px;
  letter-spacing: 1px;
  text-transform: uppercase;
}
.input-group input {
  width: 100%;
  padding: 12px 16px;
  border: 1.5px solid #e8d5b7;
  border-radius: 12px;
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  color: #1a0e05;
  background: #faf4ec;
  outline: none;
  transition: border 0.2s;
}
.input-group input:focus {
  border-color: #c07a2c;
  background: white;
}
.error {
  background: #fff0f0;
  color: #c0392b;
  padding: 10px 16px;
  border-radius: 10px;
  font-size: 13px;
  margin-bottom: 18px;
  border: 1px solid #f5c6c6;
}
.login-btn {
  width: 100%;
  background: #3b1f0e;
  color: white;
  border: none;
  padding: 13px;
  border-radius: 25px;
  font-size: 15px;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  cursor: pointer;
  transition: background 0.2s;
  margin-top: 6px;
}
.login-btn:hover { background: #c07a2c; }
.back-link {
  display: block;
  margin-top: 20px;
  font-size: 13px;
  color: #9a7a5a;
  text-decoration: none;
}
.back-link:hover { color: #c07a2c; }
</style>
</head>
<body>

<div class="login-box">
  <h2>☕ CAFENEST</h2>
  <h1>Admin Login</h1>

  <?php if($error): ?>
    <div class="error">⚠️ <?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="input-group">
      <label>Username</label>
      <input type="text" name="username" placeholder="Enter username" required>
    </div>
    <div class="input-group">
      <label>Password</label>
      <input type="password" name="password" placeholder="Enter password" required>
    </div>
    <button type="submit" class="login-btn">Login to Dashboard →</button>
  </form>

  <a href="../index.php" class="back-link">← Back to CafeNest</a>
</div>

</body>
</html>