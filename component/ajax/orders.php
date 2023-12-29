<?php

require '../../component/functions.php';

// tangkap keyword
$keyword = $_GET['keyword'];

// ambil data (query)
$select_orders = $conn->prepare("SELECT * FROM orders WHERE invoice LIKE '%$keyword%' ORDER BY date DESC");
$select_orders->execute();

?>

<table width="100%">
    <thead>
        <tr>
            <td>Invoice</td>
            <td>Name</td>
            <td>Tolats</td>
            <td>Qty</td>
            <td>Table</td>
            <td>Date/time</td>
            <td>Status</td>
        </tr>
    </thead>

    <?php
    $select_orders = $conn->prepare("SELECT * FROM orders WHERE invoice LIKE '%$keyword%' ORDER BY date DESC");
    $select_orders->execute();

    if ($select_orders->rowCount() > 0) {
        while ($fetch_order = $select_orders->fetch(PDO::FETCH_ASSOC)) {
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
                <td class="quantity">
                    <p><?= $fetch_order["address_table"]; ?></p>
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
    } else {
        echo '<tr><td colspan="4" class="empty">No orders found!</td></tr>';
    }
    ?>

</table>