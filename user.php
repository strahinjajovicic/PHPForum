<?php
include 'connect.php';
include 'header.php';
$GLOBALS["con"] = connection();

    $sql = "SELECT *
            FROM korisnici
            WHERE korisnik_id =". $_GET['id'];

    $result = mysqli_query($GLOBALS["con"], $sql);
    $row = mysqli_fetch_assoc($result);

if((isset($_SESSION['ulogovan'])) && ($_SESSION['tip_korisnika'] == 1 || $_SESSION['tip_korisnika'] == 2 || $_SESSION['korisnik_id'] == $row['korisnik_id'])) {
    echo '<div class="col-md-offset-2">   
           <div class="col-md-9">
           
    <div class="panel panel-default">
      <div class="panel-heading" align="center"><h4 >Profil korisnika</h4></div>
       <div class="panel-body">

        <div class="box box-info" align="center">
            <div class="box-body">
                <div class="col-sm-2-center">
                    <div align="center"> 
                        <img alt="User Pic" src="'. $row['slika'] .'" id="profile-image1" class="img-circle img-responsive" data-toggle="tooltip" data-placement="bottom" title="Kliknite da biste promenili sliku"> 
                        <form action="imgUploadScript.php?id=' . $row['korisnik_id'] . '" method="post" enctype="multipart/form-data">
                            <input id="profile-image-upload" name="the_file" class="hidden" type="file">
                            <div style="color:#999;" >
                                <input class="btn btn-warning" type="submit" name="submit" value="Promenite sliku" disabled/>
                            </div>
                        </form>
                    </div>
                    <br>
                </div>


                <div class="clearfix"></div>
                <hr style="margin:5px 0 5px 0;">


                <div class="col-sm-5 col-xs-6 tital " >Korisničko ime:</div><div class="col-sm-7 col-xs-6 ">' . $row['korisnicko_ime'] . '</div>
                <div class="clearfix"></div>
                <div class="bot-border"></div>

                <div class="col-sm-5 col-xs-6 tital " >Lozinka:</div><div class="col-sm-7" type="password">' . $hidden_password = preg_replace("|.|","*",$row["lozinka"]) . '</div>
                <div class="clearfix"></div>
                <div class="bot-border"></div>

                <div class="col-sm-5 col-xs-6 tital " >Email:</div><div class="col-sm-7">' . $row['email'] . '</div>
                <div class="clearfix"></div>
                <div class="bot-border"></div>

                <div class="col-sm-5 col-xs-6 tital " >Datum registracije:</div><div class="col-sm-7">' . date('d-m-Y', strtotime($row['datum_registracije'])) . '</div>

                <div class="clearfix"></div>
                <div class="bot-border"></div>

                <div class="col-sm-5 col-xs-6 tital " >Rejting:</div><div class="col-sm-7">' . $row['rejting'] . '</div>

                <div class="clearfix"></div>
                <div class="bot-border"></div>

                <div class="col-sm-5 col-xs-6 tital " >Broj postova:</div><div class="col-sm-7">' . $row['broj_postova'] . '</div>

                <hr><a data-href="changePassword.php" data-toggle="modal" data-target="#changePass" href="#">Promeni lozinku</a>
                <div class="modal fade" id="changePass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 align="center"><b>Promena lozinke</b></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" action="changePassword.php" id="passwordForm">
                                                            <input id="oldPassword" name="oldPassword" class="input-lg form-control" type="password" class="form-control" placeholder="Trenutna lozinka" autocomplete="off"><hr> 
                                                            <input type="password" class="input-lg form-control" name="password1" id="password1" placeholder="Nova lozinka" autocomplete="off">
                                                            <div class="row">
                                                            <div class="col-sm-6">
                                                            <span id="8char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Dužina 8 Karaktera<br>
                                                            <span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Jedno Veliko Slovo
                                                            </div>
                                                            <div class="col-sm-6">
                                                            <span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Jedno Malo Slovo<br>
                                                            <span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Jedan Broj
                                                            </div>
                                                            </div>
                                                            <input type="password" class="input-lg form-control" name="password2" id="password2" placeholder="Ponovite lozinku" autocomplete="off">
                                                            <div class="row">
                                                            <div class="col-sm-12">
                                                            <span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Lozinke se poklapaju
                                                            </div>
                                                            </div>
                                                            <input type="submit" class="col-xs-12 btn btn-primary btn-load btn-lg" data-loading-text="Menjam lozinku..." value="Promeni lozinku">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                </div>';?>
    <script>
        $("input[type=password]").keyup(function(){
        var ucase = new RegExp("[A-Z]+");
            var lcase = new RegExp("[a-z]+");
            var num = new RegExp("[0-9]+");

            if($("#password1").val().length >= 8){
                    $("#8char").removeClass("glyphicon-remove");
                    $("#8char").addClass("glyphicon-ok");
                    $("#8char").css("color","#00A41E");
            }else{
                    $("#8char").removeClass("glyphicon-ok");
                    $("#8char").addClass("glyphicon-remove");
                    $("#8char").css("color","#FF0004");
            }

            if(ucase.test($("#password1").val())){
                    $("#ucase").removeClass("glyphicon-remove");
                    $("#ucase").addClass("glyphicon-ok");
                    $("#ucase").css("color","#00A41E");
            }else{
                    $("#ucase").removeClass("glyphicon-ok");
                    $("#ucase").addClass("glyphicon-remove");
                    $("#ucase").css("color","#FF0004");
            }

            if(lcase.test($("#password1").val())){
                    $("#lcase").removeClass("glyphicon-remove");
                    $("#lcase").addClass("glyphicon-ok");
                    $("#lcase").css("color","#00A41E");
            }else{
                    $("#lcase").removeClass("glyphicon-ok");
                    $("#lcase").addClass("glyphicon-remove");
                    $("#lcase").css("color","#FF0004");
            }

            if(num.test($("#password1").val())){
                    $("#num").removeClass("glyphicon-remove");
                    $("#num").addClass("glyphicon-ok");
                    $("#num").css("color","#00A41E");
            }else{
                    $("#num").removeClass("glyphicon-ok");
                    $("#num").addClass("glyphicon-remove");
                    $("#num").css("color","#FF0004");
            }

            if($("#password1").val() == $("#password2").val()){
                    $("#pwmatch").removeClass("glyphicon-remove");
                    $("#pwmatch").addClass("glyphicon-ok");
                    $("#pwmatch").css("color","#00A41E");
            }else{
                    $("#pwmatch").removeClass("glyphicon-ok");
                    $("#pwmatch").addClass("glyphicon-remove");
                    $("#pwmatch").css("color","#FF0004");
            }
    });
    </script>
    <?php
            echo '</div>
         </div>
        </div> 
       </div>
    </div>'; 
    ?>
        <script>
                  $(function() {
        $('#profile-image1').on('click', function() {
            $('#profile-image-upload').click();
        });
    });
    $(document).ready(
function(){
    $('input:file').change(
        function(){
            if ($(this).val()) {
                $('input:submit').attr('disabled',false);
            } 
        }
        );
});
       </script> 
    <?php
    echo '</div>';
}
else {
    header("Location: 404error.php");
}

include 'footer.php';
?>

