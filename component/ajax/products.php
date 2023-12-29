<?php

require '../../component/functions.php';

// tangkap keyword
$keyword = $_GET['keyword'];

// ambil data (query)
$products = query("SELECT * FROM products WHERE product_name LIKE '%$keyword%' ORDER BY category desc");
?>

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
                            <td class="status <?= ($product["status"] == "active") ? 'active' : 'draft' ?>">
                                <p><?= $product["status"] ?></p>
                            </td>
                            <td class="price">
                                <p> Rp. <?= number_format($product["price"], 0, ',', '.'); ?></p>
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