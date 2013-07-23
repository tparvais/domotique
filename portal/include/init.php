<?php

// Paramètres DB
$host = "localhost"; // voir hébergeur
$user = "login"; // vide ou "root" en local
$pass = "password"; // vide en local
$bdd = "domotique"; // nom de la BD

// Paramètres divers

define("DEBUG", 1);


// connexion
$DBCon = mysqli_connect($host,$user,$pass) or die ("Echec de la connexion: ".mysqli_connect_error());
mysqli_select_db($DBCon,$bdd) or die('Could not select database: '.$bdd);

//Recherche du timestamp de la première mesure effectuée
$sql="SELECT MIN(`timestamp`) FROM `t_mesures` LIMIT 1";
$result = mysqli_query($DBCon,$sql) or die ("Echec de la requete dans init.php: \n\n" . $sql."\n\n".mysqli_error($DBCon));
$row = mysqli_fetch_array($result, MYSQLI_NUM)  or die ("pas de mesure dans la table t_mesures:".mysqli_error($DBCon));
define("T0_TIMESTAMP", $row[0]);






?>