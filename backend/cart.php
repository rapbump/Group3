<?php
session_start();
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'customer_db';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    exit("Invalid access. Open <a href='../glowtrack.php'>Home</a>.");
}
function flash(string $type, string $text): void    
{
    $_SESSION['flash'] = [ 
        'type' => $type,  
        'text' => $text
    ];
}
function redirect_home(){
    header("Location: ../frontend/glowtrack.php");
    exit();
}

$action = $_POST['action'] ?? '';

if ($action === ''){
    exit("No action provided. Open <a href='../glowtrack.php'>Home</a>.");
}
if ($action === 'add_to_cart'){
    $product_id = $_POST['product_id'] ?? '';
    if ($product_id === ''){
        flash('err', 'No product ID provided.');
        redirect_home();
    }
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    if (!$stmt->execute()){
        flash('err', 'Database query failed: ' . $stmt->error);
        redirect_home();
    }
    $result = $stmt->get_result();
    if ($result->num_rows === 0){
        flash('err', 'Product not found.');
        redirect_home();
    }
    $product = $result->fetch_assoc();
    $_SESSION['cart'][] = [
        'product_id' => $product['product_id'],
        'name' => $product['product_name'],
        'price' => $product['price']
    ];
    flash('success', 'Product added to cart.');
    redirect_home();
}
?>