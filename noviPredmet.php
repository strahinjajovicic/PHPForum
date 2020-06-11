<?php
session_start();
include 'connect.php';
$GLOBALS["con"] = connection();

if(isset($_SESSION['ulogovan'])){
    $postHeader = $_GET['post_id'];
    $naziv = $_POST['nazivPredmeta'];
    $godina = $_POST['godina'];
    $query = "INSERT INTO predmeti(naziv, godina) VALUES ('$naziv', $godina)";
    $result = mysqli_query($GLOBALS["con"], $query);

    if (!file_exists("materijali/$naziv")) {
        mkdir("materijali/$naziv", 0777, true);
    }

    header("Location: materijali.php");
}
else {
    header ("Location: 404error.php");
}
?>

