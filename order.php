<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "cafenest_db", 3307);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB Error: ' . $conn->connect_error]);
    exit;
}

$data  = json_decode(file_get_contents("php://input"), true);

$name  = $conn->real_escape_string($data['name']  ?? '');
$phone = $conn->real_escape_string($data['phone'] ?? '');
$cart  = $data['cart'] ?? [];

if (!$name || !$phone || empty($cart)) {
    echo json_encode(['success' => false, 'message' => 'Missing fields.']);
    exit;
}

$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['qty'];
}

$items_json = $conn->real_escape_string(json_encode($cart));

// ✅ FIXED: only using columns that exist in your table
$sql = "INSERT INTO orders (customer_name, phone, items, total, status, created_at)
        VALUES ('$name', '$phone', '$items_json', '$total', 'pending', NOW())";

if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'order_id' => $conn->insert_id]);
} else {
    echo json_encode(['success' => false, 'message' => 'Insert error: ' . $conn->error]);
}

$conn->close();
?>