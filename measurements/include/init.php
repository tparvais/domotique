<?php

// Param�tres DB
$host = "ds211"; // voir h�bergeur
$user = "login"; // vide ou "root" en local
$pass = "password"; // vide en local
$bdd = "domotique"; // nom de la BD

// Param�tres divers

$debug = 0;
$session_folder = '/root/domotique/data/session'; 

// connexion
$DBCon = mysqli_connect($host,$user,$pass) or die ("Echec de la connexion: ".mysqli_connect_error());
mysqli_select_db($DBCon,$bdd) or die('Could not select database: '.$bdd);



?>
