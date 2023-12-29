<?php
// session_start();
require_once '../component/functions.php';

if (isset($_COOKIE['id_user'])) {
    $id_user = $_COOKIE['id_user'];
} else {
    setcookie('id_user', create_unique_id(), time() + 60 * 60 * 24 * 30, '/');
}


if (isset($_COOKIE['id_cart'])) {
    $id_cart = $_COOKIE['id_cart'];
} else {
    setcookie('id_cart', create_unique_id(), time() + 60 * 60 * 24 * 30, '/');
}


// kosongkan cart
if (isset($_POST['empty_cart'])) {
    // cek apakah id_cart memiliki produk
    $verify_empty_cart = $conn->prepare("SELECT * FROM `detail_cart` WHERE id_cart = ?");
    $verify_empty_cart->execute([$id_cart]);

    // jika ya, hapus seluruh cart
    if ($verify_empty_cart->rowCount() > 0) {
        $delete_cart_id = $conn->prepare("DELETE FROM `detail_cart` WHERE id_cart = ?");
        $delete_cart_id->execute([$id_cart]);
    } else {
    }
}


// jika tombol delete ditekan
if (isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id'])) {
    $id_product_to_delete = $_GET['id'];

    // persiapkan pernyataan SQL DELETE
    $delete_product = $conn->prepare("DELETE FROM detail_cart WHERE id_product = ?");
    $delete_product->execute([$id_product_to_delete]);

    // berikan pesan sukses atau sesuaikan sesuai kebutuhan Anda
    $success_msg[] = "Product with ID $id_product_to_delete deleted successfully.";
}



if (isset($_POST['proceed_to_checkout'])) {
    // Mengambil data keranjang
    $verify_cart = $conn->prepare("SELECT * FROM `detail_cart` WHERE id_cart = ?");
    $verify_cart->execute([$id_cart]);
    $verify_cart_result = $verify_cart->fetchAll(PDO::FETCH_ASSOC);

    if ($verify_cart_result) {
        foreach ($verify_cart_result as $cart_item) {
            // Mengambil stok produk
            $verify_product = $conn->prepare("SELECT * FROM `products` WHERE id_product = ?");
            $verify_product->execute([$cart_item['id_product']]);
            $product_data = $verify_product->fetch(PDO::FETCH_ASSOC);

            // Memeriksa apakah stok mencukupi
            if ($product_data && $product_data['stock'] < $cart_item['quantity']) {
                // Update quantity pada detail_cart jika stok mencukupi
                $update_quantity = $conn->prepare("UPDATE `detail_cart` SET quantity = ? WHERE id_cart = ? AND id_product = ?");
                $update_quantity->execute([$product_data['stock'], $id_cart, $cart_item['id_product']]);
                showErrorMessageAndRedirect('Stok tidak cukup, quantity di perbarui', 'cart.php');
            } else {
            }
        }

        // Redirect ke halaman checkout.php setelah memproses keranjang
        header('Location: checkout.php');
        exit();
    } else {
        echo "Keranjang kosong.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cart.css">
    <title>Cart</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="left">
                <h3>Shooping Cart Details</h3>
            </div>
            <div class="right">
                <a href="menus.php" class="back">Back To Shoop</a>

                <form action="" method="POST">
                    <input type="submit" value="empty cart" name="empty_cart" class="delete-btn" onclick="return confirm('empty your cart?');">
                </form>
            </div>
        </div>

        <span></span>
        <div class="list-cart">
            <table>
                <thead position="fixed" ;>
                    <tr>
                        <th colspan="2">Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <form action="" method="POST" class="box">
                        <?php
                        $grand_total = 0;

                        // cek apakah id_cart memiliki produk
                        $select_cart = $conn->prepare("SELECT * FROM `detail_cart` WHERE id_cart = ?");
                        $select_cart->execute([$id_cart]);

                        // tampilkan produk jika ada
                        if ($select_cart->rowCount() > 0) {
                            // ambil id produk dalam cart
                            // untuk mengambil data engkap produk
                            while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                $select_products = $conn->prepare("SELECT * FROM `products` WHERE id_product = ?");
                                $select_products->execute([$fetch_cart['id_product']]);

                                // jika produk ada, lakukan fetch
                                if ($select_products->rowCount() > 0) {
                                    $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
                                    $sub_total = $fetch_cart["quantity"] * $fetch_product["price"];
                                    $grand_total += $sub_total;
                        ?>



                                    <tr>
                                        <td>
                                            <div class="cart-item">
                                                <div class="image-box">
                                                    <img src="../img/<?= $fetch_product["image"] ?>" height="120px" alt="image not found">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="about">
                                                <h3><?= $fetch_product["product_name"] ?></h3>
                                                <p><?= $fetch_product["description"] ?></p>
                                            </div>
                                        </td>
                                        <td>Rp<?= number_format($fetch_product["price"], 0, ',', '.'); ?></td>
                                        <td><?= $fetch_cart["quantity"] ?></td>
                                        <td>Rp<?= number_format($sub_total, 0, ',', '.') ?></td>
                                        <td><a href="cart.php?action=delete&id=<?= $fetch_product["id_product"] ?>" class="remove">Delete</a></td>
                                    </tr>



                        <?php
                                } else {
                                    echo '<tr><td colspan="5"><p class="empty">Product was not found!</p></td></tr>';
                                }
                            }
                        } else {
                            echo '<tr><td colspan="6"><p class="empty">Your cart is empty!</p></td></tr>';
                        }
                        ?>
                    </form>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <h3>Total : Rp<?= number_format($grand_total, 0, ',', '.') ?></h3>
            <form action="" method="post">
                <button type="submit" name="proceed_to_checkout" class="process-btn">Proceed To Checkout</button>
            </form>


        </div>
    </div>

    </div>
</body>

</html>