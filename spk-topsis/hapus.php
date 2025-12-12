<?php
include 'koneksi.php';
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM website WHERE id_web='$id'");
header("location:data_website.php");
?>