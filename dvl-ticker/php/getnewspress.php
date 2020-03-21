<?php

//require('/www/volleyballserver.de/dvlticker/php//class.dvl_schnittstelle.php');
//require('/www/volleyballserver.de/dvlticker/php//class.couchdb.php');
require('./class.dvl_schnittstelle.php');
require('./class.couchdb.php');

$url_p=array();
$url_p['press_1blm'] = "https://dvl.volleyballserver.de/index.php?id=dvlschnittstelle&tx_dvlschnittstelle_pi1[geturl]=http://meltwaternews.com/magenta/xml/html/47/1/124537.html";
$url_p['press_1blf'] = "https://dvl.volleyballserver.de/index.php?id=dvlschnittstelle&tx_dvlschnittstelle_pi1[geturl]=http://meltwaternews.com/magenta/xml/html/47/1/124534.html";
$url_p['press_2blsf'] = "https://dvl.volleyballserver.de/index.php?id=dvlschnittstelle&tx_dvlschnittstelle_pi1[geturl]=http://meltwaternews.com/magenta/xml/html/47/1/124538.html";
$url_p['press_2blsm'] = "https://dvl.volleyballserver.de/index.php?id=dvlschnittstelle&tx_dvlschnittstelle_pi1[geturl]=http://meltwaternews.com/magenta/xml/html/47/1/124541.html";
$url_p['press_2blnf'] = "https://dvl.volleyballserver.de/index.php?id=dvlschnittstelle&tx_dvlschnittstelle_pi1[geturl]=http://meltwaternews.com/magenta/xml/html/47/1/124539.html";
$url_p['press_2blnm'] = "https://dvl.volleyballserver.de/index.php?id=dvlschnittstelle&tx_dvlschnittstelle_pi1[geturl]=http://meltwaternews.com/magenta/xml/html/47/1/124540.html";


$newsurl = array (	'1blm' => 'http://volleyball-bundesliga.de/magazin/crss.php?menuid=70',
					'1blf' => 'http://volleyball-bundesliga.de/magazin/crss.php?menuid=71',
 					'2blsm' => 'http://volleyball-bundesliga.de/magazin/crss.php?menuid=75',
 					'2blsf' => 'http://volleyball-bundesliga.de/magazin/crss.php?menuid=74',
 					'2blnm' => 'http://volleyball-bundesliga.de/magazin/crss.php?menuid=73',
 					'2blnf' => 'http://volleyball-bundesliga.de/magazin/crss.php?menuid=72');

$couchdb = new CouchDB('dvl2011');

try {
  $ligen = $couchdb->send('/_design/lifeticker/_view/bl_news');
}
catch(CouchDBException $e) {
    die($e->errorMessage()."\n");
} 
$arrLigenAusCouchDB = json_decode( $ligen->getBody( false ) );


for ($i=0; $i< $arrLigenAusCouchDB->total_rows;$i++){


	$liga = $arrLigenAusCouchDB->rows[$i]->key;
     
	$news_html='';
	$url = $newsurl[$liga];
	$DVL_news		= simplexml_load_file($url);
	
	foreach ( $DVL_news->channel->item as $artikel){
		//print_r($artikel);
		
		$news_html .= "<div class='arikel'>
		";
		$news_html .= "<div class='title'>" . htmlspecialchars($artikel->title) . "</div>
		";
		$news_html .= "<div class='pubdate'>" . substr($artikel->pubDate,5,12) . " </div>
		";
		$news_html .= "<div class='pfeil';>&nbsp;</div>
		";
		$news_html .= "<div class='description'>" . htmlspecialchars($artikel->description) . " <a href='" . $artikel->link . "'> mehr</a></div>
		";
				
		$news_html .= " </div>";
		
	}
	
	$presse =  str_replace('"',"'",file_get_contents($url_p['press_'.$liga]));
	
	if ($presse){
	   $ersetze= array("<body>", "</body>", "</html>",'<font color="#01499B">','</font>');
		$presse =  str_replace($ersetze, "", stristr($presse,'<body>'));
	}
	else{
		 $presse = 'keine Presseartikel vorhanden!';
	}
	
	
$data ='{
	  "_id":"'.$arrLigenAusCouchDB->rows[$i]->id.'",
	  "_rev": "'.$arrLigenAusCouchDB->rows[$i]->value.'",
	  "liga": "'.$arrLigenAusCouchDB->rows[$i]->key.'",
	  "presse":"'.$presse.'",
	  "news":"'.str_replace('"',"'",$news_html).'",
	  "isnewsdoc":"1",
	  "last_update":'.time().'
	}';
	//echo $data;
	try {
		$erg=$couchdb->send('/'.$arrLigenAusCouchDB->rows[$i]->id,'put',$data);
		//print_r($erg);
	}catch(CouchDBException $e) {
	    echo($e->errorMessage()."\n");
	}
	//echo '<pre>'; 	
	//print_r($erg);
	//echo '</pre>--'.$data.'--';
}
//print_r($DVL_news->channel->item[1]);
echo ('fertig');
;