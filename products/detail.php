<?php

require_once '../component/functions.php';

// ambil data di URL
$id = $_GET["id_product"];
// query berdasarkan id
$product = query("SELECT * FROM products WHERE id_product = $id")[0];

// cek / buat cookie user
if (isset($_COOKIE['id_user'])) {
    $id_user = $_COOKIE['id_user'];
} else {
    setcookie('id_user', create_unique_id(), time() + 60 * 60 * 24 * 30);
}

// cek / buat cookie cart
if (isset($_COOKIE['id_cart'])) {
    $id_cart = $_COOKIE['id_cart'];
} else {
    setcookie('id_cart', create_unique_id(), time() + 60 * 60 * 24 * 30);
}

if (isset($_POST['add']) || isset($_POST['buy_now'])) {
    $id_product = filter_var($_POST['id_product'], FILTER_SANITIZE_STRING);
    $qty = filter_var($_POST['quantity'], FILTER_SANITIZE_STRING);

    // Check if id_cart and id_user already exist in the cart
    $verify_cart = $conn->prepare("SELECT * FROM `detail_cart` WHERE id_cart = ?");
    $verify_cart->execute([$id_cart]);

    $get_stock = $conn->prepare("SELECT * FROM `products` WHERE id_product = ?");
    $get_stock->execute([$id_product]);
    $fetch_product = $get_stock->fetch(PDO::FETCH_ASSOC);

    $new_qty = $qty;

    if ($verify_cart->rowCount() >= 10) {
        // If the cart is full
        showErrorMessageAndRedirect('Cart is full!', 'menus.php');
    } elseif ($verify_cart->rowCount() > 0) {
        // Check if the product is already in the cart
        $verify_detail_cart = $conn->prepare("SELECT * FROM `detail_cart` WHERE id_cart = ? AND id_product = ?");
        $verify_detail_cart->execute([$id_cart, $id_product]);

        if ($verify_detail_cart->rowCount() > 0) {
            // If the product is already in the cart, update quantity
            $fetch_cart = $verify_detail_cart->fetch(PDO::FETCH_ASSOC);
            $new_qty = $fetch_cart['quantity'] + $qty;
        }
    }

    if ($new_qty > $fetch_product['stock']) {
        // Fail the query if the quantity exceeds the stock
        showErrorMessageAndRedirect('Insufficient stock, product failed to be added', 'menus.php');
    }

    // Update or insert the product into the cart
    if (isset($_POST['add']) || isset($_POST['buy_now'])) {
        if (isset($fetch_cart)) {
            $update_cart = $conn->prepare("UPDATE `detail_cart` SET quantity = ? WHERE id_cart = ? AND id_product = ?");
            $update_cart->execute([$new_qty, $id_cart, $id_product]);
        } else {
            $insert_detail_cart = $conn->prepare("INSERT INTO `detail_cart` (id_cart, id_product, quantity) VALUES (?, ?, ?)");
            $insert_detail_cart->execute([$id_cart, $id_product, $new_qty]);

            $verify_cart_result = $verify_cart->rowCount();

            if ($verify_cart_result === 0) {
                $insert_cart = $conn->prepare("INSERT INTO `cart` (id_cart, id_user) VALUES (?, ?)");
                $insert_cart->execute([$id_cart, $id_user]);
            }
        }

        // Redirect based on the button clicked
        $redirect_page = isset($_POST['add']) ? 'menus.php' : 'cart.php';
        header("Location: $redirect_page");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/detail.css">
    <title>SINI COFFEE & FRIENDS</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col product-image">
                <img src="../img/<?= $product["image"] ?>" alt="<?= $product["product_name"] ?>">
            </div>
            <div class="col product-details">
                <form action="" method="post">
                    <div class="product">
                        <h1><?= $product["product_name"] ?></h1>
                        <p class="description"><?= $product["description"] ?></p>
                        <?php if ($product["stock"] <= 0) : ?>
                            <p class="out-of-stock">- Stok Habis -</p>
                        <?php endif; ?>
                        <div class="price-and-quantity">
                            <div class="price-and-stock">
                                <div class="price">Rp<?= number_format($product["price"], 0, ',', '.'); ?></div>
                                <div class="stock">Stock : <?= $product['stock']; ?></div>
                            </div>
                            <div class="quantity">
                                <label for="quantity">Qty:</label>
                                <input type="number" name="quantity" id="quantity" value="1" required min="1" max="99">
                            </div>
                        </div>
                        <input type="hidden" name="id_product" value="<?= $product["id_product"] ?>">
                        <button type="submit" name="add" class="add-to-cart">Add To Cart</button>
                        <button type="submit" name="buy_now" class="buy-now">Buy Now</button>
                    </div>
                </form>
            </div>
        </div>
        <a href="../products/menus.php">back</a>
    </div>
</body>

</html>