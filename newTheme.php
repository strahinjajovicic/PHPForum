<?php
//create_cat.php
include 'connect.php';
include 'header.php';
$GLOBALS["con"] = connection();

if(!isset($_SESSION['ulogovan']))
{
	//korisnik nije ulogovan, posalji ga na 404 page
	header("Location: 404error.php");
}
else
{
	if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
            echo ' <form class="well form-horizontal" method="post" action="" id="kreirajTemuForma">';
                             
            echo '<fieldset>';
                                
            echo '<legend align="center">Dodajte novu temu</legend>';
		//the form hasn't been posted yet, display it
            echo '<div class="form-group">
                    <label class="col-md-2 control-label">Naziv</label>  
                        <div class="col-md-8 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
                                <input  name="temaNaslov" placeholder="Unesite naziv" class="form-control"  type="text">
                            </div>
                        </div>
                  </div>';
            echo '<div class="form-group">
                    <label class="col-md-2 control-label">Godina</label>  
                        <div class="col-md-8 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
                                <select name="temaGodina" class="form-control">
                                    <option value="1">Prva</option>
                                    <option value="2">Druga</option>
                                    <option value="3">Treća</option>
                                </select>
                            </div>
                        </div>
                  </div>';
	    echo '<div class="form-group">
                    <label class="col-md-2 control-label">Opis teme</label>
                    <div class="col-md-8 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                            <textarea rows="6" class="form-control" name="opis" placeholder="Unesite opis"></textarea>
                        </div>
                    </div>
                  </div>';
            echo '<div class="form-group">
                    <label class="col-md-5 control-label"></label>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-warning" >Unos<span class="glyphicon glyphicon-send"></span></button>
                    </div>
                  </div>';
                                
            echo '</fieldset>
                    </form>';
	}
	else
	{
            if($_SESSION['tip_korisnika'] == 0) {
		//forma je postavljena, sacuvaj je
		$sql = "INSERT INTO teme(naziv, godina, opis, korisnik_id)
		   VALUES('" . $_POST['temaNaslov'] . "', '" . $_POST['temaGodina'] . "',
				 '" . $_POST['opis'] . "', '" . $_SESSION['korisnik_id'] . "')";
		$result = mysqli_query($GLOBALS["con"], $sql);
		if(!$result)
		{
			//something went wrong, display the error
			mysqli_error("Greska");
		}
		else
		{
			echo 'Uspešno ste dodali temu.';
		}
            }
            else {
                //forma je postavljena, sacuvaj je
		$sql = "INSERT INTO teme(naziv, godina, opis, odobren, korisnik_id)
		   VALUES('" . $_POST['temaNaslov'] . "', '" . $_POST['temaGodina'] . "',
				 '" . $_POST['opis'] . "', 1, '" . $_SESSION['korisnik_id'] . "')";
		$result = mysqli_query($GLOBALS["con"], $sql);
		if(!$result)
		{
			//something went wrong, display the error
			mysqli_error("Greska");
		}
		else
		{
			echo 'Uspešno ste dodali temu.';
		}
            }
	}
}

include 'footer.php';
?>
