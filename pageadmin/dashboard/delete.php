<?php
session_start();

// cek session
if ( !isset($_SESSION["user"])){
    header ("Location: ../login.php");
    exit;
};

require '../../component/functions.php';


$id = $_GET["id"];

if ( hapus($id) > 0){
    echo "
            <script>
                alert('data berhasil dihapus');
                document.location.href = 'index.php';
            </script>
            ";
    } else {
        echo "
        <script>
            alert('data gagal dihapus');
            document.location.href = 'index.php';
        </script>
        ";
    };


?>