<?php
session_start();
include ("connect.php");
$GLOBALS["con"] = connection();

if(isset($_SESSION['ulogovan'])){
    $id = $_SESSION['korisnik_id'];
    $old = $_POST['oldPassword'];
    $new = $_POST['password1'];
    $repeat = $_POST["password2"];

    $new_hash = password_hash($new, PASSWORD_DEFAULT);

    $queryVerify = "SELECT lozinka FROM korisnici WHERE korisnik_id = $id";
    $resultVerify = mysqli_query($GLOBALS["con"], $queryVerify);
    $resVerify = mysqli_fetch_assoc($resultVerify);

    $verify = password_verify($old, $resVerify['lozinka']);

    if($verify) {
        if($new === $repeat) {
        $query = "UPDATE korisnici SET lozinka = '$new_hash' WHERE korisnik_id = $id";
        $result = mysqli_query($GLOBALS["con"], $query);

            if (!$result) {
                die("Došlo je do greške prilikom promene lozinke  " . mysqli_error($GLOBALS["conn"]));
            }
            echo 'Uspešno ste promenili lozinku';
        header("refresh:5;url=user.php?id=$id");
        }
        else {
            die("Došlo je do greške prilikom promene lozinke");
        }
    } else {
        echo 'Niste uneli dobru lozinku!';
        header("refresh:5;url=user.php?id=$id");
    }
}
else {
    header("Location: 404error.php");
}


