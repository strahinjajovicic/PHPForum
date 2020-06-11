<?php
include 'connect.php';
include 'header.php';
$GLOBALS["con"] = connection();

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	echo 'Do ove stranice ne možete doći direktno';
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
		$sql = "INSERT INTO 
					komentari_materijal(sadrzaj,
						  datum,
                                                  odobren,
						  materijal_id,
						  korisnik_id) 
				VALUES ('" . $_POST['tekst'] . "',
						NOW(),0,
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
                        header("Location: comment_material.php?id=$redirect");
		}
	}
}

include 'footer.php';
?>