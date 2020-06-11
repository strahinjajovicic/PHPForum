<?php
include 'connect.php';
include 'header.php';

$GLOBALS["con"] = connection();

if(isset($_SESSION['ulogovan'])){
    $id = $_GET['id'];
    $naziv = $_GET['naziv'];
    $tip = $_SESSION['tip_korisnika'];
    $query = "SELECT * FROM materijali WHERE predmet_id = $id";
    $result = mysqli_query($GLOBALS["con"], $query);
    
    if(mysqli_num_rows($result) == 0){
        echo '<h5>Još uvek nije postavljen nijedan materijal za ovaj predmet.</h5><hr>';
    }
    
    else {
        echo '<div class="row">';

        while($row = mysqli_fetch_assoc($result)){
            echo '<div class="col-xs-2">
                    <div class="card">
                        <a href="comment_material.php?id='.$row['materijal_id'].'">
                            <img src="images/pdf.jpg" style="width:100%">
                            <div class="containerTile">
                                <p>'. $row['ime'] .'</p>
                            </div>
                        </a>    
                    </div>
                  </div>';
        }
    

        echo '</div><hr>';
    }
    
    if($tip != 0){
        echo '<div style="float: left;">
            <form action="fileUploadScript.php?id=' . $id . '&naziv=' . $naziv . '" method="post" enctype="multipart/form-data">
            Upload a File:
            <input type="file" name="the_file" id="fileToUpload">
            <input type="submit" name="submit" value="Start Upload">
            </form>
          </div>';
    }
}
else {
    header("Location: 404error.php");
}
include "footer.php";
?>