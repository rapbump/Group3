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
function redirect_addService(){
    header("Location: ../frontend/addSer.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    exit("Invalid access. Open <a href='../index.php'>Home</a>.");
}

$action = $_POST['action'] ?? '';

if ($action === ''){
    flash('err', 'No action provided.');
    redirect_addService();
}
if ($action === 'add'){
    $pname = trim($_POST['name']);
    $desc = $_POST['description'];
    $price = $_POST['price'];

    if ($pname === '' || $desc === '' || $price === ''){
        flash('err', 'All fields are required.');
        redirect_addService();
    }
    if (strlen($pname) < 5){
        flash('err', 'Service name must be at least 5 characters.');
        redirect_addService();
    }
    if ($price <= 0){
        flash('err', 'Price must be a positive number.');
        redirect_addService();
    }
    $stmt = $conn->prepare("INSERT INTO service (service_name, description, price) VALUES (?,?,?)");
    if (!$stmt) {
        flash('err', 'Prepare failed: ' . $conn->error);
        redirect_addService();
    }
    $stmt->bind_param("ssd", $pname, $desc, $price);
    if ($stmt->execute()) {
        flash('ok', 'Service added successfully.');
    } else {
        flash('err', 'Insert failed: ' . $stmt->error);
    }
    $stmt->close();
    redirect_addService();
}
?>