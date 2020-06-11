<?php
include 'connect.php';
include 'header.php';
$GLOBALS["con"] = connection();

if(isset($_SESSION['ulogovan']) && $_SESSION['tip_korisnika'] != 0){
    $query = "SELECT * FROM komentari WHERE odobren = 0";
    $result = mysqli_query($GLOBALS["con"], $query);
    $queryTeme = "SELECT * FROM teme WHERE odobren = 0";
    $resultTeme = mysqli_query($GLOBALS["con"], $queryTeme);
    
    if(mysqli_num_rows($result) != 0){
        echo '<table class="table">
                <thead>
                    <tr>
                        <td><b>Neodobreni komentari</b></td>
                    </tr>
                </thead>
                <tbody>';
                while($row = mysqli_fetch_assoc($result)){
                    echo '<tr>
                            <td>'. $row['sadrzaj'] .'</td>
                            <td>'. $row['datum'] .'</td>
                            <td>
                                <div>
                                    <a href="approveScriptComments.php?id='. $row['komentar_id'] .'" class="glyphicon glyphicon-ok" data-toggle="tooltip" data-placement="bottom" title="Odobri"></a>
                                </div>
                                <div>
                                    <a href="deleteComment.php?id=' . $row['komentar_id'] . '&post_id=' . $row['post_id'] . '"" class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="bottom" title="Obriši"></a>
                                </div>
                            </td>
                          </tr>';
                }

            echo '</tbody>
             </table>';
    }
        
    else if(mysqli_num_rows($resultTeme) != 0) {        
        echo '<table class="table">
                <thead>
                    <tr>
                        <td><b>Neodobrene teme</b></td>
                    </tr>
                </thead>
                <tbody>';
                while($row1 = mysqli_fetch_assoc($resultTeme)){
                    echo '<tr>
                            <td>'. $row1['naziv'] .'</td>
                            <td>
                                <div>
                                    <a href="approveScriptThemes.php?id='. $row1['tema_id'] .'" class="glyphicon glyphicon-ok" data-toggle="tooltip" data-placement="bottom" title="Odobri"></a>
                                </div>
                                <div>
                                    <a href="deleteTheme.php=?' . $row1['tema_id'] . '" class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="bottom" title="Obriši"></a>
                                </div>
                            </td>
                          </tr>';
                }

            echo '</tbody>
             </table>';   
    }
    else {
        echo 'Nema ničega što je potrebno biti odobreno';
    }
}

else {
    header("Location: 404error.php");
}

include 'footer.php';
?>