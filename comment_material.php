<?php
include 'connect.php';
include 'header.php';
$GLOBALS["con"] = connection();

if(isset($_GET['id'])){
    $id = $_GET['id'];
}

$query = "SELECT * FROM materijali WHERE materijal_id = $id";
$result = mysqli_query($GLOBALS["con"], $query);
$korisnik = isset($_SESSION['korisnicko_ime']);

//proverava se da li je korisnik ulogovan
if(!isset($_SESSION['ulogovan']))
{
    echo 'Morate biti ulogovani da biste mogli da komentarišete.';
}
else
{
    while ($row = mysqli_fetch_assoc($result)){
        echo '<div class="col-sm-9">
                <embed src="'. $row['put'] .'" width="100%" height="600px" />
              </div>';
    }
    
    $sql = "SELECT
                    komentari_materijal.komentar_id,
                    komentari_materijal.materijal_id,
                    komentari_materijal.sadrzaj,
                    komentari_materijal.datum,
                    komentari_materijal.korisnik_id,
                    korisnici.korisnicko_ime
		FROM
                    komentari_materijal
		LEFT JOIN
                    korisnici
		ON
                    komentari_materijal.korisnik_id = korisnici.korisnik_id
		WHERE
                    komentari_materijal.materijal_id = $id
                ORDER BY komentari_materijal.komentar_id asc";
    
    $resultSql = mysqli_query($GLOBALS["con"], $sql);
    
    if(!$resultSql){
        echo '<p>Ne postoji nista za prikaz</p>';
    }
    
    else {
        echo '<div class="col-sm-9">
                <table class="table">';
                    
                    while($rowSql = mysqli_fetch_assoc($resultSql)){
                    echo '<tr class="warning">
                            <td width="10%"><h4>' . $rowSql['korisnicko_ime'] . '</h4><br/>' . date('d-m-Y H:i', strtotime($rowSql['datum'])) . '</td>
                            <td width="90%">
                                <div width="100%">
                                    <textarea style="border: 0px; width: 100%;padding: 5px; resize: none" rows="5" readonly>' . htmlentities(stripslashes($rowSql['sadrzaj'])) . '</textarea>
                                </div>
                            </td>
                        </tr>';
                    }
                    echo '</table>
              </div>';
        
    
    }
        
    echo '<div class="col-sm-9"><form class="well form-horizontal" method="post" action="newCommentMat.php?id=' . $id . '" id="odgovori">';
    echo '<fieldset>
                <legend>Postavite komentar: </legend>
                <div class="form-group">
                    <div class="col-md-12 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                            <textarea id="tekst" rows="8" class="form-control" name="tekst" placeholder="Unesite tekst"></textarea>
                        </div>
                    </div>
                </div>
              <div class="form-group col-sm-1">
                <label class="control-label"></label>
                <div>
                    <button type="submit" class="btn btn-warning" >Postavi<span class="glyphicon glyphicon-send"></span></button>
                </div>
               </div>

               </fieldset>
               </form>
               </div>';
}



include 'footer.php';

?>