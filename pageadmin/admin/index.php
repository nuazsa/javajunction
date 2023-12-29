<?php
session_start();

require_once '../../component/functions.php';

// check session
if (!isset($_SESSION["user"])) {
    // redirect if not logged in
    header("Location: ../login.php");
    exit;
}

// fetch data (query)
$admins = query("SELECT * FROM administrator");

if (isset($_POST['activated'])) {
    $username = $_POST['username'];

    // Use prepared statement to prevent SQL injection
    $update_status = $conn->prepare("UPDATE `administrator` SET `status_active`='yes' WHERE username = ?");
    $update_status->execute([$username]);

    // Use prepared statement to prevent SQL injection
    $update_status = $conn->prepare("UPDATE `administrator` SET `status_active`='no' WHERE username != ?");
    $update_status->execute([$username]);

    header("Location: index.php");
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index.css">
    <style>
        /* CSS styling */
        .process-btn {
    padding: 10px 15px;
    border: none;
    color: #fff;
    cursor: pointer;
    border-radius: 5px;
    font-size: 14px;
    transition: background-color 0.3s ease;
        }

        /* Gaya ketika status active */
        .process-btn.active {
            background-color: green;
            /* Atur warna latar belakang sesuai keinginan */
        }

        /* Gaya ketika status inactive */
        .process-btn.inactive {
            background-color: red;
            /* Atur warna latar belakang sesuai keinginan */
        }
    </style>
    <title>Dashboard</title>
</head>

<body>
    <section id="menu">
        <div class="logo">
            <img src="../../img/logo.png" width="100PX">
            <h2>JAVA JUNCTION</h2>
        </div>
        <div class="items">
            <li><a href="../dashboard/index.php">Dashboard</a></li>
            <li><a href="../orders/index.php">List Orders</a></li>
            <li><a href="../orders/live.php">List Orders ( live )</a></li>
            <li class="active"><a href="index.php">Admin</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </div>
    </section>

    <section id="interface">
        <div class="navigation">
            <div class="add-btn">
                <i class="far fa-bell"></i>
                <a href="../register.php">Add New Admin</a>
            </div>
        </div>

        <h3 class="i-name">
            Administrator
        </h3>

        <div class="board" id="board">
            <table width="100%">
                <thead>
                    <tr>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Activeted</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin) : ?>
                        <tr>
                            <td class="people">
                                <div class="people-desk">
                                    <h5><?= $admin["username"] ?></h5>
                                </div>
                            </td>
                            <td class="people_des">
                                <p><?= $admin["email"] ?></p>
                            </td>
                            <td class="people_des">
                                <!-- Di dalam loop foreach di HTML: -->
                                <form action="" method="post">
                                    <input type="hidden" name="username" value="<?= $admin["username"] ?>">
                                    <button type="submit" name="activated" class="process-btn <?= ($admin["status_active"] == 'yes') ? 'active' : 'inactive' ?>">
                                        <?= $admin["status_active"] ?>
                                    </button>
                                </form>
                            </td>
                            <td class="delete">
                                <a href="delete.php?id=<?= $admin["id_admin"]; ?>" onclick="return confirm('yakin?');">Hapus</a>
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