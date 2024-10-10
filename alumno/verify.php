<?php
session_start();

if (!isset($_SESSION['CURP'])) {
    header("Location: login.php");
    exit();
}
?>
