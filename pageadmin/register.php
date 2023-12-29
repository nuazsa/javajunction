<?php

require_once '../component/functions.php';

// buka sesi
session_start();


$error = '';
$hasil = true;

if (!empty($_POST)) {
    try {
        if (!$conn) {
            throw new Exception("Koneksi ke database gagal: " . $conn->connect_error);
        }

        // Cek apakah username atau email sudah ada dalam database
        $check_stmt = $conn->prepare("SELECT COUNT(*) FROM `administrator` WHERE username = :username OR email = :email");
        $check_stmt->bindParam(':username', $_POST['username']);
        $check_stmt->bindParam(':email', $_POST['email']);
        $check_stmt->execute();
        $count = $check_stmt->fetchColumn();

        if ($count > 0) {
            $hasil = false;
            throw new Exception("Username atau email sudah terdaftar.");
        } else {
            // Jika tidak ada masalah, lanjutkan dengan penyisipan
            $stmt = $conn->prepare("INSERT INTO `administrator`(`username`, `email`, `password`) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $_POST['username']);
            $stmt->bindParam(':email', $_POST['email']);
            $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->execute();
            
            header("Location: login.php");
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
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
                <h1>REGISTER ADMIN</h1>
                <hr>
                <p class="error"><?php
                if(!$hasil){
                    echo 'Username atau email sudah terdaftar';
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