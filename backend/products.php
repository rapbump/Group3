<?php
session_start();
$host = "localhost";
$user = "root";
$password = "";
$dbname = "customer_db";

$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error){
    die("Connection Failed: ". $conn->connect_error);
}
function flash(string $type, string $text): void    
{
    $_SESSION['flash'] = [ 
        'type' => $type,  
        'text' => $text
    ];
}
function redirect_addPro(){
    header("Location: ../frontend/addPro.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    exit("Invalid access. Open <a href='../index.php'>Home</a>.");
}

$action = $_POST['action'] ?? '';

if ($action === ''){
    flash('err', 'No action provided.');
    redirect_addPro();
}
if ($action === 'add'){
    $pro_name = trim($_POST['product_name']);
    $desc = $_POST['description'];
    $price = $_POST['price'];

    if ($pro_name === '' || $desc === '' || $price === ''){
        flash('err', 'All fields are required.');
        redirect_addPro();
    }
    if (strlen($pro_name) < 5){
        flash('err', 'Product name must be at least 5 characters.');
        redirect_addPro();
    }
    if ($price <= 0){
        flash('err', 'Price must be a positive number.');
        redirect_addPro();
    }
    $stmt = $conn->prepare("INSERT INTO products (product_name, description, price) VALUES (?,?,?)");
    if (!$stmt) {
        flash('err', 'Prepare failed: ' . $conn->error);
        redirect_addPro();
    }
    $stmt->bind_param("ssd", $pro_name, $desc, $price);
    if ($stmt->execute()) {
        flash('ok', 'Product added successfully.');
    } else {
        flash('err', 'Insert failed: ' . $stmt->error);
    }
    $stmt->close();
    redirect_addPro();
}
?>