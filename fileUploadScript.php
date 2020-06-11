<?php
    session_start();
    include 'connect.php';
    $GLOBALS["con"] = connection(); 
    
if(isset($_SESSION['ulogovan'])){ 
    
    if(isset($_GET['id'])){
    $id = $_GET['id'];
    }
    
    if(isset($_GET['naziv'])){
    $naziv = $_GET['naziv'];
    }
    
    $currentDirectory = getcwd();
    $uploadDirectory = "/materijali/$naziv/";

    $errors = []; // Store errors here

    $fileExtensionsAllowed = ['pdf']; // These will be the only file extensions allowed 

    $fileName = $_FILES['the_file']['name'];
    $fileSize = $_FILES['the_file']['size'];
    $fileTmpName  = $_FILES['the_file']['tmp_name'];
    $fileType = $_FILES['the_file']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));

    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);
    $retrieve = "materijali/" . $naziv . "/" . basename($fileName);
    
    if (isset($_POST['submit'])) {

      if (! in_array($fileExtension,$fileExtensionsAllowed)) {
        $errors[] = "Ova ekstenzija nije dozvoljena. Molimo Vas da upload-ujete samo pdf.";
      }

      if ($fileSize > 4000000) {
        $errors[] = "File prelazi maksimalnu veličinu (4MB)";
      }

      if (empty($errors)) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
        
        $query = "INSERT into materijali(put, ime, predmet_id) VALUES ('" . $retrieve . "', '" . basename($fileName) ."', $id)";
        $result = mysqli_query($GLOBALS["con"], $query);
        
        header("Location: materijali.php");
        
      } else {
        foreach ($errors as $error) {
          echo $error . "Ovo su greske: " . "\n";
        }
      }
      
    }
}
else {
    header("Location: 404error.php");
}
?>