<?php
session_start();

require_once '../../component/functions.php';

// cek session
if (!isset($_SESSION["user"])) {
    // redirect jika tidak ada
    header("Location: ../login.php");
    exit;
}

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
    ELSE 4
  END;
");

// Mengubah status produk menjadi "empty" jika stok habis
foreach ($products as $product) {
    if ($product['stock'] == 0) {
        $update_status_empty = $conn->prepare("UPDATE products SET status = 'empty' WHERE id_product = ?");
        $update_status_empty->execute([$product['id_product']]);
    }
}


// menjumlahkan row menu
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$totalMenus = $stmt->rowCount();

// menjumlahkan total stpck
$stmt = $conn->prepare("SELECT SUM(stock) AS total_stock FROM products");
$stmt->execute();
$result = $stmt->fetch(); // Fetch the result

$totalStock = $result['total_stock']; // Access the total stock value

// menjumlahkan row order
$select_invoices = $conn->prepare("SELECT COUNT(DISTINCT invoice) AS total_invoices FROM orders");
$select_invoices->execute();
$total_invoices = $select_invoices->fetch(PDO::FETCH_ASSOC)['total_invoices'];

// menjumlahkan total stpck
$stmt = $conn->prepare("SELECT SUM(grand_price) AS total_money FROM orders WHERE status != 'needs payment'");
$stmt->execute();
$result = $stmt->fetch(); // Fetch the result

$totalMoney = $result['total_money']; // Access the total stock value

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Dashboard</title>
</head>

<body>
    <section id="menu">
        <div class="logo">
            <img src="../../img/logo.png" width="100PX">
            <h2>JAVA JUNCTION</h2>
        </div>
        <div class="items">
            <li class="active"><a href="index.php">Dashboard</a></li>
            <li><a href="../orders/index.php">List Orders</a></li>
            <li><a href="../orders/live.php">List Orders ( live )</a></li>
            <li><a href="../admin/index.php">Admin</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </div>
    </section>

    <section id="interface">
        <div class="navigation">
            <div class="n1">
                <div>
                    <i id="menu-btn" class="fas fa-bars"></i>
                </div>
                <div class="search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search Product" id="keyword-products">
                </div>
            </div>
            <div class="add-btn">
                <i class="far fa-add"></i>
                <a href="addProduct.php">Add Product</a>
            </div>
        </div>

        <h3 class="i-name">
            Dashboard
        </h3>

        <div class="values">
            <div class="val-box">
                <i class="fa-solid fa-utensils"></i>
                <div>
                    <h3><?= $totalMenus ?></h3>
                    <span>Total Menu</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa-solid fa-layer-group"></i>
                <div>
                    <h3><?= $totalStock ?></h3>
                    <span>Total Stock</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa-solid fa-right-left"></i>
                <div>
                    <h3><?= $total_invoices ?></h3>
                    <span>Total Orders</span>
                </div>
            </div>
            <div class="val-box">
                <i class="fa-solid fa-money-bill-wave"></i>
                <div>
                    <h3>Rp<?= number_format($totalMoney, 0, ',', '.'); ?></h3>
                    <span>Finance</span>
                </div>
            </div>
        </div>

        <div class="board" id="board">
            <table width="100%">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Status</td>
                        <td>Price</td>
                        <td>Stock</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td class="people">
                                <img src="../../img/<?= $product["image"] ?>" alt="">
                                <div class="people-desk">
                                    <h5><?= $product["product_name"] ?></h5>
                                </div>
                            <td class="people_des">
                                <p><?= $product["description"] ?></p>
                            </td>
                            <td class="status <?= ($product["status"] == "active") ? 'active' : (($product["status"] == "draft") ? 'draft' : 'empty') ?>">
                                <p><?= $product["status"] ?></p>
                            </td>
                            <td class="price">
                                <p> Rp<?= number_format($product["price"], 0, ',', '.'); ?></p>
                            </td>
                            <td class="stock">
                                <p><?= $product["stock"] ?></p>
                            </td>
                            <td class="edit">
                                <a href="edit.php?id_product=<?= $product["id_product"] ?>">Edit</a>
                            </td>
                            <td class="delete">
                                <a href="delete.php?id=<?= $product["id_product"]; ?>" onclick="return confirm('yakin?');">Hapus</a>
                            </td>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </section>


    <script src="../../component/js/script.js"></script>
</body>

</html>