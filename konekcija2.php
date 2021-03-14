<?php

$konekcija2 = mysqli_connect("localhost","root","","iteh");

if (mysqli_connect_errno()){
  die("Neuspelo povezivanje sa bazom: " . mysqli_connect_error());
}

?>