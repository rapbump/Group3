<?php
session_start();
include '../backend/connection.php';


$id = (int)($_GET['product_id'] ?? 0);


if ($id <= 0) {
    exit("Invalid product ID. <a href='view_products.php'>Back</a>");
}


$stmt = $conn->prepare("SELECT * FROM products WHERE product_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    exit("Product not found. <a href='view_products.php'>Back</a>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../style/edit.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="admin_page.php">GlowTrack Admin</a>
        </div>
    </header>

    <main>
        <section class="edit-product">
            <h2>Edit Product</h2>
            <form action="../backend/admin_products_handler.php" method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

                <label>Product Name</label>
                <input type="text" name="product_name" value="<?= htmlspecialchars($product['pname']) ?>" required>

                <label>Description</label>
                <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea>

                <label>Price</label>
                <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" step="0.01" required>

                <label>Stock</label>
                <input type="number" name="stocks" value="<?= htmlspecialchars($product['stocks']) ?>" required>

                <button type="submit" class="save-btn">Save Changes</button>
            </form>

            <form action="../backend/admin_products_handler.php" method="POST" style="margin-top:15px;">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?');">
                    Delete Product
                </button>
            </form>
        </section>
    </main>
</body>
</html>
