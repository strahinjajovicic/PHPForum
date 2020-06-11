<?php
session_start();
include 'connect.php';
$GLOBALS["con"] = connection();

if(isset($_SESSION['ulogovan'])){
    $query = "DELETE FROM korisnici WHERE korisnik_id = " . $_GET['id'];
    $result = mysqli_query($GLOBALS["con"], $query);
    $query1 = "DELETE FROM postovi WHERE korisnik_id = " . $_GET['id'];
    $result1 = mysqli_query($GLOBALS["con"], $query1);
    $query2 = "DELETE FROM teme WHERE korisnik_id = " . $_GET['id'];
    $result2 = mysqli_query($GLOBALS["con"], $query2);
    $query3 = "DELETE FROM komentari_materijal WHERE korisnik_id = " . $_GET['id'];
    $result3 = mysqli_query($GLOBALS["con"], $query3);
    $query4 = "DELETE FROM komentari WHERE korisnik_id = " . $_GET['id'];
    $result4 = mysqli_query($GLOBALS["con"], $query4);
    
    header("Location: changePermission.php");
}
else {
    header("Location: 404error.php");
}

?>
