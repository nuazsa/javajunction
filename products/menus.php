<?php

require_once '../component/functions.php';

$admin = $conn->prepare("SELECT COUNT(*) as count FROM administrator WHERE status_active = 'yes'");
$admin->execute();
$adminResult = $admin->fetch(PDO::FETCH_ASSOC);

if ($adminResult['count'] > 0) {
    if (isset($_GET['category'])) {
        $category = $_GET['category'];

        // ambil data (query)
        $products = $conn->prepare("SELECT * FROM products WHERE category =:category AND status != 'draft'");
        $products->bindParam(':category', $category);
        $products->execute();
        $products = $products->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // ambil data (query)
        $products = query(
            "SELECT * FROM products
        WHERE status != 'draft'
        ORDER BY 
        CASE 
            WHEN category = 'hot coffee' THEN 1
            WHEN category = 'cold coffee' THEN 2
            WHEN category = 'meal' THEN 3
            WHEN category = 'heavy meal' THEN 4
            WHEN category = 'snack' THEN 5
            WHEN category = 'cold drink' THEN 6
            ELSE 7 
        END, status;
        "
        );
    }
} else {
    header('location: error.php');
}

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

if (isset($_COOKIE['id_cart']) && isset($_COOKIE['id_user'])) {
    $get_cart_quantity = $conn->prepare("SELECT SUM(detail_cart.quantity) as total_quantity FROM detail_cart INNER JOIN cart ON detail_cart.id_cart = cart.id_cart WHERE cart.id_cart = ? AND cart.id_user = ?");
    $get_cart_quantity->execute([$id_cart, $id_user]);
    $result = $get_cart_quantity->fetch(PDO::FETCH_ASSOC);
}

$quantityToShow = isset($result['total_quantity']) ? $result['total_quantity'] : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="programmer: N.A Saputra">
    <link rel="stylesheet" href="css/style.css">
    <style>

    </style>
    <title>JavaJunction Home</title>
</head>

<body>
    <div class="container">
        <div class="row-navbar">
            <div class="navbar">
                <div class="logo">
                    <h1>JAVA JUNCTION HOME</h1>
                </div>
                <div class="menu">
                    <a href="menus.php" class="active">view products</a>
                    <a href="orders.php">my orders</a>

                    <a href="cart.php">Cart <div class="circle"><?= $quantityToShow; ?></div></a>
                    <input type="text" placeholder="Search" id="keyword-products">
                </div>
                <div class="menu-toggle" onclick="toggleMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <div class="scroll-nav" id="scroll-nav">
                <a href="menus.php" class="item <?php echo empty($category) ? 'item-active' : ''; ?>">
                    <p>Semua</p>
                </a>

                <?php

                $visitedCategories = [];

                foreach ($products as $product) {
                    if (!in_array($product['category'], $visitedCategories)) {
                        $visitedCategories[] = $product['category'];
                ?>

                        <a href="menus.php?category=<?= $product['category']; ?>" class="item <?php echo $category === $product['category'] ? 'item-active' : ''; ?>">
                            <p><?= $product['category']; ?></p>
                        </a>

                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div class="banner">
        <img src="../img/about.jpg" alt="">
    </div>

    <div class="container">
        <div class="card" id="card">
            <?php foreach ($products as $product) : ?>
                <div class="product">
                    <a href="detail.php?id_product=<?= $product["id_product"] ?>">
                        <img src="../img/<?= $product["image"] ?>" alt="">
                        <h4><?= $product["product_name"] ?></h4>
                        <p>Rp<?= number_format($product["price"], 0, ',', '.'); ?></p>
                        <?php if ($product["stock"] <= 0) : ?>
                            <p class="out-of-stock">- Stok Habis -</p>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endforeach ?>
        </div>
    </div>


    <script>
        window.addEventListener("scroll", function() {
            var header = document.querySelector(".row-navbar");
            header.classList.toggle("sticky", window.scrollY > 0);
        });

        function toggleMenu() {
            var menu = document.querySelector('.menu');
            menu.classList.toggle('active');
        }

        var keywordProducts = document.getElementById('keyword-products');
        var card = document.getElementById('card');

        // tambahkan event ketika keyword products diketik
        keywordProducts.addEventListener('keyup', function() {
            // buat object ajax untuk products.php
            var xhrProducts = new XMLHttpRequest();
            // cek kesiapan ajax
            xhrProducts.onreadystatechange = function() {
                if (xhrProducts.readyState == 4 && xhrProducts.status == 200) {
                    card.innerHTML = xhrProducts.responseText;
                }
            }
            // eksekusi ajax untuk products.php
            xhrProducts.open('GET', '../component/ajax/menus.php?keyword=' + keywordProducts.value, true);
            xhrProducts.send();
        });
    </script>
</body>

</html>