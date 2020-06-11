<?php
session_start();
include 'connect.php';
$GLOBALS["con"] = connection();

if(isset($_SESSION['ulogovan'])){
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    
    $postId = $_GET['post_id'];
    $queryCheck = "SELECT min(komentar_id) as komentar_id FROM komentari WHERE post_id = $postId";
    $resultQueryCheck = mysqli_query($GLOBALS["con"], $queryCheck);
    $row = $resultQueryCheck->fetch_assoc();

    if($row['komentar_id'] === $id){
        $query = "DELETE FROM postovi WHERE post_id = $postId";
        $result = mysqli_query($GLOBALS["con"], $query);
        header("Location: index.php");
    }
    else {
        $query = "DELETE FROM komentari WHERE komentar_id = $id";
        $result = mysqli_query($GLOBALS["con"], $query);
        header("Location: post.php?id=$postId");
    }
}
else {
    header("Location: 404error.php");
}

?>

