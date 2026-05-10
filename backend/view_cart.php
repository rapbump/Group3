<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "glowtrack_db";

$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error){
    die("Connection Failed: ". $conn->connect_error);
}

if (!isset($_SESSION['customer_id'])) {
    die("You must be logged in to view your cart.");
}
$customer_id = (int)$_SESSION['customer_id'];

$stmt = $conn->prepare("
    SELECT p.pname, p.price, c.quantity
    FROM cart c
    JOIN products p ON c.product_id = p.product_id
    WHERE c.user_id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$results = $stmt->get_result();

$cart_items = [];
while ($row = $results->fetch_assoc()) {
    $cart_items[] = [
        'product_name' => $row['product_name'],
        'description' => $row['description'],
        'price' => $row['price'],
        'quantity' => $row['quantity']
    ];
}

?>