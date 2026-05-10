<?php
session_start();
include '../backend/connection.php';

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

function return_home(){
    header("Location: ../frontend/users_page.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'place_order') {
    $user_id = $_SESSION['user_id'];
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    $stmt = $conn->prepare("SELECT price FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($price);
    $stmt->fetch();
    $stmt->close();

    $total_price = $price * $quantity;

    $stmt2 = $conn->prepare("INSERT INTO orders (user_id, product_id, quantity, total_price, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt2->bind_param("iiid", $user_id, $product_id, $quantity, $total_price);
    $stmt2->execute();
    $stmt2->close();

    $stmt3 = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt3->bind_param("ii", $user_id, $product_id);
    $stmt3->execute();
    $stmt3->close();
    return_home();

}
?>
