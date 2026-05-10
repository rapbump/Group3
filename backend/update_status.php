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

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    if (isset($_POST['booking_id'])) {
        $booking_id = (int) $_POST['booking_id'];
        $status = $_POST['status'];

        $stmt = $conn->prepare("UPDATE booking SET status = ? WHERE booking_id = ? ");
        $stmt->bind_param("si", $status, $booking_id);
        $stmt->execute();
        $stmt->close();

        if ($status === 'accepted'){
            $stmt2 = $conn->prepare("UPDATE users SET status = 'confirmed' WHERE user_id = (SELECT user_id FROM booking WHERE booking_id = ?)");
            $stmt2->bind_param("i", $booking_id);
            $stmt2->execute();
            $stmt2->close();
        }
        header("Location: ../frontend/admin_page.php");
        exit();
    }

    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        $order_id = (int)$_POST['order_id'];
        $user_id  = $_SESSION['user']['id'];

        $stmt = $conn->prepare("UPDATE orders SET status = 'received' WHERE order_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $order_id, $user_id);
        $stmt->execute();
        $stmt->close();

        $stmt2 = $conn->prepare("DELETE FROM orders WHERE order_id = ? AND user_id = ?");
        $stmt2->bind_param("ii", $order_id, $user_id);
        $stmt2->execute();
        $stmt2->close();

        header("Location: ../frontend/user_order.php?deleted=1");
        exit();
    }
}


?>
