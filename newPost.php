<?php
include 'connect.php';
include 'header.php';

$GLOBALS["con"] = connection();

if(isset($_GET['id'])){
    $id = $_GET['id'];
}

if(isset($_SESSION['ulogovan']) == false)
{
	//korisnik nije ulogovan, stoga ne može da doda novi post
	echo 'Izvinjavamo se, niste <a href="login.php">prijavljeni</a> i ne možete da kreirate post.<hr>';
}
else
{
	//korisnik je ulogovan
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{	
		$sql = "SELECT
					tema_id,
					naziv,
					opis
				FROM
					teme";
		
		$result = mysqli_query($GLOBALS["con"], $sql );
		
		if(!$result)
		{
			//greska
			echo 'Greška pri radu sa bazom podataka. Pokušajte kasnije.';
		}
		else
		{
			if(mysqli_num_rows($result) == 0)
			{
				//proveravamo da li je korisnik obican korisnik
				if($_SESSION['tip_korisnika'] == 0)
				{
					echo 'Još uvek nema kreiranih tema.';
				}
				else
				{
					echo 'Pre nego što kreirate post, morate sačekati da admin ili moderator kreiraju temu.';
				}
			}
			else
			{
		
				echo '
                                            <form class="well form-horizontal" method="post" action="" id="kreirajPostForma">';
                                            
				
                                echo '<fieldset>';
                                
                                echo '<legend align="center">Dodajte novi post</legend>';
                                
                                echo '<div class="form-group" >
                                        <label class="col-md-2 control-label">Naslov</label>  
                                            <div class="col-md-8 inputGroupContainer">
                                                <div width="80%" class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
                                                    <input  name="postOpis" placeholder="Unesite naslov" class="form-control"  type="text">
                                                </div>
                                            </div>
                                        </div>';
                                
                                echo '<div class="form-group"> 
                                            <label class="col-md-2 control-label">Tema</label>
                                        <div class="col-md-8 selectContainer">
                                            <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                                            <select name="temaID" class="form-control selectpicker">';
                                
                                if($id){
                                    $sqlTheme = "SELECT tema_id, naziv FROM teme WHERE tema_id=$id";
                                    $resultTheme = mysqli_query($GLOBALS["con"], $sqlTheme);
                                    $rowTheme = mysqli_fetch_assoc($resultTheme);
                                    
                                    echo            '<option value="' . $rowTheme['tema_id'] . '">'. $rowTheme['naziv'] .'</option>';
                                }
                                else {
                                    echo            '<option>Odaberite temu</option>';
					while($row = mysqli_fetch_assoc($result))
					{
						echo '<option value="' . $row['tema_id'] . '">' . $row['naziv'] . '</option>';
					}
                                }
				echo '      </select>
                                            </div>
                                        </div>
                                     </div>';	
				echo '<div class="form-group">
                                        <label class="col-md-2 control-label">Tekst posta</label>
                                            <div class="col-md-8 inputGroupContainer">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                                                    <textarea rows="6" class="form-control" name="tekst" placeholder="Unesite tekst"></textarea>
                                                </div>
                                            </div>
                                      </div>';
				
                                echo '<div class="form-group" style="margin: 0 auto;">
                                        <label class="col-sm-5 control-label"></label>
                                            <div class="col-sm-4">
                                                <button type="submit" class="btn btn-warning" >Unos<span class="glyphicon glyphicon-send"></span></button>
                                            </div>
                                    </div>';
                                
                                echo '</fieldset>
                                    </form>'; 
			}
		}
	}
	else
	{
		//pocni transakciju
		$query  = "BEGIN WORK;";
		$result = mysqli_query($GLOBALS["con"], $query );
		
		if(!$result)
		{
			//query nije prošao
			echo 'Desila se greška pri kreiranju Vašeg posta. Molimo Vas da pokušate kasnije.';
		}
		else
		{
			//insertujemo u tabelu postovi
			$sql = "INSERT INTO 
						postovi(naziv,
							   datum,
							   tema_id,
							   korisnik_id)
				   VALUES('" . $_POST['postOpis'] . "',
							   NOW(),
							   " . $_POST['temaID'] . ",
							   " . $_SESSION['korisnik_id'] . "
							   )";
			
			$result = mysqli_query($GLOBALS["con"], $sql);
			if(!$result)
			{
				//desila se greška
				echo 'Desila se greška pri radu sa bazom podataka. Molimo Vas da pokušate kasnije.<br /><br />';
				$sql = "ROLLBACK;";
				$result = mysqli_query($GLOBALS["con"], $sql);
			}
			else
			{
				//kada je prošao prvi query, krećemo naredni
				//uzimamo id sveže kreiranog posta kako bi ga koristili u query-ju za komentare
                            if($_SESSION['tip_korisnika'] == 0) {
				$postid = mysqli_insert_id($GLOBALS["con"]);
				
				$sql = "INSERT INTO
							komentari(sadrzaj,
								  datum,
								  post_id,
								  korisnik_id)
						VALUES
							('" . $_POST['tekst'] . "',
								  NOW(),
								  " . $postid . ",
								  " . $_SESSION['korisnik_id'] . "
							)";
                                
				$result = mysqli_query($GLOBALS["con"], $sql);
				
				if(!$result)
				{
					//desila se greška
					echo 'Desila se greška prilikom pravljenja Vašeg komentara. Molimo pokušajte ponovo.<br /><br />' . mysql_error();
					$sql = "ROLLBACK;";
					$result = mysqli_query($GLOBALS["con"], $sql);
				}
				else
				{
					$sql = "COMMIT;";
					$result = mysqli_query($GLOBALS["con"], $sql);
                                        
					//sve je uspešno završeno
					echo 'Uspešno ste kreirali <a href="post.php?id='. $postid . '">Vaš novi post</a>.';
				}
                            }
                            else {
                                $postid = mysqli_insert_id($GLOBALS["con"]);
				
				$sql = "INSERT INTO
							komentari(sadrzaj,
								  datum,
                                                                  odobren,
								  post_id,
								  korisnik_id)
						VALUES
							('" . $_POST['tekst'] . "',
								  NOW(),
                                                                  1,
								  " . $postid . ",
								  " . $_SESSION['korisnik_id'] . "
							)";
                                
				$result = mysqli_query($GLOBALS["con"], $sql);
				
				if(!$result)
				{
					//desila se greška
					echo 'Desila se greška prilikom pravljenja Vašeg komentara. Molimo pokušajte ponovo.<br /><br />' . mysql_error();
					$sql = "ROLLBACK;";
					$result = mysqli_query($GLOBALS["con"], $sql);
				}
				else
				{
					$sql = "COMMIT;";
					$result = mysqli_query($GLOBALS["con"], $sql);
                                        
					//sve je uspešno završeno
					echo 'Uspešno ste kreirali <a href="post.php?id='. $postid . '">Vaš novi post</a>.';
				}
                            }
			}
		}
	}
}

include 'footer.php';
?>
