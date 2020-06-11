<?php
session_start();
include 'connect.php';
$GLOBALS["con"] = connection();

if(isset($_SESSION['ulogovan'])){
    $query = "DELETE FROM predmeti WHERE predmet_id = " . $_GET['id'];
    $result = mysqli_query($GLOBALS["con"], $query);

    header("Location: materijali.php");
}
else {
    header("Location: 404error.php");
}

?>

