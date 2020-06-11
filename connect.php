<?php
    function connection() {
        $connect = mysqli_connect("localhost", "root", "", "forumuni");
        
        if(!$connect) {
            die ("Loša konekcija".mysqli_connect_error());
        }
        
        return $connect;
    }