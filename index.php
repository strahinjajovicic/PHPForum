<?php
include 'connect.php';
include 'header.php';

$GLOBALS["con"] = connection();

$sql = "SELECT teme.tema_id, teme.naziv, teme.opis, COUNT(postovi.post_id) AS postovi
        FROM teme LEFT JOIN postovi ON teme.tema_id = postovi.tema_id
        GROUP BY teme.naziv, teme.opis, teme.tema_id";

$result = mysqli_query($GLOBALS["con"], $sql );

if(!$result)
{
	echo 'Neuspešno prikazane teme. Molimo Vas pokušajte kasnije.';
}
else
{
	if(mysqli_num_rows($result) == 0)
	{
		echo '<p>Nijedna tema još nije napravljena.</p>';
	}
	else
	{
            if(isset($_POST['search'])){
                $valueToSearch = $_POST['valueToSearch'];
                // search in all table columns
                // using concat mysql function
                $query = "SELECT teme.tema_id, teme.naziv, teme.opis, COUNT(postovi.post_id) AS postovi
                          FROM teme LEFT JOIN postovi ON teme.tema_id = postovi.tema_id
                          WHERE teme.naziv LIKE '%".$valueToSearch."%' and odobren = 1
                          GROUP BY teme.naziv, teme.opis, teme.tema_id";
                
                $search_result = mysqli_query($GLOBALS["con"], $query);
            }
            
            else if(isset($_POST['searchYear'])){
                $valueToSearch = $_POST['searchSelect'];
                // search in all table columns
                // using concat mysql function
                $query = "SELECT teme.tema_id, teme.naziv, teme.godina, teme.opis, COUNT(postovi.post_id) AS postovi
                          FROM teme LEFT JOIN postovi ON teme.tema_id = postovi.tema_id
                          WHERE teme.godina LIKE '%".$valueToSearch."%' and odobren = 1
                          GROUP BY teme.naziv, teme.godina, teme.opis, teme.tema_id";
                
                $search_result = mysqli_query($GLOBALS["con"], $query);
            }
            
            else {
                $query = "SELECT teme.tema_id, teme.naziv, teme.opis, COUNT(postovi.post_id) AS postovi
                          FROM teme LEFT JOIN postovi ON teme.tema_id = postovi.tema_id 
                          WHERE odobren = 1
                          GROUP BY teme.naziv, teme.opis, teme.tema_id";
                
                $search_result = mysqli_query($GLOBALS["con"], $query);
            }
            
            if(isset($_SESSION['ulogovan'])){
                echo '<a class="glyphicon glyphicon-plus pull-right" href="newTheme.php" data-toggle="tooltip" data-placement="bottom" title="Dodajte novu temu"></a>';
            }
            
            if(mysqli_num_rows($search_result) == 0){
                echo 'Još uvek ne postoji nijedna (odobrena) tema. Dodajte <a href="newTheme.php">novu temu.</a>';
            }
            
            else {
                echo '<form action="index.php" method="post">
                    <div class="form-inline"> 
                        <div class="form-group">
                            <input class="form-control" type="text" name="valueToSearch" placeholder="Filtriraj prema nazivu">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-default" type="submit" name="search" value="Filtriraj"><br>
                        </div>
                    </div>
                    <div class="form-inline"> 
                       <div class="form-group">
                            <select id="searchYearInput" class="form-control" name="searchSelect" data-toggle="tooltip" data-placement="bottom" title="Filtriraj prema godini studiranja">
                                <option value="1">Prva</option>
                                <option value="2">Druga</option>
                                <option value="3">Treća</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-default" type="submit" name="searchYear" value="Filtriraj prema godini">
                        </div>
                    </div><br>
                    <table id="tabelaIndex">
                        <thead>
			  <tr>
				<th>Tema</th>
				<th>Poslednji post</th>
			  </tr>
                        </thead>';	
			
		while($row = mysqli_fetch_assoc($search_result))
		{				
			echo '<tbody><tr>';
				echo '<td id="tdTema">';
					echo '<div class="pull-left"><a href="theme.php?id=' . $row['tema_id'] . '">' . $row['naziv'] . '</a></div>';
?>                           
                                        
<?php
                                        if(isset($_SESSION["ulogovan"]) && $_SESSION["tip_korisnika"] == 2) {
                                        echo '<div class="pull-right"><a id="linkBrisanje" data-href="deleteTheme.php?id=' . $row['tema_id'] . '" data-toggle="modal" data-target="#confirm-delete" style="font-size: 80%; color: red;" class="glyphicon glyphicon-trash"></a></div>';
                                        }
                                        echo '<br><p>' . $row['opis'] . '</p>';
				echo '</td>';
                                
                                //HTML kod - modal
                                echo '<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 align="center"><b>Potvrda brisanja teme</b></h4>
                                                </div>
                                                <div class="modal-body">
                                                    Da li ste sigurni da želite da obrišete temu?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Otkaži</button>
                                                    <a class="btn btn-danger btn-ok">Obriši</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
?>
                                    <script>
                                        $('#confirm-delete').on('show.bs.modal', function(e) {
                                        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
                                    });
                                    </script>
<?php
                                
				echo '<td id="tdPost">';
				
				//hvataj poslednji post 
					$postsql = "SELECT post_id, naziv, datum, tema_id
                                                    FROM postovi WHERE tema_id = " . $row['tema_id'] . "
                                                    ORDER BY datum DESC LIMIT 1";
								
					$postsresult = mysqli_query($GLOBALS["con"], $postsql);
				
					if(!$postsresult)
					{
						echo 'Poslednji post nije mogao biti prikazan';
					}
					else
					{
						if(mysqli_num_rows($postsresult) == 0)
						{
							echo 'nema postova';
						}
						else
						{
							while($postrow = mysqli_fetch_assoc($postsresult))
							echo '<h5><a href="post.php?id=' . $postrow['post_id'] . '">' . $postrow['naziv'] . '</a></h5><p>' . date('d-m-Y', strtotime($postrow['datum'])) . '</p>';
						}
					}
				echo '</td>';
			echo '</tr></tbody>';
		}
                echo '</table></form>';
            }
        }
}

echo '<hr>';

include "footer.php";

?>
