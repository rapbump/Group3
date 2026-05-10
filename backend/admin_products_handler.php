<?php
session_start();
include 'connection.php';

function flash(string $type, string $text): void {
    $_SESSION['flash'] = [
        'type' => $type,
        'text' => $text
    ];
}

function redirect_addPro() {
    header("Location: ../frontend/view_product.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit("Invalid access. Open <a href='../index.php'>Home</a>.");
}

$action = $_POST['action'] ?? '';

if ($action === '') {
    flash('err', 'No action provided.');
    redirect_addPro();
}

if ($action === 'add') {
    $pro_name = trim($_POST['product_name']);
    $desc     = $_POST['description'];
    $price    = (float)$_POST['price'];
    $stock    = (int)$_POST['stocks'];

    if ($pro_name === '' || $desc === '' || $price === '' || $stock === '') {
        flash('err', 'All fields are required.');
        redirect_addPro();
    }
    if (strlen($pro_name) < 5) {
        flash('err', 'Product name must be at least 5 characters.');
        redirect_addPro();
    }
    if ($price <= 0) {
        flash('err', 'Price must be a positive number.');
        redirect_addPro();
    }

    $stmt = $conn->prepare("INSERT INTO products (pname, description, price, stocks) VALUES (?,?,?,?)");
    if (!$stmt) {
        flash('err', 'Prepare failed: ' . $conn->error);
        redirect_addPro();
    }
    $stmt->bind_param("ssdi", $pro_name, $desc, $price, $stock);
    if ($stmt->execute()) {
        flash('ok', 'Product added successfully.');
    } else {
        flash('err', 'Insert failed: ' . $stmt->error);
    }
    $stmt->close();
    redirect_addPro();
}

if ($action === 'edit') {
    $id       = (int)$_POST['product_id'];
    $pro_name = trim($_POST['product_name']);
    $desc     = $_POST['description'];
    $price    = (float)$_POST['price'];
    $stock    = (int)$_POST['stocks'];

    $stmt = $conn->prepare("UPDATE products SET pname=?, description=?, price=?, stocks=? WHERE product_id=?");
    $stmt->bind_param("ssdii", $pro_name, $desc, $price, $stock, $id);
    if ($stmt->execute()) {
        flash('ok', 'Product updated successfully.');
    } else {
        flash('err', 'Update failed: ' . $stmt->error);
    }
    $stmt->close();
    redirect_addPro();
}

if ($action === 'delete') {
    $id = (int)$_POST['product_id'];

    $stmt = $conn->prepare("DELETE FROM products WHERE product_id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        flash('ok', 'Product deleted successfully.');
    } else {
        flash('err', 'Delete failed: ' . $stmt->error);
    }
    $stmt->close();
    redirect_addPro();
}
?>
