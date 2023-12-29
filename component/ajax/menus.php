<?php
require '../../component/functions.php';

// tangkap keyword
$keyword = $_GET['keyword'];

// ambil data (query)
$products = query("SELECT * FROM products
WHERE product_name LIKE '%$keyword%' OR description LIKE '%$keyword%' OR category LIKE '%$keyword%'
ORDER BY category DESC;
");

?>

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


    <script>
        window.addEventListener("scroll", function() {
            var header = document.querySelector(".row-navbar");
            header.classList.toggle("sticky", window.scrollY > 0);
        });
    </script>
</body>

</html>