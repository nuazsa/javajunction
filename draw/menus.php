<?php

require_once '../component/functions.php';


// Pengiriman Query
$query = "SELECT * FROM nama_tabel";
$result = mysqli_query($koneksi, $query);

// Pengolah Hasil
while ($row = mysqli_fetch_assoc($result)) {
    echo "Nama: " . $row["nama_kolom"] . "<br>";
}





if (isset($_GET['category'])) {
    $category = $_GET['category'];
    
    // ambil data (query)
    $products = query("SELECT * FROM products WHERE category = '$category'");
} else {
// ambil data (query)
$products = query("SELECT * FROM products
ORDER BY 
  CASE 
    WHEN category = 'hot coffee' THEN 1
    WHEN category = 'cold coffee' THEN 2
    WHEN category = 'meal' THEN 3
    WHEN category = 'heavy meal' THEN 4
    WHEN category = 'snack' THEN 5
    WHEN category = 'cold drink' THEN 6
    ELSE 7
  END;
");
}




if (isset($_COOKIE['id_user'])) {
    $id_user = $_COOKIE['id_user'];
} else {
    setcookie('id_user', create_unique_id(), time() + 60 * 60 * 24 * 30);
}
      

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>JavaJunction Home</title>
</head>

<body>
    <div class="container">
        <div class="row-navbar">
            <div class="navbar">
                <div class="logo">
                    <h1>JAVA JUNCTION HOME</h1>
                </div>
                <div class="col">
                    <a href="menus.php" class="active">view products</a>
                    <a href="orders.php">my orders</a>
                    <a href="cart.php">cart</a>
                    <input type="text" placeholder="Search" id="keyword">
                </div>
            </div>

            <div class="scroll-nav" id="scroll-nav">
                <a href="menus.php" class="item <?php echo empty($category) ? 'item-active' : ''; ?>">
                    <p>Semua</p>
                </a>
                <a href="menus.php?category=hot coffee" class="item <?php echo $category === 'hot coffee' ? 'item-active' : ''; ?>">
                    <p>Hot Coffee</p>
                </a>
                <a href="menus.php?category=cold coffee" class="item <?php echo $category === 'cold coffee' ? 'item-active' : ''; ?>">
                    <p>Cold Coffee</p>
                </a>
                <a href="menus.php?category=meal" class="item <?php echo $category === 'meal' ? 'item-active' : ''; ?>">
                    <p>Meal</p>
                </a>
                <a href="menus.php?category=heavy meal" class="item <?php echo $category === 'heavy meal' ? 'item-active' : ''; ?>">
                    <p>Heavy Meal</p>
                </a>
                <a href="menus.php?category=snack" class="item <?php echo $category === 'snack' ? 'item-active' : ''; ?>">
                    <p>Snacks</p>
                </a>
                <a href="menus.php?category=cold drink" class="item <?php echo $category === 'cold drink' ? 'item-active' : ''; ?>">
                    <p>Cold Drinks</p>
                </a>
            </div>

            <div class="dropdown">
                <div class="row">
                    <a href="#">Makanan</a>
                    <a href="#">></a>
                </div>

                <ul>
                    <li><a href="">nasi</a></li>
                    <li><a href="">mie</a></li>
                    <li><a href="">bakso</a></li>
                    <li><a href="">ayam</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="banner">
        <img src="../img/about.jpg" alt="">
    </div>

    <div class="container">
        <div class="card">
            <?php foreach ($products as $product) : ?>
                <div class="product">
                    <a href="detail.php?id_product=<?= $product["id_product"] ?>">
                        <img src="../img/<?= $product["image"] ?>" alt="">
                        <h3><?= $product["product_name"] ?></h3>
                        <p>Rp<?= number_format($product["price"], 0, ',', '.'); ?></p>
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
    </script>
</body>

</html>