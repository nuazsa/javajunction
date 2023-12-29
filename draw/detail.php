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



if (isset($_POST['add'])) {
    $id_product = $_POST['id_product'];
    $id_product = filter_var($id_product, FILTER_SANITIZE_STRING);
    $qty = $_POST['quantity'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);

    // cek apakah id_cart dan id_user sudah ada dalam keranjang
    $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE id_cart = ? AND id_user = ?");
    $verify_cart->execute([$id_cart, $id_user]);

    $max_cart_items = $conn->prepare("SELECT * FROM `detail_cart` WHERE id_cart = ?");
    $max_cart_items->execute([$id_cart]);

    // jika id_cart dan id_user sudah ada dalam keranjang,
    // tambahkan produk / quantity
    if ($verify_cart->rowCount() > 0) {
        // cek apakah produk sudah ada dalam keranjang
        $verify_detail_cart = $conn->prepare("SELECT * FROM `detail_cart` WHERE id_cart = ? AND id_product = ?");
        $verify_detail_cart->execute([$id_cart, $id_product]);
        
        if ($verify_detail_cart->rowCount() > 0){
            // jika produk sudah ada di keranjang, tambahkan quantity
            $fetch_cart = $verify_detail_cart->fetch(PDO::FETCH_ASSOC);
            $new_qty = $fetch_cart['quantity'] + $qty;
    
            $update_cart = $conn->prepare("UPDATE `detail_cart` SET quantity = ? WHERE id_cart = ? AND id_product = ?");
            $update_cart->execute([$new_qty, $id_cart, $id_product]);
    
            $success_msg[] = 'Updated cart!';
        } else {
            // jika produk belum ada di keranjang, tambahkan produk
            $insert_detail_cart = $conn->prepare("INSERT INTO `detail_cart`(id_cart, id_product, quantity) VALUES(?,?,?)");
            $insert_detail_cart->execute([$id_cart, $id_product, $qty]);
            $success_msg[] = 'Added to cart!';
        }
    } elseif ($max_cart_items->rowCount() == 10) {
        $warning_msg[] = 'Cart is full!';
    } else {
        // jika id_cart dan id_user belum ada dalam keranjang   
        // insert kedalam detail cart
        $insert_detail_cart = $conn->prepare("INSERT INTO `detail_cart`(id_cart, id_product, quantity) VALUES(?,?,?)");
        $insert_detail_cart->execute([$id_cart, $id_product, $qty]);
        $success_msg[] = 'Added to cart!';

        // insert id_cart dan id_user kedalam cart
        $insert_cart = $conn->prepare("INSERT INTO `cart`(id_cart, id_user) VALUES(?,?)");
        $insert_cart->execute([$id_cart, $id_user]);

    }
    // redirect
    header('Location: menus.php');
} elseif (isset($_POST['buy_now'])){
    $id_product = $_POST['id_product'];
    $id_product = filter_var($id_product, FILTER_SANITIZE_STRING);
    $qty = $_POST['quantity'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);

    // cek apakah id_cart dan id_user sudah ada dalam keranjang
    $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE id_cart = ? AND id_user = ?");
    $verify_cart->execute([$id_cart, $id_user]);

    $max_cart_items = $conn->prepare("SELECT * FROM `detail_cart` WHERE id_cart = ?");
    $max_cart_items->execute([$id_cart]);

    // jika id_cart dan id_user sudah ada dalam keranjang,
    // tambahkan produk / quantity
    if ($verify_cart->rowCount() > 0) {
        // cek apakah produk sudah ada dalam keranjang
        $verify_detail_cart = $conn->prepare("SELECT * FROM `detail_cart` WHERE id_cart = ? AND id_product = ?");
        $verify_detail_cart->execute([$id_cart, $id_product]);
        
        if ($verify_detail_cart->rowCount() > 0){
            // jika produk sudah ada di keranjang, tambahkan quantity
            $fetch_cart = $verify_detail_cart->fetch(PDO::FETCH_ASSOC);
            $new_qty = $fetch_cart['quantity'] + $qty;
    
            $update_cart = $conn->prepare("UPDATE `detail_cart` SET quantity = ? WHERE id_cart = ? AND id_product = ?");
            $update_cart->execute([$new_qty, $id_cart, $id_product]);
    
            $success_msg[] = 'Updated cart!';
        } else {
            // jika produk belum ada di keranjang, tambahkan produk
            $insert_detail_cart = $conn->prepare("INSERT INTO `detail_cart`(id_cart, id_product, quantity) VALUES(?,?,?)");
            $insert_detail_cart->execute([$id_cart, $id_product, $qty]);
            $success_msg[] = 'Added to cart!';
        }
    } elseif ($max_cart_items->rowCount() == 10) {
        $warning_msg[] = 'Cart is full!';
    } else {
        // jika id_cart dan id_user belum ada dalam keranjang   
        // insert kedalam detail cart
        $insert_detail_cart = $conn->prepare("INSERT INTO `detail_cart`(id_cart, id_product, quantity) VALUES(?,?,?)");
        $insert_detail_cart->execute([$id_cart, $id_product, $qty]);
        $success_msg[] = 'Added to cart!';

        // insert id_cart dan id_user kedalam cart
        $insert_cart = $conn->prepare("INSERT INTO `cart`(id_cart, id_user) VALUES(?,?)");
        $insert_cart->execute([$id_cart, $id_user]);

    }
    // redirect
    header('Location: cart.php');
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
                        <div class="price-and-quantity">
                            <div class="price">Rp<?= number_format($product["price"], 0, ',', '.'); ?></div>
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
    </div>
</body>

</html>