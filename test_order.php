<?php
$conn = new mysqli('localhost', 'root', '', 'cafenest_db', 3307);

if ($conn->connect_error) {
    die("❌ DB Connection Failed: " . $conn->connect_error);
}
echo "✅ DB Connected!<br><br>";

$result = $conn->query("SELECT * FROM orders ORDER BY id DESC LIMIT 10");

if (!$result) {
    die("❌ Table error: " . $conn->error);
}

if ($result->num_rows === 0) {
    echo "⚠️ Orders table is EMPTY — no orders saved yet.";
} else {
    echo "✅ Found " . $result->num_rows . " orders:<br><br>";
    while ($row = $result->fetch_assoc()) {
        echo "Order #" . $row['id'] . " — " . $row['customer_name'] . " — ₹" . $row['total'] . " — " . $row['status'] . "<br>";
    }
}
?>