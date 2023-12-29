<?php

// Inisialisasi
$db_host = 'localhost';
$db_name = 'javajunction';
$db_user_name = 'root';
$db_user_pass = '';

// Buat koneksi dengan PDO (php data objects)
try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user_name, $db_user_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
    die();
}

function query($query)
{
    global $conn;
    try {
        $stmt = $conn->query($query);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    } catch (PDOException $e) {
        echo "Query gagal: " . $e->getMessage();
        die();
    }
}

function upload()
{
    $namaFile = $_FILES['image']['name'];
    $ukuranFile = $_FILES['image']['size'];
    $error = $_FILES['image']['error'];
    $tmpName = $_FILES['image']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "
            <script>
                alert('Pilih gambar terlebih dahulu');
            </script>
        ";
        return false;
    }

    // cek ekstensi gambar yang diupload
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "
            <script>
                alert('Pilih gambar dengan format JPG, JPEG, atau PNG');
            </script>
        ";
        return false;
    }

    // cek ukuran gambar
    if ($ukuranFile > 1000000) {
        echo "
            <script>
                alert('Ukuran gambar terlalu besar (maksimal 1MB)');
            </script>
        ";
        return false;
    }

    // generate nama baru untuk file gambar
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    // pindahkan file gambar ke lokasi tujuan
    move_uploaded_file($tmpName, '../../img/' . $namaFileBaru);

    return $namaFileBaru;
}


function tambah($data)
{
    global $conn;

    $category = htmlspecialchars($data["category"]);
    $name = htmlspecialchars($data["name"]);
    $description = htmlspecialchars($data["description"]);
    $price = htmlspecialchars($data["price"]);
    $status = htmlspecialchars($data["status"]);
    $stock = htmlspecialchars($data["stock"]);

    $image = upload();
    if (!$image) {
        return false;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO products (product_name, description, category, status, price, stock,  image) VALUES (:name, :description, :category, :status, :price, :stock, :image)");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':image', $image);
        $stmt->execute();

        return $stmt->rowCount(); // Mengembalikan jumlah baris yang terpengaruh oleh operasi query
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}


function ubah($data)
{
    global $conn;
    // ambil data dari tiap elemen
    $id = ($data["id"]);
    $name = htmlspecialchars($data["name"]);
    $description = htmlspecialchars($data["description"]);
    $category = htmlspecialchars($data["category"]);
    $status = htmlspecialchars($data["status"]);
    $price = htmlspecialchars($data["price"]);
    $lastImage = htmlspecialchars($data["lastImage"]);
    $stock = htmlspecialchars($data["stock"]);

    // cek apakah user memilih image baru
    if ($_FILES['image']['error'] === 4) {
        $image = $lastImage;
    } else {
        $image = upload();
    }

    try {
        $stmt = $conn->prepare("UPDATE products SET product_name =:name, description =:description, category =:category, price =:price, status =:status, stock =:stock, image =:image WHERE id_product =:id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount(); // Mengembalikan jumlah baris yang terpengaruh oleh operasi query
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function hapus($id)
{
    global $conn;

    try {
        $stmt = $conn->prepare("DELETE FROM products WHERE id_product =:id");
        $stmt->bindParam('id', $id);
        $stmt->execute();

        return $stmt->rowCount(); // Mengembalikan jumlah baris yang terpengaruh oleh operasi query
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function hapus_admin($id)
{
    global $conn;

    try {
        $stmt = $conn->prepare("DELETE FROM administrator WHERE id_admin =:id");
        $stmt->bindParam('id', $id);
        $stmt->execute();

        return $stmt->rowCount(); // Mengembalikan jumlah baris yang terpengaruh oleh operasi query
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}


function create_unique_id()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 20; $i++) {
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function create_unique_invoice()
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 12; $i++) {
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function showErrorMessageAndRedirect($message, $redirectTo)
{
    echo "
        <script>
            alert('$message');
            document.location.href = '$redirectTo';
        </script>
    ";
    exit();
}
