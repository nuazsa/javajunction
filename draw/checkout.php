<?php

require_once '../component/functions.php';

if (isset($_COOKIE['id_user'])) {
   $id_user = $_COOKIE['id_user'];
} else {
   setcookie('id_user', create_unique_id(), time() + 60 * 60 * 24 * 30);
}

if (isset($_COOKIE['id_cart'])) {
   $id_cart = $_COOKIE['id_cart'];
} else {
   setcookie('id_cart', create_unique_id(), time() + 60 * 60 * 24 * 30);
}

$user_invoice = create_unique_invoice();



if (isset($_POST['place_order'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $address_type = $_POST['address_type'];
   $address_type = filter_var($address_type, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $table = $_POST['address_table'];
   $table = filter_var($table, FILTER_SANITIZE_STRING);



   $verify_cart = $conn->prepare("SELECT * FROM `cart` WHERE id_cart = ?");
   $verify_cart->execute([$id_cart]);

   $get_admin = $conn->prepare("SELECT * FROM `administrator` WHERE status_active = 'yes'");
   $get_admin->execute();
   $admin_data = $get_admin->fetch(PDO::FETCH_ASSOC);

   if ($admin_data) {
      $get_id_admin = $admin_data['id_admin'];
      // Now you can use $get_id_admin as needed
   } else {
      // Handle the case where no matching admin is found
      echo "No active administrator found.";
   }


   if (isset($_GET['invoice'])) {

      $invoice = $_GET['invoice'];
      $get_order = $conn->prepare("SELECT * FROM `orders` INNER JOIN detail_cart on orders.id_cart = detail_cart.id_cart WHERE invoice = ?");
      $get_order->execute([$invoice]);
      if ($get_order->rowCount() > 0) {
         while ($order_info = $get_order->fetch(PDO::FETCH_ASSOC)) {
            $get_product = $conn->prepare("SELECT * FROM `products` WHERE id_product = ? LIMIT 1");
            $get_product->execute([$order_info['id_product']]);
            $product_info = $get_product->fetch(PDO::FETCH_ASSOC);

            // Periksa apakah stok cukup
            if ($product_info['stock'] < $order_info['quantity']) {
               // Redirect dengan pesan error
               showErrorMessageAndRedirect('Maaf, stok produk tidak mencukupi untuk pesanan dengan invoice ' . $invoice, 'menus.php');
               exit();
            } else {
               // Update informasi pesanan
               $update_order = $conn->prepare("UPDATE `orders` SET `name`=?, `number`=?, `email`=?, `address_table`=?, `address_type`=?, `method`=?, `status`=?, `id_admin`=?  WHERE invoice = ?");
               $update_order->execute([$name, $number, $email, $table, $address_type, $method, "needs payment", $get_id_admin, $invoice]);

               // Kurangi stok di produk
               $update_stock_product = $conn->prepare("UPDATE `products` SET `stock` = stock - ? WHERE id_product = ?");
               $update_stock_product->execute([$order_info['quantity'], $order_info['id_product']]);
            }
         }
         header('location:orders.php');
      } else {
         showErrorMessageAndRedirect('Invalid invoice!', 'menus.php');
      }
   } elseif ($verify_cart->rowCount() > 0) {

      // Menjumlahkan total stok
      $sum_quantity = $conn->prepare("SELECT SUM(quantity) AS quantity FROM `detail_cart` WHERE id_cart = ?");
      $sum_quantity->execute([$id_cart]);
      $result = $sum_quantity->fetch(); // Ambil hasil
      $quantity = $result['quantity']; // Ambil nilai total stok

      // Menjumlahkan grand total
      $select_cart = $conn->prepare("SELECT * FROM detail_cart INNER JOIN products ON detail_cart.id_product = products.id_product WHERE id_cart = ?;");
      $select_cart->execute([$id_cart]);

      $grand_total = 0; // Inisialisasi grand total di luar loop

      while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
         $sub_total = ($fetch_cart['quantity'] * $fetch_cart['price']); // Menggunakan $fetch_cart['price'] dari hasil query join
         $grand_total += $sub_total;

         $get_product = $conn->prepare("SELECT * FROM `products` WHERE id_product = ? LIMIT 1");
         $get_product->execute([$fetch_cart['id_product']]);
         $product_info = $get_product->fetch(PDO::FETCH_ASSOC);

         if ($product_info['stock'] < $fetch_cart['quantity']) {
            showErrorMessageAndRedirect("Maaf, stok produk tidak mencukupi untuk pesanan. (Sisa Stock : " . $product_info['stock'] . ")", 'menus.php');
            // Redirect dengan pesan error
            exit();
         }
      }

      // Semua produk memiliki stok yang cukup, lanjutkan dengan pengurangan stok dan penambahan informasi pesanan
      $select_cart->execute([$id_cart]); // Reset kursor

      while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
         $id_product = $fetch_cart['id_product']; // Asumsi id_product adalah kolom di tabel products

         // Kurangi stok di produk
         $update_stock_product = $conn->prepare("UPDATE `products` SET `stock` = stock - ? WHERE id_product = ?");
         $update_stock_product->execute([$fetch_cart['quantity'], $id_product]);
      }

      // Memasukkan informasi pesanan (diluar loop, setelah pengurangan stok)
      $insert_order = $conn->prepare("INSERT INTO `orders`(invoice, id_cart, name, number, email, address_table, address_type, method, grand_price, quantity, status, id_admin) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_invoice, $id_cart, $name, $number, $email, $table, $address_type, $method, $grand_total, $quantity, "needs payment", $get_id_admin]);

      header('location:orders.php');
   } else {
      showErrorMessageAndRedirect('Your cart is empty!', 'menus.php');
   }

   setcookie('id_cart', create_unique_id(), time() + 60 * 60 * 24 * 30);
}


$gatewayUrl = 'https://app.sandbox.midtrans.com';
$curl = curl_init($gatewayUrl . '/snap/v1/transactions');
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_USERPWD, 'SB-Mid-server-WgyTWmfPW9JkwEIdiiJy1_G-');
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
   'transaction_details' => [
      'order_id' => $user_invoice,
      'gross_amount' => 1000,
   ],
   'credit_card' => [
      'secure' => true
   ],
   'customer_details' => [
      'first_name' => 'azis',
      'email' => 'nurazissaputra@gmail.com',
   ]
]));

