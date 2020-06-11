<?php
//category.php
include 'connect.php';
include 'header.php';
$GLOBALS["con"] = connection();

$id = $_GET['id'];
//prvo cemo da selektujemo temu na koju smo kliknuli pomocu $_GET['id']
$sql = "SELECT
			tema_id,
			naziv,
			opis
		FROM
			teme
		WHERE
			tema_id = " . $_GET['id'];

$result = mysqli_query($GLOBALS["con"], $sql);

if(!$result)
{
	mysqli_error("Teme nisu mogle biti prikazane, molimo Vas da pokušate kasnije.");
}
else
{
	if(mysqli_num_rows($result) == 0)
	{
		echo 'Ova tema ne postoji.';
	}
	else
	{
		//prikazi podatke unutar teme
		while($row = mysqli_fetch_assoc($result))
		{
			echo '<h4 style="float: left;"><b>' . $row['naziv'] . '</b></h4>';
		}
                
                if(isset($_SESSION['ulogovan'])){
                    echo '<a style="float: right;" class="glyphicon glyphicon-plus" href="newPost.php?id='.$id.'" data-toggle="tooltip" data-placement="bottom" title="Dodajte novi post"></a>';
                }
		//pravimo query za postove
		$sql = "SELECT
                            postovi.post_id,
                            postovi.naziv,
                            komentari.datum,
                            komentari.sadrzaj,
                            postovi.broj_komentara,
                            postovi.tema_id
                        FROM
                            postovi INNER JOIN komentari on postovi.post_id = komentari.post_id
			WHERE
                            postovi.tema_id = " . $_GET['id'] . "
                        GROUP BY
                            postovi.post_id
                        ORDER BY
                            postovi.broj_komentara desc";
		
		$result = mysqli_query($GLOBALS["con"], $sql);
		
		if(!$result)
		{
			echo 'Postovi nisu mogli biti prikazani, molimo Vas da pokušate kasnije.';
		}
		else
		{
			if(mysqli_num_rows($result) == 0)
			{
                            echo '<hr>U ovoj temu još uvek nema postova. Dodajte <a href="newPost.php?id=' . $id . '">novi post.</a>';
			}
			else
			{
				//prepare the table
				echo '<table id="tabelaIndex">
					  <tr>
						<th>Naziv posta</th>
						<th>Broj komentara</th>
                                                <th>Vreme kreiranja</th>
					  </tr>';	
					
				while($row = mysqli_fetch_assoc($result))
				{				
					echo '<tr>';
						echo '<td id="leviTema">
							<div class="pull-left"><a href="post.php?id=' . $row['post_id'] . '">' . $row['naziv'] . '</a><text>' . substr(htmlentities(stripslashes($row['sadrzaj'])), 0, 100) . '...</text></div><br>';
?>
<?php
                                                if(isset($_SESSION["ulogovan"]) && $_SESSION["tip_korisnika"] == 2) {
                                                echo '<div style="align: center" class="pull-right"><a id="linkBrisanje" data-href="deletePost.php?id=' . $row['post_id'] . '" data-toggle="modal" data-target="#confirm-delete" style="font-size: 80%; color: red;" class="glyphicon glyphicon-trash"></a></div>';    
                                                }
                                                echo '</td>
                                                      <td id="srednjiTema">' . $row["broj_komentara"] . '</td>
                                                      <td id="desniTema">';
                                                        echo date('d-m-Y H:i', strtotime($row['datum']));
						echo '</td></tr>';
                                                
                                //HTML kod - modal
                                echo '<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 align="center"><b>Potvrda brisanja teme</b></h4>
                                                </div>
                                                <div class="modal-body">
                                                    Da li ste sigurni da zelite da obrisete post?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Otkaži</button>
                                                    <a class="btn btn-danger btn-ok">Obriši</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
?>
                                    <!--Javascript kod za potvrdu brisanja podataka-->
                                    <script>
                                        $('#confirm-delete').on('show.bs.modal', function(e) {
                                        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
                                    });
                                    </script>
<?php
				}
                                
                               
			}
                        echo '</table>';
		}
	}
}

include 'footer.php';
?>
