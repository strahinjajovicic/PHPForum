<?php
include 'connect.php';
include 'header.php';

$GLOBALS["con"] = connection();

$tip = $_SESSION['tip_korisnika'];
$sql = "SELECT predmet_id, naziv, godina
        FROM predmeti
        GROUP BY naziv";

$result = mysqli_query($GLOBALS["con"], $sql );

if(isset($_SESSION['ulogovan'])){

    if($tip != 0){
        echo '<div data-toggle="tooltip" style="float: right;" data-placement="bottom" title="Dodajte predmet">
                <a data-href="noviPredmet.php" data-toggle="modal" data-target="#insert-modal" class="glyphicon glyphicon-plus"></a>
              </div>';
    }
    echo '<div class="modal fade" id="insert-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 align="center"><b>Unesi novi predmet</b></h4>
                    </div>
                    <form method="post" action="noviPredmet.php" class="insertForm">
                        <div class="modal-body">
                            <label style="text-align: center;">Naziv predmeta</label>
                            <input class="form-control" type="text" id="nazivPredmeta" name="nazivPredmeta"/><br><br>
                            <label>Godina studiranja</label>
                            <select name="godina" id="godina" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Otkaži</button>
                            <input type="submit" class="btn btn-success" value="Sačuvaj"/>
                        </div>
                    </form>
                </div>
            </div>
          </div>';

    if(!$result)
    {
            echo 'Neuspešno prikazane teme. Molimo Vas pokušajte kasnije.';
    }
    else
    {
            if(mysqli_num_rows($result) == 0)
            {
                    echo '<p>Ne postoje rezultati za prikaz.</p>';
            }
            else
            {
                if(isset($_POST['search'])){
                    $valueToSearch = $_POST['valueToSearch'];
                    // search in all table columns
                    // using concat mysql function
                    $query = "SELECT predmet_id, naziv, godina
                              FROM predmeti
                              WHERE naziv LIKE '%".$valueToSearch."%'
                              GROUP BY naziv";

                    $search_result = mysqli_query($GLOBALS["con"], $query);
                }
                else {
                    $query = "SELECT predmet_id, naziv, godina
                              FROM predmeti 
                              GROUP BY naziv";

                    $search_result = mysqli_query($GLOBALS["con"], $query);
                }

                echo '<form action="materijali.php" method="post">
                        <div class="form-inline"> 
                            <div class="form-group">
                                <input id="searchInput" class="form-control" type="text" name="valueToSearch" placeholder="Filtriraj prema nazivu">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-default" type="submit" name="search" value="Filtriraj"><br>
                            </div>
                        </div><hr>
                        <table id="tabelaIndex">
                            <thead>
                              <tr>
                                    <th>Naziv predmeta</th>
                              </tr>
                            </thead>';	

                    while($row = mysqli_fetch_assoc($search_result))
                    {				
                            echo '<tbody><tr>';
                                    echo '<td id="tdTema">';
                                            echo '<div class="pull-left"><a href="materijaliPdf.php?id=' . $row['predmet_id'] . '&naziv=' . $row['naziv'] . '">' . $row['naziv'] . '</a></div>';
    ?>                           

    <?php
                                            if(isset($_SESSION["ulogovan"]) && $tip == 2) {
                                                echo '<div class="pull-right"><a id="linkBrisanje" href="deletePredmet.php?id=' . $row['predmet_id'] . '" style="font-size: 80%; color: red;" class="glyphicon glyphicon-trash"></a></div>'; 
                                            }
                                    echo '</td>';

    ?>
    <!--Javascript kod za unos novog predmeta-->
    <script>
    $('#confirm-delete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });    

    $("#insertForm").submit(function(event){
    event.preventDefault();
    });

    </script>
    <?php
                            echo '</tr></tbody>';
                    }
                    echo '</table></form>';
            }
    }

    echo '<hr>';
}

else {
    header("Location: 404error.php");
}

include "footer.php";

?>
