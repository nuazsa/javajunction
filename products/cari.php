<?php  

require_once 'functions.php';

$keyword = $_POST["keyword"];

$query = "SELECT * FROM products WHERE product_name LIKE %$keyword%";
$products = query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>SINI COFFEE & FRIENDS</title>
</head>
<body>

<div class="container">
    <div class="row-navbar">
        <div class="navbar">
            <div class="logo">
                <h1>SINI COFFEE & FRIENDS</h1>
            </div>
            <div class="col">
                <form class="box" action="" method="post">
                    <input type="text" name="keyword" size="40px" placeholder="Masukkan Keyword Pencarian..." autocomplete="of" id="keyword">
                    <button type="submit" name="cari" id="tombolCari">Cari</button>
                </form>
            </div>
        </div>
        <div class="scroll-nav" id="scroll-nav">
            <a href="#" class="item-active">
                <p>Semua</p>
            </a>
            <a href="" class="item">
                <p>Makanan</p>
            </a>
            <a href="" class="item">
                <p>Minuman</p>
            </a>
            <a href="" class="item">
                <p>Coffee</p>
            </a>
            <a href="" class="item">
                <p>Topping</p>
            </a>
            <a href="" class="item">
                <p>Snack</p>
            </a>
            <a href="" class="item">
                <p>Paket</p>
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
    <img src="img/about.jpg" alt="">
</div>
 
<div class="container">
    <div class="card">
    <?php foreach ($products as $product) : ?>
        <div class="product">
            <img src="<?= $product["image"]?>" alt="">
            <h3><?= $product["product_name"]?></h3>
            <p><?= $product["description"]?></p>
            <p><?= $product["price"]?></p>            
        </div>
        <?php endforeach ?>
    </div>
</div>

</body>
</html>