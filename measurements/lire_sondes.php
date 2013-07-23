#!/usr/bin/php -q 
<?php 
//********************** include ********************** 
  define('ROOT', dirname(__FILE__) . '/');
require_once (ROOT.'include/init.php');

  //require_once "System/Daemon.php";  

  // Check to make sure the file ownet.php exists
  if(file_exists("/opt/owfs/share/php/OWNet/ownet.php"))  
          {
          require "/opt/owfs/share/php/OWNet/ownet.php";
          } else if(file_exists("ownet.php"))  {
          require "ownet.php";
          } else {
          die("File 'ownet.php' is not found.\n");
          }
 //*********************** CLI arguments ****************** 
  if ((isset($argv[1]))) 
          {
          $polling_time = $argv[1];
          } else {
          die('Paramètre polling_time manquant');  
          }
          
if ($argv[2] == "-d") {
	$debug = 1;
	if ($argv[3] >1 ) $debug = 2;
	}

//*********************** main *****************************
 
// on lit la liste des capteurs avec un polling_time égal au paramètre
$sql = "SELECT id, nom, adresse_source,label_unite, grandeur_id, offset, conversion FROM t_sondes WHERE polling_time = '$polling_time' ORDER BY id ASC";

if ($debug>1) echo "DEBUG: $sql\n";
$result = mysqli_query($DBCon,$sql) or die ("Echec de la requête: " . mysqli_error($DBCon));

if ($debug==1) printf ("DEBUG: id | Nom                            |Type|  Source  |       Source_adresse                                            |Mesure_brute |   Mesure    | Unite\n");
           
//Read last measurements from JSON file
$old_session = array(); //session array with previous measure [timestamp,raw_measure,computed measure]
$new_session = array(); //session array with new measure [timestamp,raw_measure,computed measure]
$f_last_measure = file_get_contents("$session_folder/dernieres_mesures_$polling_time.json");
$old_session = json_decode($f_last_measure,TRUE);
$new_session = $old_session;
  
