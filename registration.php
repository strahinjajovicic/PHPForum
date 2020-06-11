<?php
//registracija.php
include 'connect.php';
include 'header.php';
$GLOBALS["con"] = connection();

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    echo '<form class="well form-horizontal" method="post" action="" id="registracijaForma" name="registracijaForma" onsubmit="return formValidation()">
        <fieldset>
        <legend align="center">Registracija</legend>
        <div class="form-group">
            <label class="col-md-4 control-label">Korisničko ime</label>  
            <div class="col-md-6 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input  name="korisnickoIme" id="korisnickoIme" placeholder="Unesite korisničko ime" class="form-control"  type="text">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Lozinka</label>  
            <div class="col-md-6 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input  name="lozinkaUnos" id="lozinkaUnos" placeholder="Unesite lozinku" class="form-control"  type="password" autocomplete="off">
                </div>
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
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Potvrda lozinke</label>  
            <div class="col-md-6 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input  name="lozinkaProvera" id="lozinkaProvera" placeholder="Ponovo unesite lozinku" class="form-control"  type="password">
                </div>
                <div class="row">
                        <div class="col-sm-6">
                            <span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Lozinke se poklapaju
                        </div>
                    </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-4 control-label">Email</label>  
            <div class="col-md-6 inputGroupContainer">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                    <input  name="email" id="email" placeholder="Unesite email adresu" class="form-control"  type="text">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label"></label>
            <div class="col-sm-3">
                <button type="submit" class="btn btn-warning" >Registruj se<span class="glyphicon glyphicon-send"></span></button>
            </div>
        </div>
        </fieldset>
     </form>';
    ?>

    <script>
        $("input[type=password]").keyup(function(){
        var ucase = new RegExp("[A-Z]+");
	var lcase = new RegExp("[a-z]+");
	var num = new RegExp("[0-9]+");
	
	if($("#lozinkaUnos").val().length >= 8){
		$("#8char").removeClass("glyphicon-remove");
		$("#8char").addClass("glyphicon-ok");
		$("#8char").css("color","#00A41E");
	}else{
		$("#8char").removeClass("glyphicon-ok");
		$("#8char").addClass("glyphicon-remove");
		$("#8char").css("color","#FF0004");
	}
	
	if(ucase.test($("#lozinkaUnos").val())){
		$("#ucase").removeClass("glyphicon-remove");
		$("#ucase").addClass("glyphicon-ok");
		$("#ucase").css("color","#00A41E");
	}else{
		$("#ucase").removeClass("glyphicon-ok");
		$("#ucase").addClass("glyphicon-remove");
		$("#ucase").css("color","#FF0004");
	}
	
	if(lcase.test($("#lozinkaUnos").val())){
		$("#lcase").removeClass("glyphicon-remove");
		$("#lcase").addClass("glyphicon-ok");
		$("#lcase").css("color","#00A41E");
	}else{
		$("#lcase").removeClass("glyphicon-ok");
		$("#lcase").addClass("glyphicon-remove");
		$("#lcase").css("color","#FF0004");
	}
	
	if(num.test($("#lozinkaUnos").val())){
		$("#num").removeClass("glyphicon-remove");
		$("#num").addClass("glyphicon-ok");
		$("#num").css("color","#00A41E");
	}else{
		$("#num").removeClass("glyphicon-ok");
		$("#num").addClass("glyphicon-remove");
		$("#num").css("color","#FF0004");
	}
	
	if($("#lozinkaUnos").val() == $("#lozinkaProvera").val()){
		$("#pwmatch").removeClass("glyphicon-remove");
		$("#pwmatch").addClass("glyphicon-ok");
		$("#pwmatch").css("color","#00A41E");
	}else{
		$("#pwmatch").removeClass("glyphicon-ok");
		$("#pwmatch").addClass("glyphicon-remove");
		$("#pwmatch").css("color","#FF0004");
	}
});
        function formValidation()                                    
        { 
            var username = document.forms["registracijaForma"]["korisnickoIme"];               
            var password1 = document.forms["registracijaForma"]["lozinkaUnos"];    
            var password2 = document.forms["registracijaForma"]["lozinkaProvera"];  
            var email =  document.forms["registracijaForma"]["email"];
            var ucase = new RegExp("[A-Z]+");
            var lcase = new RegExp("[a-z]+");
            var num = new RegExp("[0-9]+");
            
            if (username.value === "")                                  
            { 
                window.alert("Polje za unos korisničkog imena je prazno."); 
                username.focus(); 
                return false; 
            } 

            if (password1.value === "")                               
            { 
                window.alert("Polje za unos lozinke je prazno."); 
                password1.focus(); 
                return false; 
            }
            
            if (!(num.test($("#lozinkaUnos").val())) || !(ucase.test($("#lozinkaUnos").val())) || !(lcase.test($("#lozinkaUnos").val())))                               
            { 
                window.alert("Lozinka koju ste uneli nije validna."); 
                password1.focus(); 
                return false; 
            }

            if (password2.value !== password1.value)                                   
            { 
                window.alert("Niste uneli istu lozinku."); 
                password2.focus(); 
                return false; 
            } 

            if (email.value === "")                           
            { 
                window.alert("Polje za unos emaila je prazno."); 
                email.focus(); 
                return false; 
            } 
            return true; 
        }
    </script>
    
    <?php
}
else
{
    $username = $_POST["korisnickoIme"];
    $sqlUserCheck = "select * from korisnici where korisnicko_ime = '".$username."'";
    $resultUserCheck = mysqli_query($GLOBALS["con"], $sqlUserCheck);
    $errors = array(); 
     
    if(isset($_POST['korisnickoIme']))
    {
        //the user name exists
        if(!ctype_alnum($_POST['korisnickoIme']))
        {
            $errors[] = 'Korisničko ime sve da sadrzi samo slova i cifre';
        }
        if(strlen($_POST['korisnickoIme']) > 30)
        {
            $errors[] = 'Korisničko ime ne sme biti duže od 30 karaktera';
        }
        if(mysqli_num_rows($resultUserCheck)>=1){
            $errors[] = 'Korisničko ime već postoji.';
        }
    }
    else
    {
        $errors[] = 'Polje za unos korisničkog imena je prazno.';
    }
     
     
    if(isset($_POST['lozinkaUnos']))
    {
        if($_POST['lozinkaProvera'] != $_POST['lozinkaUnos'])
        {
            $errors[] = 'Lozinke se ne poklapaju';
        }
    }
    else
    {
        $errors[] = 'Polje za unos lozinke je prazno.';
    }
     
    if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
    {
        echo 'Niste dobro uneli neko od polja.';
        echo '<ul>';
        foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
        {
            echo '<li>' . $value . '</li>'; /* this generates a nice error list */
        }
        echo '</ul>';
    }
    else
    {
        $pass = password_hash($_POST["lozinkaUnos"], PASSWORD_DEFAULT);
        
        //the form has been posted without, so save it
        //notice the use of mysql_real_escape_string, keep everything safe!
        //shal funkcijom enkriptujemo lozinku
        $sql = "INSERT INTO
                    korisnici(korisnicko_ime, lozinka, email , datum_registracije, rejting, broj_postova, tip_korisnika)
                VALUES('" . $_POST['korisnickoIme'] . "',
                       '$pass', 
                       '" . $_POST['email'] . "',
                        CURTIME(),
                        0, 0, 0)";
                         
        $result = mysqli_query($GLOBALS["con"], $sql);
        if(!$result)
        {
            //something went wrong, display the error
            echo 'Nešto je krenulo naopako pri pokretanju. Molimo Vas pokušajte kasnije.';
            //echo mysql_error(); //debugging purposes, uncomment when needed
        }
        else
        {
            echo 'Uspešno ste se registrovali. Sada možete da se <a href="login.php">ulogujete</a> i da pristupite Vašem nalogu.';
        }
    }
}
 
include 'footer.php';
?>