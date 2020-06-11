<?php
session_start();
include 'connect.php';
$GLOBALS["con"] = connection();

if(isset($_SESSION['ulogovan'])){
    $query = "DELETE FROM postovi WHERE post_id = " . $_GET['id'];
    $result = mysqli_query($GLOBALS["con"], $query);

    header("Location: index.php");
}
else {
    header("Location: 404error.php");
}

?>
