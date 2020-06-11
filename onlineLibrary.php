<?php
include 'connect.php';
include 'header.php';
$GLOBALS["con"] = connection();

$tip = $_SESSION['tip_korisnika'];
$query = "SELECT predmet FROM biblioteka GROUP BY predmet ORDER BY predmet asc";
$result = mysqli_query($GLOBALS["con"], $query);

if(isset($_SESSION['ulogovan'])) {
    echo '<h4><b>Literatura: </b></h4>';

        if(mysqli_num_rows($result) == 0){
                echo '<h5>Još uvek nije postavljena nijedna skripta ili udžbenik.</h5><hr>';
            }

        else {
            echo '<div class="pull-left">';
            while($row = mysqli_fetch_assoc($result)){
                echo '<ul style="padding: 0; color: red;"><h5><b>'. $row['predmet'] .'</b></h5>';

                $predmet = $row['predmet'];
                $sql = "SELECT naziv FROM biblioteka WHERE predmet = '$predmet'";
                $resultSql = mysqli_query($GLOBALS["con"], $sql);
                while($row1 = mysqli_fetch_assoc($resultSql)){
                    echo '<li id="listaBiblioteka"><a href="biblioteka/'. $row1['naziv'] .'" target="_blank">'.$row1['naziv'].'</li></a>';
                }

                echo '</ul>';

            }


            echo '</div>';
        }

    if($tip != 0){
        echo '<div class="pull-right">
                    <form action="fileUploadLibrary.php" method="post" enctype="multipart/form-data">
                    Naziv predmeta:<br>
                    <input type="text" required name="predmet" id="predmet"/>
                    Upload:
                    <input type="file" name="the_file" id="fileToUpload">
                    <input type="submit" name="submit" value="Start Upload">
                    </form>
                  </div>';
    }
}
else {
    header ("Location: 404error.php");
}

include 'footer.php';

?>