//*********************** main loop for all sondes *****************************
while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
        $sonde_mesure_brute=null;
        $sonde_id=$row["id"];
        $sonde_nom=$row["nom"];
        $sonde_offset=$row["offset"];
        $sonde_conversion=$row["conversion"];
        $sonde_grandeur_id=$row["grandeur_id"];
        $sonde_adresse=$row["adresse_source"];
        $sonde_label_unite=$row["label_unite"];
	list($source_hostname,$source_type,$source_adresse) = explode ("@",$sonde_adresse);
	
        if ($debug==1) printf ("DEBUG: %2d|%-33s|%4s|%-10s|%-65s| ",$sonde_id,$sonde_nom,$source_type,$source_hostname,$source_adresse);
        switch ($source_type) {
            case "WC" : {
                //Source is a webcontrol board
                $sonde_url="http://$source_hostname/$source_adresse";
                $sonde_mesure_brute = floatval((file_get_contents($sonde_url)));
                if (strpos($http_response_header[0],"OK") >0){
                    //We adapt the measure with corrective factor and offset as defined in sensor table
		            $sonde_mesure = $sonde_mesure_brute*$sonde_conversion+$sonde_offset;
		            //We write the new measure to DB
		            $sql1="INSERT INTO t_mesures (sonde_id,mesure_brute,mesure) VALUE ($sonde_id,".($sonde_mesure_brute).",".($sonde_mesure).")";
		            if ($debug>1) echo "DEBUG: $sql1\n";
		            mysqli_query($DBCon,$sql1) or die ("Echec lors de l'Ã©criture d'une mesure brute: ".$sql1." " . mysqli_error($DBCon));
		            
		            //we read the last entry from DB to get timestamp of the previous measure
		            $sql = "SELECT timestamp, id FROM t_mesures WHERE id = LAST_INSERT_ID()";
		            $result_last=mysqli_query($DBCon,$sql) or die ("Echec lors de la lecture de la dernière mesure brute: ".$sql." " . mysqli_error($DBCon));
		            $row_last = mysqli_fetch_array($result_last, MYSQLI_NUM);
		                    
		            //we save the new raw measure into Session_file for later usage
		            $new_session[$sonde_id] = array($row_last[0],trim($sonde_mesure_brute),trim($sonde_mesure_brute));  
                } else {
                    die ("Erreur lecture webcontrol" .$source_hostname. "\n".$http_response_header[0]);
                    }
                break;
                }
            case "1W" : {
                //Source is a 1-wire sensor
                $ow=new OWNet("tcp://$source_hostname");
                $sonde_mesure_brute=($ow->read($source_adresse));
                //workarround for DS18S20 cave_vin issue
                if ($sonde_id==1) {
                    $sonde_mesure_brute=file_get_contents("/mnt/1wire$source_adresse");
                    }
                
                if (isset($sonde_mesure_brute)) { //we treat the last measure if not undefined
		            //We adapt the measure with corrective factor and offset as defined in sensor table
		            $sonde_mesure = $sonde_mesure_brute*$sonde_conversion+$sonde_offset;
		            //We write the new measure to DB
		            $sql1="INSERT INTO t_mesures (sonde_id,mesure_brute,mesure) VALUE ($sonde_id,".($sonde_mesure_brute).",".($sonde_mesure).")";
		            if ($debug>1) echo "DEBUG: $sql1\n";
		            mysqli_query($DBCon,$sql1) or die ("Echec lors de l'Ã©criture d'une mesure brute: ".$sql1." " . mysqli_error($DBCon));
		            
		            //we read the last entry from DB to get timestamp of the previous measure
		            $sql = "SELECT timestamp, id FROM t_mesures WHERE id = LAST_INSERT_ID()";
		            $result_last=mysqli_query($DBCon,$sql) or die ("Echec lors de la lecture de la dernière mesure brute: ".$sql." " . mysqli_error($DBCon));
		            $row_last = mysqli_fetch_array($result_last, MYSQLI_NUM);
		            
		            //we save the new raw measure into Session_file for later usage
		            $new_session[$sonde_id] = array($row_last[0],trim($sonde_mesure_brute),trim($sonde_mesure_brute));  
		                           
		            if ($sonde_grandeur_id==4) { //if sonde is a counter, we proceed to delta computation
						//We compute sonde_mesure that will be the delta with the previous valid measure
						if ($old_session[$sonde_id][1]==0) { //If this is the first measurement or session file unexists, delta is set to 0
							$sonde_mesure=0;
							}
						else { //otherwise Delta is computed normally
							$sonde_mesure=($sonde_mesure_brute-$old_session[$sonde_id][1])*$sonde_conversion+$sonde_offset; 
							}
						$new_session[$sonde_id][2]=$sonde_mesure;
						$sql = "UPDATE t_mesures SET mesure = ".$sonde_mesure." WHERE id = ".$row_last[1]; //We update the DB with computed value
						if ($debug>1) echo "DEBUG: $sql\n";
			            mysqli_query($DBCon,$sql) or die ("Echec lors de l'Ã©criture d'une mesure: ".$sql." " . mysqli_error($DBCon));
		                } //end if grandeur_id==4
		        } //end if isset
                break;
                } //end case "1W"
            case "VS" : {
                //source is another sonde measurement, on which we apply some computations
                list($command,$argument)=explode("|",$source_adresse);
                switch ($command) {
                    case "derivate":{
                        $sql_temp = "select timestamp, mesure from t_mesures where sonde_id='$source_hostname' ORDER BY timestamp DESC LIMIT 1";
						$result_temp=mysqli_query($DBCon,$sql_temp) or die ("Echec lors de la lecture de la dernière mesure: ". $sql_temp."\n". mysqli_error($DBCon));
						$row_temp = mysqli_fetch_array($result_temp, MYSQLI_NUM);
				
						$sonde_mesure_brute=$row_temp[1];
		                
		                if (isset($sonde_mesure_brute)) { //we treat the last measure if not undefined
				            //We write the new raw_measure to DB
				            $sql1="INSERT INTO t_mesures (sonde_id,mesure_brute) VALUE ($sonde_id,".($sonde_mesure_brute).")";
				            if ($debug>1) echo "DEBUG: $sql1\n";
				            mysqli_query($DBCon,$sql1) or die ("Echec lors de l'Ã©criture d'une mesure brute: ".$sql1." " . mysqli_error($DBCon));
				            
				            //we read the last entry from DB to get timestamp of the previous measure
				            $sql = "SELECT timestamp, id FROM t_mesures WHERE id = LAST_INSERT_ID()";
				            $result_last=mysqli_query($DBCon,$sql) or die ("Echec lors de la lecture de la dernière mesure brute: ".$sql." " . mysqli_error($DBCon));
				            $row_last = mysqli_fetch_array($result_last, MYSQLI_NUM);
				                    
				            //We compute sonde_mesure that will be the derivate of the measure. We divide by the time between 2 last measurements of physical probe (given in source_hostname)
							$sonde_mesure=round(($sonde_mesure_brute*$sonde_conversion+$sonde_offset)/(strtotime($row_last[0])-strtotime($old_session[$source_hostname][0])),2);         
				                    
				            //we save the new raw measure into Session_file for later usage
				            $new_session[$sonde_id] = array($row_last[0],trim($sonde_mesure_brute),$sonde_mesure);  
			                
							$sql = "UPDATE t_mesures SET mesure = ".$sonde_mesure." WHERE id = ".$row_last[1];
							if ($debug>1) echo "DEBUG: $sql\n";
			                mysqli_query($DBCon,$sql) or die ("Echec lors de l'Ã©criture d'une mesure: ".$sql." " . mysqli_error($DBCon)); //we update the DB
				        } //end if isset
		                
                        break;
                    } //end case "derivate"
                    case "substract":{
                        if (isset($argument)) { //Other operand has been defined in t_sonde
                            // We extract the first operand
                            $sql_temp = "select timestamp, mesure from t_mesures where sonde_id='$source_hostname' ORDER BY timestamp DESC LIMIT 1";
							$result_temp=mysqli_query($DBCon,$sql_temp) or die ("Echec lors de la lecture de la dernière mesure: ". $sql_temp."\n". mysqli_error($DBCon));
							$row_temp = mysqli_fetch_array($result_temp, MYSQLI_NUM);
							$first_operand=$row_temp[1];
							// We extract the second operand
                            $sql_temp = "select timestamp, mesure from t_mesures where sonde_id='$argument' ORDER BY timestamp DESC LIMIT 1";
							$result_temp=mysqli_query($DBCon,$sql_temp) or die ("Echec lors de la lecture de la dernière mesure: ". $sql_temp."\n". mysqli_error($DBCon));
							$row_temp = mysqli_fetch_array($result_temp, MYSQLI_NUM);
							$second_operand=$row_temp[1];
							
							$sonde_mesure_brute = $first_operand - $second_operand; //We do the substract
							//We write the new raw_measure to DB
				            $sql1="INSERT INTO t_mesures (sonde_id,mesure_brute) VALUE ($sonde_id,".($sonde_mesure_brute).")";
				            if ($debug>1) echo "DEBUG: $sql1\n";
				            mysqli_query($DBCon,$sql1) or die ("Echec lors de l'Ã©criture d'une mesure brute: ".$sql1." " . mysqli_error($DBCon));
							
							
							$sonde_mesure=round(($sonde_mesure_brute*$sonde_conversion+$sonde_offset),2); //We apply coeff + offset
                            
                            //we read the last entry from DB to get timestamp of the previous measure
				            $sql = "SELECT timestamp, id FROM t_mesures WHERE id = LAST_INSERT_ID()";
				            $result_last=mysqli_query($DBCon,$sql) or die ("Echec lors de la lecture de la dernière mesure brute: ".$sql." " . mysqli_error($DBCon));
				            $row_last = mysqli_fetch_array($result_last, MYSQLI_NUM);
                            
                            $new_session[$sonde_id] = array($row_last[0],$sonde_mesure_brute,$sonde_mesure);  
			                
							$sql = "UPDATE t_mesures SET mesure = ".$sonde_mesure." WHERE id = ".$row_last[1];
							if ($debug>1) echo "DEBUG: $sql\n";
			                mysqli_query($DBCon,$sql) or die ("Echec lors de l'Ã©criture d'une mesure: ".$sql." " . mysqli_error($DBCon)); //we update the DB
				        } //end if isset
				        
                        break;   
                    } //end case "substract"
                } // end switch $command
                
                break;
                } //end case "VS"    
            default: {
                exit ("Mauvais type de source de sonde:".$source_type);
                }
            } //end switch source_type
            if ($debug==1) printf ("s|s|%s \n", $sonde_mesure_brute,$sonde_mesure,$sonde_label_unite) ;
            $sonde_mesure_brute=null; 
        

} //end while

//*********************** output *****************************
$f_last_measure = json_encode($new_session);
file_put_contents("$session_folder/dernieres_mesures_$polling_time.json",$f_last_measure);
file_put_contents("/mnt/ds211/web/data/dernieres_mesures_$polling_time.json",$f_last_measure);
// Déconnexion
mysqli_close($DBCon); 
?>
