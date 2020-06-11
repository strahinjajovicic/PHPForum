<?php
include 'connect.php';
include 'header.php';

$GLOBALS["con"] = connection();

if(isset($_SESSION['ulogovan'])){
    $query = "SELECT * FROM korisnici";
    $result = mysqli_query($GLOBALS["con"], $query);
    
    if(mysqli_num_rows($result) != 0){
        echo '<table class="table">
                <thead>
                    <tr align="center">
                        <td width="5%">ID korisnika</td>
                        <td>Korisničko ime</td>
                        <td>Email</td>
                        <td>Datum registracije</td>
                        <td>Rejting</td>
                        <td width="5%">Broj postova</td>
                        <td>Tip korisnika</td>
                        <td width="5%">Brisanje korisnika</td>
                    </tr>
                </thead>
                <tbody>';
                while($row = mysqli_fetch_assoc($result)){
                    echo '<tr align="center">
                            <td>'. $row['korisnik_id'] .'</td>
                            <td>'. $row['korisnicko_ime'] .'</td>
                            <td>'. $row['email'] .'</td>
                            <td>'. $row['datum_registracije'] .'</td>
                            <td>'. $row['rejting'] .'</td>
                            <td>'. $row['broj_postova'] .'</td>
                            <td>
                            <form action="changePermission.php?id='. $row['korisnik_id'] .'" method="post">
                                <select name="tip">';
                                    if($row['tip_korisnika'] == 2){
                                        echo '<option value="2">Administrator</option>
                                              <option value="0">Korisnik</option>  
                                              <option value="1">Moderator</option>';
                                    }
                                    else if($row['tip_korisnika'] == 1) {
                                        echo '<option value="1">Moderator</option>
                                              <option value="0">Korisnik</option>  
                                              <option value="2">Administrator</option>';
                                    }
                                    else {
                                        echo '<option value="0">Korisnik</option>
                                              <option value="2">Administrator</option>  
                                              <option value="1">Moderator</option>';
                                    }
                                echo '</select>
                                      <button type="submit">Promeni tip korisnika</button>
                                    
                            </form>
                            </td>
                            <td>
                                <a href="deleteUser.php?id=' . $row['korisnik_id'] . '" class="glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="bottom" title="Obriši"></a>
                            </td>
                          </tr>';
                            
                }
            echo '</tbody>
             </table>';
    }
?>
<script>
    $("#updateForm").submit(function(event){
// cancels the form submission
event.preventDefault();
});
</script>
<?php
}
else {
    header("Location: 404error.php");
}
include "footer.php";
?>