<?php
session_start();
include 'connect.php';
$GLOBALS["con"] = connection();

if(isset($_SESSION['ulogovan']) && $_SESSION['tip_korisnika'] == 2){
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    if(isset($_POST['tip'])){
        $tip = $_POST['tip'];
    }
    
    $query = "UPDATE korisnici SET tip_korisnika = $tip WHERE korisnik_id = $id";
    $result = mysqli_query($GLOBALS["con"], $query);

    header("Location: userControl.php");
}
else {
    header("Location: 404error.php");
}
?>
