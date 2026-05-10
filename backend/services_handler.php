<?php
session_start();
include 'connection.php';

function flash(string $type, string $text): void    
{
    $_SESSION['flash'] = [ 
        'type' => $type,  
        'text' => $text
    ];
}
function redirect_addService(){
    header("Location: ../frontend/admin_addSer.php");
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
    $service_name = trim($_POST['service_name'] ?? '');
    $desc = $_POST['description'];
    $price = $_POST['price'];


    if ($service_name === '' || $desc === '' || $price === ''){
        flash('err', 'All fields are required.');
        redirect_addService();
    }
    if (strlen($service_name) < 5){
        flash('err', 'Service name must be at least 5 characters.');
        redirect_addService();
    }
    if ($price <= 0){
        flash('err', 'Price must be a positive number.');
        redirect_addService();
    }
    $stmt = $conn->prepare("INSERT INTO services (service_name, description, price) VALUES (?,?,?)");
    if (!$stmt) {
        flash('err', 'Prepare failed: ' . $conn->error);
        redirect_addService();
    }
    $stmt->bind_param("ssd", $service_name, $desc, $price);
    if ($stmt->execute()) {
        flash('ok', 'Service added successfully.');
    } else {
        flash('err', 'Insert failed: ' . $stmt->error);
    }
    $stmt->close();
    redirect_addService();
}
?>