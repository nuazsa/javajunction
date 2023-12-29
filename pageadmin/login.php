<?php

require_once '../component/functions.php';

// buka sesi
session_start();


// nilai awal
$hasil = true;

// cek apakah tombol submit telah ditekan
if (isset($_POST['submit'])) {
    // Pastikan koneksi ke database sudah terbentuk
    if (!$conn) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Pastikan formulir tidak kosong
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $stmt = $conn->prepare("SELECT * FROM administrator WHERE email = :email");
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->execute();

        // Ambil data user
        $user = $stmt->fetch();

        // Jika query berhasil dijalankan
        if (!$user) {
            $hasil = false;
        } elseif (password_verify($_POST['password'], $user['password'])) {
            $hasil = true;
            $_SESSION['user'] = array(
                'id' => $user['id'],
                'name' => $user['username']
            );

            $username = $_POST['username'];

            // Use prepared statement to prevent SQL injection
            $update_status = $conn->prepare("UPDATE `administrator` SET `status_active`='yes' WHERE username = ?");
            $update_status->execute([$username]);
        
            // Use prepared statement to prevent SQL injection
            $update_status = $conn->prepare("UPDATE `administrator` SET `status_active`='no' WHERE username != ?");
            $update_status->execute([$username]);
            // Redirect
            header("Location: dashboard/index.php");
            exit;
        } else {
            $hasil = false;
        }
    }
}





?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login Admin</title>
</head>
<body>
    <div class="container">
        <div class="col">
            <form action="" method="post">
                <h1>LOGIN ADMIN</h1>
                <hr>
                <p class="error"><?php
                if(!$hasil){
                    echo 'email / password salah';
                };
                
                ?></p>
                <label for="username">Username :</label>
                <input type="text" name="username" id="username" required placeholder="admin user">
            
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" required placeholder="example@gmail.com">
            
                <label for="password">Password :</label>
                <input type="password" name="password" id="password" required placeholder="password">
            
                <button type="submit" name="submit">Login</button>
            </form>
        </div>
        <div class="col">
            <img src="../img/logo.png" alt="">
        </div>
    </div>
</body>
</html>