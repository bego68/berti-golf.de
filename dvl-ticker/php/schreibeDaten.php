<?php

//require('/www/volleyballserver.de/dvlticker/php//class.dvl_schnittstelle.php');
//require('/www/volleyballserver.de/dvlticker/php//class.couchdb.php');
require('./class.dvl_schnittstelle.php');
require('./class.couchdb.php');


$couchdb = new CouchDB('dvl2011');

try {
	$tpl_ticker = $couchdb->send('/tpl_ticker/tpl_ticker.html');
}
catch(CouchDBException $e) {
    die($e->errorMessage()."\n");
}   

try {
  $ligen = $couchdb->send('/_design/lifeticker/_view/bl_rev');
}
catch(CouchDBException $e) {
    die($e->errorMessage()."\n");
} 

$arr_ligen= json_decode( $ligen->getBody( false ) );

//$couchdb = new CouchDB('testberti');  
for ($i=0; $i< $arr_ligen->total_rows;$i++){
	 
	 $dvl_schnittstelle =  new dvl_schnittstelle($arr_ligen->rows[$i]->key, NULL,3,3,$arr_ligen->rows[$i]->value[1]);
	 //echo '<h1>-------'.$i.'--------</h1>'.$arr_ligen->rows[$i]->id.' - '.$arr_ligen->rows[$i]->key.' - '.$arr_ligen->rows[$i]->value[0].' - '.$arr_ligen->rows[$i]->value[1].' <br/>';	 
    // print_r(  $dvl_schnittstelle->xmlLeagueShedule( $tpl_ticker->getBody( false )  )  );
   
	 $finde = array('"','vs.');
	 $ersetze = array( "'",'<br />' );
	 
	$ergebnisse = str_replace($finde,$ersetze,file_get_contents("https://dvl.volleyballserver.de/index.php?id=dvlschnittstelle&tx_dvlschnittstelle_pi1[action]=ergebnis&tx_dvlschnittstelle_pi1[liga]=".$arr_ligen->rows[$i]->key));
	if ($ergebnisse){
	   $ersetze= array("<body>", "</body>", "</html>",'<font color="#01499B">','</font>');
		$ergebnisse =  str_replace($ersetze, "", stristr($ergebnisse,'<body>'));
	}
	else {
		 $ergebnisse = 'keine Ergebnisse vorhanden!';
	}
	
	
	
     $data ='{
	  "_id":"'.$arr_ligen->rows[$i]->id.'",
	  "_rev": "'.$arr_ligen->rows[$i]->value[0].'",
	  "liga":"'.$arr_ligen->rows[$i]->id.'",
	  "ergebnisse":"'.$ergebnisse.'",
	  "liga_dvv":"'.$arr_ligen->rows[$i]->key.'",
	  "next_match":"'.$arr_ligen->rows[$i]->value[1].'",
	  "tabelle":{"html":"'.$dvl_schnittstelle->xmlLeagueTable( ).'","last_update":'.time().'  },
	  "ticker":'.$dvl_schnittstelle->xmlLeagueShedule( $tpl_ticker->getBody(false)).'
	}';
	echo $data;
	try {
		$erg=$couchdb->send('/'.$arr_ligen->rows[$i]->id,'put',$data);
		//print_r($erg);
	}catch(CouchDBException $e) {
	    echo($e->errorMessage()."\n");
	} 
     
}
echo 'fertig';
$dvl_schnittstelle = NULL;
$couchdb = NULL;

?>