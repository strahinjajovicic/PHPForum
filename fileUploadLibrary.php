<?php
    session_start();
    include 'connect.php';
    $GLOBALS["con"] = connection(); 
    
if(isset($_SESSION['ulogovan'])){    
    
    if(isset($_POST['predmet'])){
    $predmet = $_POST['predmet'];
    }
    
    $currentDirectory = getcwd();
    $uploadDirectory = "/biblioteka/";

    $errors = []; // Store errors here

    $fileExtensionsAllowed = ['pdf']; // dozvoljavamo samo ovu eksenziju

    $fileName = $_FILES['the_file']['name'];
    $fileSize = $_FILES['the_file']['size'];
    $fileTmpName  = $_FILES['the_file']['tmp_name'];
    $fileType = $_FILES['the_file']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));

    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName);
    $retrieve = "biblioteka/" . basename($fileName);
    
    if (isset($_POST['submit'])) {

      if (! in_array($fileExtension,$fileExtensionsAllowed)) {
        $errors[] = "Ova ekstenzija nije dozvoljena. Molimo Vas da upload-ujete samo pdf.";
      }

      if ($fileSize > 4000000) {
        $errors[] = "File prelazi maksimalnu veličinu (4MB)";
      }

      if (empty($errors)) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
        
        $query = "INSERT into biblioteka(naziv, put, predmet) VALUES ('" . basename($fileName) ."', '" . $retrieve . "', '" . $predmet . "')";
        $result = mysqli_query($GLOBALS["con"], $query);
        
        header("Location: onlineLibrary.php");
        
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