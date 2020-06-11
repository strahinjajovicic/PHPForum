<?php
//signout.php
include 'connect.php';
session_start();

//check if user if signed in
if($_SESSION['ulogovan'] == true)
{
        session_destroy();

	echo 'Uspešno ste se odjavili. Hvala na poseti.';
        header("Location: index.php");
}
else
{
	echo 'Niste prijavljeni. Da li želite da <a href="prijava.php">se prijavite</a>?';
        header("Location: index.php");
}

?>