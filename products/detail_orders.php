<?php

require_once '../component/functions.php';

if (isset($_COOKIE['id_user'])) {
   $id_user = $_COOKIE['id_user'];
} else {
   setcookie('id_user', create_unique_id(), time() + 60 * 60 * 24 * 30);
}



if (isset($_GET['invoice'])) {
   $invoice = $_GET['invoice'];
} else {
   $invoice = '';
   header('location:orders.php?table=' . $table);
}

if (isset($_POST['cancel'])) {

   $select_cart = $conn->prepare("SELECT * FROM orders INNER JOIN detail_cart ON orders.id_cart = detail_cart.id_cart WHERE invoice = ?");
   $select_cart->execute([$invoice]);

   while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
      // Ambil quantity setiap produk, untuk mengurangi stok di produk
      $id_product = $fetch_cart['id_product']; // Asumsi id_product adalah kolom di tabel products

      // Kurangi stok di produk
      $update_stock_product = $conn->prepare("UPDATE `products` SET `stock` = stock + ? WHERE id_product = ?");
      $update_stock_product->execute([$fetch_cart['quantity'], $id_product]);
   }

   $update_orders = $conn->prepare("UPDATE `orders` SET status = ? WHERE invoice = ?");
   $update_orders->execute(['canceled', $invoice]);
   header('location:orders.php?table='.$table);

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>View Orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

   <link rel="stylesheet" href="css/detail_orders.css">

</head>

<body>


   <section class="order-details">

      <h1 class="heading">order details</h1>

      <div class="box-container">

         <?php
         $grand_total = 0;
         $select_orders = $conn->prepare("SELECT * FROM `orders` INNER JOIN detail_cart ON orders.id_cart = detail_cart.id_cart WHERE invoice = ? LIMIT 1");
         $select_orders->execute([$invoice]);
         if ($select_orders->rowCount() > 0) {

            while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {               
               $select_admin = $conn->prepare("SELECT * FROM `administrator` WHERE id_admin = ?");
               $select_admin->execute([$fetch_order['id_admin']]);
               $fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);

               $select_product = $conn->prepare("SELECT * FROM `products` WHERE id_product = ? LIMIT 1");
               $select_product->execute([$fetch_order['id_product']]);

               if ($select_product->rowCount() > 0) {
                  while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                     // $sub_total = ($fetch_order['price'] * $fetch_order['quantity']);
                     // $grand_total += $sub_total;
         ?>

                     <div class="box">
                        <div class="col">

                           <p class="title"><i class="fas fa-calendar"></i>Order : <?= $fetch_order['date']; ?></p>

                           <?php
                           $grand_total = 0;
                           if (isset($_GET['get_id'])) {
                              $select_get = $conn->prepare("SELECT * FROM `products` WHERE id_product = ?");
                              $select_get->execute([$_GET['get_id']]);
                              while ($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)) {
                           ?>

                                 <?php
                              }
                           } else {
                              $select_cart = $conn->prepare("SELECT * FROM `orders` INNER JOIN detail_cart ON orders.id_cart = detail_cart.id_cart WHERE invoice = ?");
                              $select_cart->execute([$invoice]);
                              if ($select_cart->rowCount() > 0) {
                                 while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id_product = ?");
                                    $select_products->execute([$fetch_cart['id_product']]);
                                    $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
                                    $sub_total = ($fetch_cart['quantity'] * $fetch_product['price']);

                                    $grand_total += $sub_total;

                                 ?>
                                    <div class="flex">
                                       <img src="../img/<?= $fetch_product['image']; ?>" class="image" alt="">
                                       <div>
                                          <h3 class="name"><?= $fetch_product['product_name']; ?></h3>
                                          <p class="price">Rp<?= number_format($fetch_product['price'], 0, ',', '.'); ?> x <?= $fetch_cart['quantity']; ?></p>
                                       </div>
                                    </div>
                           <?php
                                 }
                              } else {
                                 echo '<p class="empty">your cart is empty</p>';
                              }
                           }
                           ?>

                           <p class="grand-total">grand total : <span>Rp<?= number_format($fetch_order['grand_price'], 0, ',', '.'); ?></span></p>

                        </div>


                        <div class="col">
                           <p class="title">billing invoice : <?= $fetch_order['invoice']; ?></p>
                           <p class="user"><i class="fas fa-user"></i>name : <?= $fetch_order['name']; ?></p>
                           <p class="user"><i class="fas fa-phone"></i>phone : <?= $fetch_order['number']; ?></p>
                           <p class="user"><i class="fas fa-envelope"></i>email : <?= $fetch_order['email']; ?></p>
                           <p class="user"><i class="fas fa-map-marker-alt"></i>type : <?= $fetch_order['address_type'] ?> - <?= $fetch_order['address_table']; ?> (<?= $fetch_order['method']; ?>)</p>
                           <p class="user"><i class="fa-solid fa-user-tie"></i>cashier : <?= $fetch_admin['username'] ?></p>
                           <p class="title">status</p>
                           <p class="status" style="color:<?php if ($fetch_order['status'] == 'needs payment') {
                                                               echo 'orange';
                                                            } elseif ($fetch_order['status'] == 'canceled') {
                                                               echo 'red';
                                                            } elseif ($fetch_order['status'] == 'order in process') {
                                                               echo 'green';
                                                            } else {
                                                               echo 'grey';
                                                            }; ?>"><?= $fetch_order['status']; ?></p>
                           <?php if ($fetch_order['status'] == 'canceled') { ?>
                              <a href="checkout.php?invoice=<?= $fetch_order['invoice']; ?>" class="btn">order again</a>
                           <?php } else if ($fetch_order['status'] ==  'needs payment') { ?>
                              <form action="" method="POST">
                                 <input type="submit" value="cancel order" name="cancel" class="delete-btn" onclick="return confirm('cancel this order?');">
                              </form>
                           <?php } ?>
                        </div>
                     </div>
         <?php
                  }
               } else {
                  echo '<p class="empty">product not found!</p>';
               }
            }
         } else {
            echo '<p class="empty">no orders found!</p>';
         }
         ?>

      </div>

   </section>














   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <script src="js/script.js"></script>

</body>

</html>