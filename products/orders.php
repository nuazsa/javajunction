<?php

require_once '../component/functions.php';

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
   <title>JavaJunction Home</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

   <link rel="stylesheet" href="css/orders.css">

</head>

<body>
   <div class="container">
      <div class="row-navbar">
         <div class="navbar">
            <div class="logo">
               <h1>JavaJunction Home</h1>
            </div>
            <div class="menu">
               <a href="menus.php">view products</a>
               <a href="orders.php" class="active">my orders</a>
               <a href="cart.php">cart</a>
            </div>
            <div class="menu-toggle" onclick="toggleMenu()">
               <span></span>
               <span></span>
               <span></span>
            </div>
         </div>
      </div>
   </div>

   <div class="banner">
      <img src="../img/about.jpg" alt="">
   </div>

   <section class="orders">

      <h1 class="heading">my orders</h1>

      <div class="box-container">

         <?php

         $select_orders = $conn->prepare("SELECT * 
         FROM orders 
         INNER JOIN cart ON orders.id_cart = cart.id_cart 
         WHERE cart.id_user = ? 
         ORDER BY orders.date DESC;
         ");
         $select_orders->execute([$id_user]);

         $invoices = array(); // Array to store unique invoices

         if ($select_orders->rowCount() > 0) {
            while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
               // Check if this invoice has been displayed already
               if (!in_array($fetch_order['invoice'], $invoices)) {
                  $invoices[] = $fetch_order['invoice']; // Add the invoice to the array
         ?>
                  <div class="box" <?php if ($fetch_order['status'] == 'canceled') {
                                       echo 'style="border:.2rem solid red";';
                                    } ?>>
                     <a href="detail_orders.php?invoice=<?= $fetch_order['invoice']; ?>">
                        <p class="date"><i class="fa fa-calendar"></i><?= $fetch_order['date']; ?></p>
                        <h3 class="name"> Invoice : <?= $fetch_order['invoice']; ?></h3>
                        <p class="price">Grand Total : Rp<?= number_format($fetch_order['grand_price'], 0, ',', '.'); ?></p>
                        <p class="quantity">Total Quantity : <?= $fetch_order['quantity']; ?></p>
                        <p class="status" style="color:<?php if ($fetch_order['status'] == 'needs payment') {
                                                            echo 'orange';
                                                         } elseif ($fetch_order['status'] == 'canceled') {
                                                            echo 'red';
                                                         } elseif ($fetch_order['status'] == 'order in process') {
                                                            echo 'green';
                                                         } else {
                                                            echo 'grey';
                                                         }; ?>"><?= $fetch_order['status']; ?></p>
                     </a>
                  </div>
         <?php

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
   <script>
      function toggleMenu() {
         var menu = document.querySelector('.menu');
         menu.classList.toggle('active');
      }
   </script>

</body>

</html>