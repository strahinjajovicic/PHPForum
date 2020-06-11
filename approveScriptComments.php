<?php
session_start();
include 'connect.php';
$GLOBALS["con"] = connection();

if(isset($_SESSION['ulogovan'])){
    $id = $_GET['id'];
    $query = "UPDATE komentari SET odobren = 1 WHERE komentar_id = $id";
    $result = mysqli_query($GLOBALS["con"], $query);

    header("Location: approveComments.php");
}
else {
    header("Location: 404error.php");
}
?>