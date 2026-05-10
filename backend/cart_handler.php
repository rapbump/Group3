<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    exit("Invalid access. Open <a href='../users_page.php'>Home</a>.");
}
function flash(string $type, string $text): void    
{
    $_SESSION['flash'] = [ 
        'type' => $type,  
        'text' => $text
    ];
}
function redirect_home(){
    header("Location: ../frontend/users_page.php");
    exit();
}

$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

if ($quantity <= 0) {
    flash('err', 'Invalid Quantity!');
    redirect_home();
    exit();
}


$action = $_POST['action'] ?? '';

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view your cart.");
}
$customer_id = (int)$_SESSION['user_id'];


if ($action === ''){
    exit("No action provided. Open <a href='../users_page.php'>Home</a>.");
}
if ($action === 'add_to_cart'){
    $customer_id = $_SESSION['user_id'] ?? null;
    $product_id = $_POST['product_id'] ?? null;
    $quantity = $_POST['quantity'];

    if ($product_id === ''){
        flash('err', 'No product ID provided.');
        redirect_home();
    }
    $stmt = $conn->prepare("SELECT product_id, pname, description, price, quantity FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0){
        flash('err', 'Product not found.');
        redirect_home();
    }
    $product = $result->fetch_assoc();
    $stmt->close();
    

    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $customer_id, $product_id, $quantity);
    if (!$stmt->execute()){
        flash('err', 'Database query failed: ' . $stmt->error);
        redirect_home();
    }
    $stmt->close();
    $_SESSION['cart'][] = [
        'product_id' => $product['product_id'],
        'product_name' => $product['product_name'],
        'description' => $product['description'],
        'price' => $product['price'],
        'quantity' => $quantity
    ];
    flash('success', 'Product added to cart.');
    redirect_home();
}
?>