<!DOCTYPE html>
<html lang="en">
<head>
  <title>Forum</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="fonts/glyphicons-halflings-regular.ttf">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script> 
</head>
<body>
<?php
    session_start();
    $message = "Uneli ste pogrešno korisničko ime ili lozinku.";
    if (isset($_GET["msg"]) && $_GET["msg"] == 'failed') {
        echo "<script type='text/javascript'>alert('$message');</script>";
}
?>
<nav id="top" class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
        <a class="navbar-brand glyphicon glyphicon-home" href="index.php"></a>
    </div> 
    <?php
        if(!isset($_SESSION['ulogovan']))
        {
    ?>
    <div class="pull-right">
        <ul class="nav navbar-nav">
            <li><a href="registration.php">Registrujte se</a></li>
            <li>
                <a data-toggle="dropdown" href="#">Prijavite se</a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><form style="padding: 10px;" action="login.php" method="post" class="px-4 py-3">
                      <div class="form-group">
                        <label for="exampleDropdownFormEmail1">Korisničko ime</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Unesite korisnicko ime" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleDropdownFormPassword1">Password</label>
                        <input type="password" class="form-control" name="passwordEntry" id="passwordEntry" placeholder="Password" required>
                      </div>
                      <button type="submit" class="btn btn-primary">Uloguj se</button>
                        </form></li>
                    <li role="separator" class="divider"></li>
                    <li><a class="dropdown-item" style="color: #6495ED;" href="registration.php">Nemate kreiran nalog? Kreirajte ga ovde.</a></li>
                    <script>
                        
                        $(function() {
                            $('.dropdown-toggle').on('click', function(event) {
                              $('.dropdown-menu').slideToggle();
                              event.stopPropagation();
                            });

                            $('.dropdown-menu').on('click', function(event) {
                              event.stopPropagation();
                            });

                            $(window).on('click', function() {
                              $('.dropdown-menu').slideUp();
                            });

                          });
                    </script>
                </ul>
            </li>
        </ul>
    </div>
    <?php
        }
        else
        {
    ?>
    <div>
        <ul class="nav navbar-nav">
            <li><a href="materijali.php">Materijali</a></li>
            <li><a href="onlineLibrary.php">Biblioteka</a></li>
        </ul>
    </div>
    <div class="pull-right">
        <ul class="nav navbar-nav">
            <li>
                <a data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-user" aria-hidden="true"></i>&nbsp;<?php echo '' . $_SESSION['korisnicko_ime'] . '' ?></a>
                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="user.php?id=<?php echo '' . $_SESSION["korisnik_id"] . ''?>">Moj profil</a></li>
                    <li><a href="newTheme.php">Kreiraj novu temu</a></li>
                    <li><a href="newPost.php">Kreiraj novi post</a></li>
                    <?php
                    if($_SESSION['tip_korisnika'] != 0) {
                    ?>
                        <li><a href="approveComments.php">Odobravanje</a></li>
                    <?php
                    }
                    if($_SESSION['tip_korisnika'] == 2) {
                    ?>
                        <li><a href="userControl.php">Rad sa korisnicima</a></li>
                    <?php    
                    }
                    ?>
                    <li role="separator" class="divider"></li>
                    <li><a href="logout.php">Odjavite se</a></li>
                </ul>
             </li>
        </ul>
    </div>
    <?php
        }
    ?>
  </div>
</nav>
<div class="container">


