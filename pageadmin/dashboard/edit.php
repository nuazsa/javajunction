<?php
session_start();

require_once '../../component/functions.php';

// cek session
if (!isset($_SESSION["user"])) {
    // redirect jika tidak ada
    header("Location: ../login.php");
    exit;
}

// ambil data di URL
$id = $_GET["id_product"];
// query berdasarkan id
$category = query("SELECT * FROM products");
$product = query("SELECT * FROM products WHERE id_product = $id")[0];


// cek apakah tombol submit telah ditekan
if (isset($_POST["submit"])) {

    // cek apakah data berhasil ubah
    if (ubah($_POST) > 0) {
        echo "
            <script>
                alert('data berhasil diubah');
                document.location.href = 'index.php';
            </script>
            ";
    } else {
        echo "
        <script>
            alert('data gagal diubah');
            document.location.href = 'index.php';
        </script>
        ";
    };
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            display: flex;
            flex-direction: column;
            max-width: 90%;
            margin: 20px auto;
            padding-bottom: 20px;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .row {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2px 20px;
            border-bottom: 1px solid #ccc;
            /* Garis pemisah */
        }

        .col {
            flex: 1;
            padding: 20px;
        }

        .product-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product-details {
            display: flex;
            flex-direction: column;
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
        }

        .product-details ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .product-details li {
            margin-bottom: 15px;
        }

        .product-details label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .product-details input[type="text"],
        .product-details select,
        .product-details textarea,
        .product-details button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .back-btn,
        button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .back-btn {
            text-decoration: none;
            background-color: #ccc;
            color: #000;
            margin-right: 10px;
        }

        .back-btn:hover {
            background-color: #aaa;
        }

        button {
            background-color: #007bff;
            color: #fff;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
    <title>Product Form</title>
</head>

<body>

    <div class="container">

        <div class="row">
            <h1>EDIT PRODUCT</h1>
        </div>

        <div class="row">
            <div class="col product-image">
                <img src="../../img/<?= $product["image"] ?>" alt="<?= $product["product_name"] ?>">
            </div>


            <div class="col product-details">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $product["id_product"] ?>">
                    <input type="hidden" name="lastImage" value="<?= $product["image"] ?>">
                    <ul>
                        <li>
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" required value="<?= $product["product_name"] ?>">
                        </li>
                        <li>
                            <label for="category">Category:</label>
                            <select name="category" id="category" class="input" required>
                                <?php
                                $visitedCategories = [];

                                foreach ($category as $cat) {
                                    if (!in_array($cat['category'], $visitedCategories)) {
                                        $visitedCategories[] = $cat['category'];

                                ?>
                                        <option value="<?= $cat['category'] ?>" <?= ($cat['category'] == $product['category']) ? 'selected' : '' ?>><?= $cat['category'] ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" cols="30" rows="10"><?= $product["description"] ?></textarea>
                        </li>
                    </ul>
            </div>

            <div class="col product-details">
                <ul>
                    <li>
                        <label for="status">Status:</label>
                        <select name="status" id="status" class="input" required>
                            <option value="active" <?= ($product["status"] === 'active') ? 'selected' : '' ?>>Active</option>
                            <option value="draft" <?= ($product["status"] === 'draft') ? 'selected' : '' ?>>Draft</option>
                        </select>
                    </li>
                    <li>
                        <label for="price">Price:</label>
                        <input type="text" name="price" id="price" required value="<?= $product["price"] ?>">
                    </li>
                    <li>
                        <label for="stock">Stock:</label>
                        <input type="text" name="stock" id="stock" required value="<?= $product["stock"] ?>">
                    </li>
                    <li>
                        <label for="image">Image:</label>
                        <input type="file" name="image" id="image">
                    </li>
                    <li>
                        <a class="back-btn" href="../dashboard/index.php">Back</a>
                        <button type="submit" name="submit">Ubah Data!</button>
                    </li>
                </ul>
                </form>
            </div>
        </div>
    </div>

</body>

</html>