$response = curl_exec($curl);
$token = json_decode($response, true);


?>




<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

   <link rel="stylesheet" href="css/checkout.css">

   <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-aRBx-cQdXkLxIqFZ">
   </script>
</head>

<body>

   <section class="checkout">
      <h1 class="heading">checkout summary</h1>
      <div class="row">
         <form action="" method="POST">
            <h3>billing details</h3>
            <div class="flex">
               <div class="box">
                  <p>your name <span>*</span></p>
                  <input type="text" name="name" required maxlength="50" placeholder="enter your name" class="input">
                  <p>your phone</p>
                  <input type="number" name="number" maxlength="12" placeholder="enter your phone" class="input" min="0" max="9999999999999">
                  <p>your email</p>
                  <input type="email" name="email" maxlength="50" placeholder="enter your email" class="input">
                  <p>payment method <span>*</span></p>
                  <select name="method" class="input" required>
                     <option value="cash">cash</option>
                  </select>
               </div>
               <div class="box">
                  <p>order type <span>*</span></p>
                  <select name="address_type" class="input" required>
                     <option value="dine in">dine in</option>
                  </select>
                  <p>order type <span>*</span></p>
                  <select name="address_table" class="input" required>
                     <option value="a1">a1</option>
                     <option value="a2">a2</option>
                     <option value="a3">a3</option>
                     <option value="b1">b1</option>
                     <option value="b2">b2</option>
                     <option value="b3">b3</option>
                     <option value="c1">c1</option>
                     <option value="c2">c2</option>
                     <option value="c3">c3</option>
                  </select>
               </div>
            </div>
            <input type="submit" value="place order" name="place_order" id="place_order" class="btn">
         </form>

         <div class="summary">
            <h3 class="title">cart items</h3>
            <?php
            $grand_total = 0;
            // jika ada invoice yang dikirim
            if (isset($_GET['invoice'])) {
               $invoice = $_GET['invoice'];
               $get_order = $conn->prepare("SELECT * FROM `orders` INNER JOIN detail_cart on orders.id_cart = detail_cart.id_cart WHERE invoice = ?;");
               $get_order->execute([$invoice]);

               if ($get_order->rowCount() > 0) {
                  while ($order_info = $get_order->fetch(PDO::FETCH_ASSOC)) {
                     $get_product = $conn->prepare("SELECT * FROM `products` WHERE id_product = ?");
                     $get_product->execute([$order_info['id_product']]);
                     if ($get_product->rowCount() > 0) {
                        $product_info = $get_product->fetch(PDO::FETCH_ASSOC);
                        $sub_total = $product_info['price'] * $order_info['quantity'];
                        $grand_total += $sub_total;
            ?>
                        <div class="flex">
                           <img src="../img/<?= $product_info['image']; ?>" class="image" alt="">
                           <div>
                              <h3 class="name"><?= $product_info['product_name']; ?></h3>
                              <p class="price">Rp<?= number_format($product_info['price'], 0, ',', '.'); ?> x <?= $order_info['quantity']; ?></p>
                           </div>
                        </div>


                     <?php
                     }
                  }
               } else {
                  echo '<p class="empty">No products found for this invoice.</p>';
               }
            } else {
               // cek adakah produk dalam cart
               $select_cart = $conn->prepare("SELECT * FROM `detail_cart` WHERE id_cart = ?");
               $select_cart->execute([$id_cart]);

               // jika ada, tampilkan...
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

            <div class="grand-total"><span>grand total :</span>
               <p>Rp<?= number_format($grand_total, 0, ',', '.'); ?></p>
            </div>
         </div>

      </div>

   </section>





   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <script src="js/script.js"></script>
   
   <script>
      var btnBayar = document.getElementById('place_order');
      btnBayar.addEventListener('click', function(event) {
         event.preventDefault();
         window.snap.pay('<?php echo $token['token']; ?>', {
            onSuccess: function() {
               alert('Pembayaran Berhasil');
            },
            onError: function() {
               alert('Pembayaran Gagal');
            }
         });
      })
   </script>

</body>

</html>