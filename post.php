<?php
include 'connect.php';
include 'header.php';

$GLOBALS["con"] = connection();
$id = $_GET['id'];
$sql = "SELECT
			post_id,
			naziv
		FROM
			postovi
		WHERE
			postovi.post_id = " . $_GET['id'];
			
$result = mysqli_query($GLOBALS["con"], $sql);

if(!$result)
{
	echo 'Nije moguće prikazati post, molimo Vas da pokušate kasnije.';
}
else
{
	if(mysqli_num_rows($result) == 0)
	{
            echo 'Ovaj post ne postoji.';
	}
	else
	{
		while($row = mysqli_fetch_assoc($result))
		{
                    echo '<div class="container"><table id="tabelaPost">
			<tr>
                            <th colspan="2">' . $row['naziv'] . '</th>
			</tr>';
                    
                    if(isset($_GET['komentar_id']) and isset($_GET['funkcija'])){
                        $idKomentara = $_GET['komentar_id'];
                        $funkcija = $_GET['funkcija'];
                        if($funkcija=='rejtingPlus'){
                            $query1 = "INSERT INTO provera(lajkovao, komentar_id, korisnik_id) VALUES (1, $idKomentara, '" . $_SESSION['korisnik_id'] . "')";
                            $resultINsert = mysqli_query($GLOBALS["con"], $query1);
                            $query = "UPDATE komentari SET rejting=rejting+1 WHERE komentar_id=$idKomentara";
                            header("Location: post.php?id=". $_GET['id'] ."");
                        }
                        else{
                            $query1 = "INSERT INTO provera(dislajkovao, komentar_id, korisnik_id) VALUES (1, $idKomentara, '" . $_SESSION['korisnik_id'] . "')";
                            $resultINsert = mysqli_query($GLOBALS["con"], $query1);
                            $query = "UPDATE komentari SET rejting=rejting-1 WHERE komentar_id=$idKomentara";
                            header("Location: post.php?id=". $_GET['id'] ."");
                        }
                        $rez = mysqli_query($GLOBALS["con"], $query);
                        
                    }
                    
			$posts_sql = "SELECT
                                                komentari.komentar_id,
						komentari.post_id,
						komentari.sadrzaj,
						komentari.datum,
						komentari.korisnik_id as korisnik_id,
                                                komentari.rejting,
						korisnici.korisnicko_ime
					FROM
						komentari
					LEFT JOIN
						korisnici
					ON
						komentari.korisnik_id = korisnici.korisnik_id
					WHERE
						komentari.post_id = " . $_GET['id'] . " and komentari.odobren = 1
                                        ORDER BY komentari.komentar_id asc";
						
			$posts_result = mysqli_query($GLOBALS["con"], $posts_sql);
                        
                        
			if(isset($_SESSION['tip_korisnika'])){
                            $tip = $_SESSION['tip_korisnika'];
                        }
                        else {
                            $tip = 0;
                        }
                        
			if(!$posts_result)
			{
                            echo '<tr><td>Nije moguće prikazati post. Molimo pokušajte kasnije.</tr></td></table>';
			}
			else
			{
                            if($tip == 2){
				while($posts_row = mysqli_fetch_assoc($posts_result))
				{
                                    $queryCheck = "SELECT lajkovao, dislajkovao FROM provera WHERE korisnik_id = '".$posts_row['korisnik_id']."' and komentar_id = ".$posts_row['komentar_id'];
                                    $resultCheck = mysqli_query($GLOBALS["con"], $queryCheck);
                                    $rowCheck = mysqli_fetch_assoc($resultCheck);
                                    
					echo '<tr>
						<td id="levaStrana"><a href="user.php?id=' . $posts_row['korisnik_id'] . '">' . $posts_row['korisnicko_ime'] . '</a><br/>' . date('d-m-Y H:i', strtotime($posts_row['datum'])) . '</td>
						<td id="desnaStrana">
                                                    <div align="center" style="width: 100%; max-height: 90%; height: 120px">
                                                        <div style="float:left; width: 3%; padding: 10px;">
                                                        <div align="center">';
                                                        if($rowCheck['lajkovao'] == 0 && $rowCheck['dislajkovao'] == 0){
                                                            echo '<div><a id="rejtingPlus" href="post.php?id=' . $_GET['id'] . '&komentar_id=' . $posts_row['komentar_id'] . '&funkcija=rejtingPlus" class="glyphicon glyphicon-arrow-up"></a></div>';
                                                            echo  '<div><text>'. $posts_row['rejting'] .'</text></div>';
                                                            echo '<div><a id="rejtingMinus" href="post.php?id=' . $_GET['id'] . '&komentar_id=' . $posts_row['komentar_id'] . '&funkcija=rejtingMinus" class="glyphicon glyphicon-arrow-down"></a></div>';
                                                            
                                                        }
                                                        else {
                                                            echo '<div><a id="rejtingPlus" href="" class="glyphicon glyphicon-arrow-up"></a></div>';
                                                            echo  '<div><text>'. $posts_row['rejting'] .'</text></div>';
                                                            echo '<div><a id="rejtingMinus" href="" class="glyphicon glyphicon-arrow-down"></a></div>';
                                                            
                                                        }
                                                echo '</div>'
                                                . '</div>'
                                                . '<div style="float:right; width: 96%; max-height: 90%"><textarea style="width: 100%;padding: 5px; background-color: #F8F8FF; resize: none" rows="5" readonly>' . htmlentities(stripslashes($posts_row['sadrzaj'])) . '</textarea><br><br></div>
                                                    </div>
                                                    <div class="pull-right">
                                                        <div style="float: left;"><a href="editPost.php?id=' . $posts_row['komentar_id'] . '&post_id=' . $_GET['id'] . '" class="btn btn-default">Izmeni</a></div>                                                             
                                                        <div style="float: right;"><a href="deleteComment.php?id=' . $posts_row['komentar_id'] . '&post_id=' . $_GET['id'] . '" class="btn btn-warning">Obriši</a></div>  
                                                    </div>
                                                    </td>
                                            </tr>';
                                        
                                            }
                            }
                            else {
                                if(!isset($_SESSION['ulogovan'])){
                                while($posts_row = mysqli_fetch_assoc($posts_result)){
                                    $queryCheck1 = "SELECT lajkovao, dislajkovao FROM provera WHERE korisnik_id = '".$posts_row['korisnik_id']."' and komentar_id = ".$posts_row['komentar_id'];
                                    $resultCheck1 = mysqli_query($GLOBALS["con"], $queryCheck1);
                                    $rowCheck1 = mysqli_fetch_assoc($resultCheck1);
                                    echo '<tr>
						<td id="levaStrana"><h4>' . $posts_row['korisnicko_ime'] . '</h4><br/>' . date('d-m-Y H:i', strtotime($posts_row['datum'])) . '</td>
						<td id="desnaStrana">
                                                    <div width="100%">
                                                        <div align="center" style="float:left; width: 4%; padding: 10px;">';
                                                        if($rowCheck1['lajkovao'] == 0 && $rowCheck1['dislajkovao'] == 0){
                                                            echo '<div><a id="rejtingPlus" href="post.php?id=' . $_GET['id'] . '&komentar_id=' . $posts_row['komentar_id'] . '&funkcija=rejtingPlus" class="glyphicon glyphicon-arrow-up"></a></div>';
                                                            echo  '<div><text>'. $posts_row['rejting'] .'</text></div>';
                                                            echo '<div><a id="rejtingMinus" href="post.php?id=' . $_GET['id'] . '&komentar_id=' . $posts_row['komentar_id'] . '&funkcija=rejtingMinus" class="glyphicon glyphicon-arrow-down"></a></div>';
                                                            
                                                        }
                                                        else {
                                                            echo '<div><a id="rejtingPlus" href="" class="glyphicon glyphicon-arrow-up"></a></div>';
                                                            echo  '<div><text>'. $posts_row['rejting'] .'</text></div>';
                                                            echo '<div><a id="rejtingMinus" href="" class="glyphicon glyphicon-arrow-down"></a></div>';
                                                            
                                                        }
                                                echo '</div>'
                                                . '<div style="float:right; width: 96%; max-height: 90%"><textarea style="width: 100%;padding: 5px; background-color: #F8F8FF; resize: none" rows="5" readonly>' . htmlentities(stripslashes($posts_row['sadrzaj'])) . '</textarea><br><br></div>
                                                    </div>
                                                    </td>
                                            </tr>';
                                    }
                                }
                                
                                else {
                                while($posts_row = mysqli_fetch_assoc($posts_result)){
                                    $queryCheck2 = "SELECT lajkovao, dislajkovao FROM provera WHERE korisnik_id = '".$posts_row['korisnik_id']."' and komentar_id = ".$posts_row['komentar_id'];
                                    $resultCheck2 = mysqli_query($GLOBALS["con"], $queryCheck2);
                                    $rowCheck2 = mysqli_fetch_assoc($resultCheck2);
                                    if($posts_row['korisnicko_ime'] === $_SESSION['korisnicko_ime']){
                                    echo '<tr>
						<td id="levaStrana"><a href="user.php?id=' . $posts_row['korisnik_id'] . '">' . $posts_row['korisnicko_ime'] . '</a><br/>' . date('d-m-Y H:i', strtotime($posts_row['datum'])) . '</td>
						<td id="desnaStrana">
                                                    <div width="100%">
                                                        <div align="center" style="float:left; width: 4%; padding: 10px;">';
                                                        if($rowCheck2['lajkovao'] == 0 && $rowCheck2['dislajkovao'] == 0){
                                                            echo '<div><a id="rejtingPlus" href="post.php?id=' . $_GET['id'] . '&komentar_id=' . $posts_row['komentar_id'] . '&funkcija=rejtingPlus" class="glyphicon glyphicon-arrow-up"></a></div>';
                                                            echo  '<div><text>'. $posts_row['rejting'] .'</text></div>';
                                                            echo '<div><a id="rejtingMinus" href="post.php?id=' . $_GET['id'] . '&komentar_id=' . $posts_row['komentar_id'] . '&funkcija=rejtingMinus" class="glyphicon glyphicon-arrow-down"></a></div>';
                                                            
                                                        }
                                                        else {
                                                            echo '<div><a id="rejtingPlus" href="" class="glyphicon glyphicon-arrow-up"></a></div>';
                                                            echo  '<div><text>'. $posts_row['rejting'] .'</text></div>';
                                                            echo '<div><a id="rejtingMinus" href="" class="glyphicon glyphicon-arrow-down"></a></div>';
                                                            
                                                        }
                                                echo '</div>'
                                                . '<div style="float:right; width: 96%; max-height: 90%"><textarea style="width: 100%;padding: 5px; background-color: #F8F8FF; resize: none" rows="5" readonly>' . htmlentities(stripslashes($posts_row['sadrzaj'])) . '</textarea><br><br></div>
                                                    </div>
                                                    <div class="pull-right">
                                                    <div style="float: left;"><a href="editPost.php?id=' . $posts_row['komentar_id'] . '" class="btn btn-default">Izmeni</a></div>
                                                    <div style="float: right;"><a href="deleteComment.php?id=' . $posts_row['komentar_id'] . '&post_id=' . $_GET['id'] . '" class="btn btn-warning">Obriši</a></div>  
                                                    </div>
                                                    </td>
                                            </tr>';
                                    }
                                    else {
                                        echo '<tr>
						<td id="levaStrana"><h4>' . $posts_row['korisnicko_ime'] . '</h4><br/>' . date('d-m-Y H:i', strtotime($posts_row['datum'])) . '</td>
						<td id="desnaStrana">
                                                    <div width="100%">
                                                        <div align="center" style="float:left; width: 4%; padding: 10px;">';
                                                        if($rowCheck2['lajkovao'] == 0 && $rowCheck2['dislajkovao'] == 0){
                                                            echo '<div><a id="rejtingPlus" href="post.php?id=' . $_GET['id'] . '&komentar_id=' . $posts_row['komentar_id'] . '&funkcija=rejtingPlus" class="glyphicon glyphicon-arrow-up"></a></div>';
                                                            echo  '<div><text>'. $posts_row['rejting'] .'</text></div>';
                                                            echo '<div><a id="rejtingMinus" href="post.php?id=' . $_GET['id'] . '&komentar_id=' . $posts_row['komentar_id'] . '&funkcija=rejtingMinus" class="glyphicon glyphicon-arrow-down"></a></div>';
                                                            
                                                        }
                                                        else {
                                                            echo '<div><a id="rejtingPlus" href="" class="glyphicon glyphicon-arrow-up"></a></div>';
                                                            echo  '<div><text>'. $posts_row['rejting'] .'</text></div>';
                                                            echo '<div><a id="rejtingMinus" href="" class="glyphicon glyphicon-arrow-down"></a></div>';
                                                            
                                                        }
                                                echo '</div>'
                                                . '<div style="float:right; width: 96%; max-height: 90%"><textarea style="width: 100%;padding: 5px; background-color: #F8F8FF; resize: none" rows="5" readonly>' . htmlentities(stripslashes($posts_row['sadrzaj'])) . '</textarea><br><br></div>
                                                    </div>
                                                    </td>
                                            </tr>';
                                    }
                                }
                            }
			}
                        
                        echo '</table></div>';
			
			if(!isset($_SESSION['ulogovan']))
			{
                            echo '<hr>';
                            echo '<h4 align="center">Morate biti prijavljeni da biste komentarisali. Ako nemate nalog, možete ga napraviti <a href="registration.php">ovde</a>.</h4>';
			}
			else
			{
                            
                            echo '<div class="container"><form class="well form-horizontal" method="post" action="comment.php?id=' . $row['post_id'] . '" id="odgovori">';
                            echo '<fieldset>
                                    <legend>Postavite odgovor: </legend>
                                    <div class="form-group">
                                            <div class="col-md-8 inputGroupContainer">
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
		}
            }

        }

    }

include 'footer.php';
?>