<?php
 
$link = mysqli_connect('localhost', 'root', '', 'login');

 if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>