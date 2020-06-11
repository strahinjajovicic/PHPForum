<?php
include 'connect.php';
include 'header.php';
$GLOBALS["con"] = connection();

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	//onemogucavamo pristup komentarisanju direktno
	echo 'This file cannot be called directly.';
}
else
{
	//proveravamo da li je korisnik ulogovan
	if(!isset($_SESSION['ulogovan']))
	{
		echo 'Morate biti ulogovani da biste mogli da komentarišete.';
	}
	else
	{
            if($_SESSION['tip_korisnika'] == 0) {
		$sql = "INSERT INTO 
					komentari(sadrzaj,
						  datum,
						  post_id,
						  korisnik_id) 
				VALUES ('" . $_POST['tekst'] . "',
						NOW(),
						" . $_GET['id'] . ",
						" . $_SESSION['korisnik_id'] . ")";
						
		$result = mysqli_query($GLOBALS["con"], $sql);
						
		if(!$result)
		{
			echo 'Vaš odgovor nije sačuvan. Molimo Vas da pokušate kasnije.';
		}
		else
		{
                        $redirect = $_GET['id'];
                        header("Location: post.php?id=$redirect");
		}
            }
            else {
                $sql = "INSERT INTO 
					komentari(sadrzaj,
						  datum,
                                                  odobren,
						  post_id,
						  korisnik_id) 
				VALUES ('" . $_POST['tekst'] . "',
						NOW(),
                                                1,
						" . $_GET['id'] . ",
						" . $_SESSION['korisnik_id'] . ")";
						
		$result = mysqli_query($GLOBALS["con"], $sql);
						
		if(!$result)
		{
			echo 'Vaš odgovor nije sačuvan. Molimo Vas da pokušate kasnije.';
		}
		else
		{
                        $redirect = $_GET['id'];
                        header("Location: post.php?id=$redirect");
		}
            }
	}
}

include 'footer.php';
?>