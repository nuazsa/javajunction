<?php

session_start();

require_once '../component/functions.php';

// Use prepared statement to prevent SQL injection
$update_status = $conn->prepare("UPDATE `administrator` SET `status_active`='no' ");
$update_status->execute();

$_SESSION['user'] = null;

unset($_SESSION['user']);

session_destroy();

header("Location: login.php");
