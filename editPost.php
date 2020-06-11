<?php
include 'header.php';
include 'connect.php';
$GLOBALS["con"] = connection();

if(isset($_SESSION['ulogovan'])){
    $postHeader = $_GET['post_id'];
    $id = $_GET['id'];
    $query = "SELECT * FROM komentari WHERE komentar_id=".$id;
    $result = mysqli_query($GLOBALS["con"], $query);
    $row = mysqli_fetch_assoc($result);
    
    echo ' <form class="well form-horizontal" method="post" action="" id="editujKomentar">';
                             
            echo '<fieldset>';
                                
            echo '<legend align="center">Izmenite komentar</legend>';
		//the form hasn't been posted yet, display it
            echo '<div class="form-group">
                    <label class="col-md-2 control-label">Sadrzaj</label>  
                        <div class="col-md-8 inputGroupContainer">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-tags"></i></span>
                                <textarea rows="20" id="sadrzajKomentara" name="sadrzajKomentara">'. $row['sadrzaj'] .'</textarea>
                            </div>
                        </div>
                  </div>';
            echo '<div class="form-group">
                    <label class="col-md-5 control-label"></label>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-warning" >Izmeni<span class="glyphicon glyphicon-send"></span></button>
                        <a href="post.php?id='.$postHeader.'" class="btn btn-danger" >Otkaži<span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                  </div>';
                                
            echo '</fieldset>
                    </form>';
    
    if(isset($_POST['sadrzajKomentara'])){        
        $query = "UPDATE komentari SET sadrzaj = '".$_POST['sadrzajKomentara']."' WHERE komentar_id = " . $id;
        $result = mysqli_query($GLOBALS["con"], $query);
        header("Location: post.php?id=$postHeader");
    }

}
else {
    header("Location: 404error.php");
}

include 'footer.php';
?>
