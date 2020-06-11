<?php
//signin.php
include 'connect.php';
$GLOBALS["con"] = connection();
 
session_start();
        $errors = array();
         
            $query = "SELECT * FROM korisnici WHERE korisnicko_ime = '" . $_POST['username'] . "'";
            $query_result = mysqli_query($GLOBALS["con"], $query);
            
            $row = mysqli_fetch_assoc($query_result);
            $password = $row["lozinka"];
            $verify = password_verify($_POST["passwordEntry"], $password);
            
            if(!$query_result)
            {
                echo 'Nešto je krenulo naopako pri pokretanju. Molimo Vas pokušajte kasnije.';
            }
            
            if($verify) {
                $_SESSION['ulogovan'] = true;

                $_SESSION['korisnik_id']    = $row['korisnik_id'];
                $_SESSION['korisnicko_ime']  = $row['korisnicko_ime'];
                $_SESSION['tip_korisnika'] = $row['tip_korisnika'];

                header("Location:index.php");
            } else {
                header("Location:index.php?msg=failed");
            }
     

?>