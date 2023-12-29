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
$orders = query("SELECT * FROM orders ORDER BY date DESC");

// menjumlahkan row menu
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$totalMenus = $stmt->rowCount();





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="2">

    <link rel="stylesheet" href="../css/index.css">
    <title>Orders</title>
    </script>
</head>

<body>
    <section id="menu">
        <div class="logo">
            <img src="../../img/logo.png" width="100PX">
            <h2>JAVA JUNCTION</h2>
        </div>
        <div class="items">
            <li><a href="../dashboard/index.php">Dashboard</a></li>
            <li><a href="index.php">List Orders</a></li>
            <li class="active"><a href="live.php">List Orders ( live )</a></li>
            <li><a href="../admin/index.php">Admin</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </div>
    </section>

    <section id="interface">

        <h3 class="i-name">
            List Orders
        </h3>

        <div class="board" id="board">
            <table width="100%">
                <thead>
                    <tr>
                        <td>Invoice</td>
                        <td>Name</td>
                        <td>Tolats</td>
                        <td>Qty</td>
                        <td>Date/time</td>
                        <td>Status</td>
                    </tr>
                </thead>

                <?php
                $select_orders = $conn->prepare("SELECT * FROM orders ORDER BY date DESC");
                $select_orders->execute();

                $invoices = array(); // Array to store unique invoices

                if ($select_orders->rowCount() > 0) {
                    while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                        // Check if this invoice has been displayed already
                        if (!in_array($fetch_order['invoice'], $invoices)) {
                            $invoices[] = $fetch_order['invoice']; // Add the invoice to the array

                            // Calculate total price and total quantity for this invoice
                            $total_price = 0;
                            $total_quantity = 0;

                            // Select all products for this invoice
                            $select_product = $conn->prepare("SELECT * FROM `orders` WHERE invoice = ?");
                            $select_product->execute([$fetch_order['invoice']]);

                            // while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                            //     // $total_price += $fetch_product['price'] * $fetch_product['quantity'];
                            //     // $total_quantity += $fetch_product['quantity'];
                            // }

                            // Display the box for the invoice
                ?>
                            <tr>
                                <td class="invoice">
                                    <p><?= $fetch_order["invoice"] ?></p>
                                </td>
                                <td class="name">
                                    <p><?= $fetch_order["name"] ?></p>
                                </td>
                                <td class="grand_price">
                                    <p> Rp<?= number_format($fetch_order["grand_price"], 0, ',', '.'); ?></p>
                                </td>
                                <td class="quantity">
                                    <p><?= $fetch_order["quantity"]; ?></p>
                                </td>
                                <td class="price">
                                    <p><?= $fetch_order["date"]; ?></p>
                                </td>
                                <td class="status <?php
                                                    if ($fetch_order["status"] == "order in process") {
                                                        echo 'in_process';
                                                    } elseif ($fetch_order["status"] == "needs payment") {
                                                        echo 'needs_payment';
                                                    } else {
                                                        echo 'draft';
                                                    }
                                                    ?>">

                                    <p><?= $fetch_order["status"] ?></p>
                                </td>
                                <td class="edit">
                                    <a href="detail.php?invoice=<?= $fetch_order["invoice"] ?>">View</a>
                                </td>
                            </tr>
                <?php
                        }
                    }
                } else {
                    echo '<tr><td colspan="4" class="empty">No orders found!</td></tr>';
                }
                ?>

            </table>
        </div>
    </section>
</body>

</html>