<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Berti Golf <berti@golf-net.de>
*  All rights reserved
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */



/**
 * Plugin 'DVL Schnittstelle' for the 'dvlschnittstelle' extension.
 *
 * @author	Berti Golf <berti@golf-net.de>
 * 
 * @package	dvl_schnittstelle
 */
class dvl_schnittstelle{

	
	private $kennung='';
	private $team;
	private $vtage;
	private $ntage;
	private $datum;
	private $liga;
	private $url;
	private $adresse = 'http://interface.dvl-datenbank.de/givemedata.php';
	private $dvlStatitikURL =  array(
										'1blm' => 'http://live.volleyball-bundesliga.de/2011/Men/',	
										'1blf' => 'http://live.volleyball-bundesliga.de/2010/Women/'
	
	);
	private $tmpdir  = "/tmp/";
	private $liveTickerSekBevorSpielBeginn = 900;
	private $teamKurz = array(
										3315	=>	'NKW',
										3310	=>	'CVM',
										3320	=>	'VFB',
										3319	=>	'GOT',
										3318	=>	'BUH',
										3316	=>	'BOT',
										3314	=>	'MSC',
										3313	=>	'HAC',
										3312	=>	'DUR',
										3311	=>	'ROT',
										3317	=>	'BRV',
										3387	=>	'VCO',
										3321	=>	'GIE',
										3362	=>	'TIT',
										3363	=>	'DEL',
										3364	=>	'LIN',
										3365	=>	'LUN',
										3666	=>	'SEI',
										3367	=>	'SOL',
										3368	=>	'BRA',
										3370	=>	'VTK',
										3371	=>	'ESS',
										3372	=>	'RUM',
										3373	=>	'AMM',
										3388	=>	'VIF',
										3369	=>	'TEC',
										3376	=>	'FRE',
										3378	=>	'LEI',
										3377	=>	'DEL',
										3379	=>	'RUS',
										3386	=>	'VYS',
										3385	=>	'KEM',
										3374	=>	'STU',
										3383	=>	'VCD',
										3382	=>	'DUR',
										3381	=>	'GRA',
										3380	=>	'FRI',
										3375	=>	'DAC',
										3384	=>	'MEN',
										3322	=>	'COB',
										3334	=>	'VCO',
										3335	=>	'LEV',
										3337	=>	'KSC',
										3332	=>	'SUH',
										3331	=>	'USC',
										3330	=>	'SIN',
										3329	=>	'SAS',
										3328	=>	'SSC',
										3326	=>	'VIL',
										3325	=>	'DSC',
										3333	=>	'HAM',
										3324	=>	'AAC',
										3323	=>	'VCW',
										3327	=>	'POT',
										3346	=>	'HAM',
										3338	=>	'PAR',
										3339	=>	'STR',
										3340	=>	'EML',
										3341	=>	'RPB',
										3342	=>	'RUD',
										3343	=>	'WER',
										3345	=>	'OYT',
										3347	=>	'BRE',
										3348	=>	'GLA',
										3344	=>	'USC',
										3350	=>	'ERF',
										3351	=>	'CHE',
										3352	=>	'VIL',
										3353	=>	'LOH',
										3354	=>	'BSO',
										3355	=>	'VIL',
										3356	=>	'OFF',
										3357	=>	'DRE',
										3358	=>	'NUR',
										3359	=>	'GRI',
										3360	=>	'STR',
										3361	=>	'STU',
										3349	=>	'SON'  );
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$kennung: Kennung für die Schnittstelle
	 * @return	The content that is displayed on the website
	 */
	function __construct($liga='bl1m', $team=NULL,$vtage=NULL,$ntage=NULL,$datum=null,$ntage=NULL,$url = Null,  $kennunng = '9O73V49Ys6') {
		
		$this->kennung = $kennunng;
		
	    $this->liga = $liga; 
	      
	    $this->team	 = $team;
	    $this->vtage = $vtage;
	    $this->ntage = $ntage;
	    $this->datum = $datum;
	    if (!isset($this->datum))  $this->datum = strftime('%d.%m.%Y');
	    $this->url   = $url;

	}   
	  
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function getUrl($starttag="<body>" ) {
		$contents = file_get_contents($this->url);
		if ($contents){
		        $ersetze= array($starttag, "</body>", "</html>",'<font color="#01499B">','</font>');

			$contents =  str_replace($ersetze, "", stristr($starttag,'<body>'));
			
			if (!mb_check_encoding($contents, 'UTF-8')) {
				$contents = utf8_encode( $contents );
			}
		}
		else{
			 $contents = 'falsche URL';
		}
		return $contents;
	}
	
	
	function xmlLeagueTable() 
	{
		$i 			= 1;
        $adresse	= $this->adresse;
        $kennung	= $this->kennung;
        $liga		= $this->liga;
        $team		= $this->team;
		
		$adresse	= $adresse."?kennung=".$kennung."&job=tabelle&liga=".$liga;
		
		$DVL		= simplexml_load_file($adresse);
			
					
		/* Ausgabe der Daten */
		$content =  "";
		
		/* Tabellenkopf */
		$content .=  "<table>	<tr class='dvlEinzelplatz dvlTableHead'>";
		$content .=  "		<td class='dvlPlatz'></td>";
		$content .=  "		<td class='dvlTeams'>Mannschaft</td>";
		$content .=  "		<td class='dvlSpiele'>Sp</td>";
		$content .=  "		<td class='dvlPunkte'>Pkt</td>";
		$content .=  "		<td class='dvlSaetze'>Set</td>";
		$content .=  "		<td class='dvlBaelle'>B&auml;lle</td>";
		$content .=  "	</tr>";
		
		/* Einzelplätze */
		foreach ($DVL->einzelplatz as $result)
		{
			if ($i % 2 == 0)
			{
				$class = "even";
			}
			else
			{
				$class = "odd";
			}
			if (strtolower($result->mannschaft) == strtolower($team)) 
			{
				$class = $class.' myTeam';
			}
			$content .=  "	<tr class='dvlEinzelplatz $class'>";
			$content .=  "		<td class='dvlPlatz'>$result->platz</td>";
			$content .=  "		<td class='dvlTeams'>$result->mannschaft</td>";
			$content .=  "		<td class='dvlSpiele'>$result->spiele</td>";
			$content .=  "		<td class='dvlPunkte'>$result->punkte</td>";
			$content .=  "		<td class='dvlSaetze'>$result->saetze</td>";
			$content .=  "		<td class='dvlBaelle'>$result->baelle</td>";
			$content .=  "	</tr>";
			$i++;
		}	
		$content .=  "	<tr class='dvlEinzelplatz dvlTableHead'>";
		$content .=  "		<td class=' dvlPlatz'></td>";
		$content .=  "		<td class='dvlTeams'></td>";
		$content .=  "		<td class='dvlSpiele'></td>";
		$content .=  "		<td class='dvlPunkte'></td>";
		$content .=  "		<td class='dvlSaetze'></td>";
		$content .=  "		<td class=' dvlBaelle'></td>";
		$content .=  "	</tr>";
		$content .=  "</table>";
	
	   return $content;
	}

	
	/* xmlTeamResults: Funktion zur Ausgabe von Spielergebnissen eines Teams */
	
	function xmlTeamResults() 
	{
		$i 			= 1;
		$adresse	= $this->adresse;
     	$kennung	= $this->kennung;
        $team		= $this->team;
		/* Prüfung auf Temporäre Datei */
		
		
		/* Laden der XML-Datei der DVL */
		$adresse	= $adresse."?kennung=".$kennung."&job=ergebnisse&mannschaft=".$team;
		$DVL		= simplexml_load_file($adresse);
			
		
		/* Ausgabe der Daten */

		/* Einzelergebnisse */
		$content .=  "";
		foreach ($DVL->einzelergebnis as $result)
		{
			if ($i % 2 == 0)
			{
				$class = "even";
			}
			else
			{
				$class = "odd";
			}
			if ($result->ergebnis != '0:0')
			{
				$erg	= explode(":",$result->ergebnis);
				if ($erg[0]>$erg[1] & strtolower($result->heim) == strtolower($team))
				{
					$class = $class." won";
				}
				elseif ($erg[0]<$erg[1] & strtolower($result->gast) == strtolower($team))
				{
					$class = $class." won";
				}
				else
				{
					$class = $class." lost";
				}
				$content .=  "<table>	<tr class='dvlEinzelergebnis $class'>";
				$content .=  "		<td class='dvlDatum'>$result->datum<br /> ".$result->spielbeginn."h</td>";
				$content .=  "		<td class='dvlTeams'><strong>$result->heim</strong><br /> <strong>$result->gast</strong></td>";
				$content .=  "		<td class='dvlErgebnis'><strong>$result->ergebnis</strong> ($result->satz1, $result->satz2, $result->satz3";
				if ($result->satz4 != '0:0') $content .=  ", $result->satz4";
				if ($result->satz5 != '0:0') $content .=  ", $result->satz5";
				$content .=  ") - ";
				$content .=  "$result->gesamtdauer min / $result->zuschauer Zuschauer";
				$content .=  "		</td>";
				$content .=  "	</tr></table>";
			}
			elseif ($result->ergebnis == '0:0' & $i == 1)
			{
				$content .=  "<div class='dvlEinzelergebnis $class'>Es liegen keine Ergebnisse vor!</div>";
			}
			$i++;
			
		}	
		$content .=  "";
		return $content;
	}
	
	/* xmlLeagueShedule: Funktion zur Ausgabe von Spielergebnissen einer Liga zu einem Datum */
	
	function xmlLeagueShedule($template="") 
	{ 
        
		//echo $template;
		//print_r( $this->teamKurz );		
		$content 	= '';
		$i 			= 1;
		$adresse	= $this->adresse;
        $kennung	= $this->kennung;
        $liga		= $this->liga;
        $datum		= $this->datum;
        $vtage		= $this->vtage;
        $ntage		= $this->ntage;
        $team		= $this->team;
		/* Datum -> Timestamp */
		$datumTS		= strtotime($datum);
		
		/* Anzahl der Tage vor dem Termin */
		if (!isset($vtage)) $vtage = 3;
		
		/* Anzahl der Tage nach dem Termin */
		if (!isset($ntage)) $ntage = 3;
		
		/* Summe Tage */
		$tage = $vtage + $ntage + 1;
		$content	= '';
		for ($j=0;$j<$tage;$j++) 
		{
			
			
			$sdatum	= mktime(0, 0, 0, date("m",$datumTS)  , date("d",$datumTS)-$vtage+$j, date("Y",$datumTS));
			$ddatum = date("d.m.Y",$sdatum);
			
			$adresse	= $adresse."?kennung=".$kennung."&job=ergebnisse&liga=".$liga."&datum=".$ddatum;
			$DVL		= simplexml_load_file($adresse);
			
			
			/* Ausgabe der Daten */
			
			if (!empty($DVL)) 
			{
				$date = new DateTime();
 
				setlocale(LC_TIME, "de_DE");
				
				foreach ($DVL->einzelergebnis as $result)
				{                   
					$html 		='"'.$result->spielnr.'": {  "html":"'. $template.'",    "last_update": '.$date->getTimestamp().'   }';
					
					
					// Ersetzungen für alle Arten (Zukunft, live, fertig
					$html = str_replace ('###LIGA###',$liga, $html );
					$html = str_replace ('###SPIELNR###',$result->spielnr, $html );
					$html = str_replace ('###SPIELDATUM###',str_replace( '.20' ,'.' ,$result->datum) . ' ' . $result->spielbeginn . 'h' ,$html );
					$html = str_replace ('###HOME###',$result->heim, $html );
					$html = str_replace ('###HOMEID###',$result->heimid, $html );
						//echo intval($result->heimid) . ' - ' . $this->teamKurz[intval($result->heimid)] . '<br />';
					$result->heimkurz = $this->teamKurz[intval($result->heimid)];
					$html = str_replace ('###HOMESHORT###',$result->heimkurz, $html );
					$html = str_replace ('###GUEST###',$result->gast, $html );
					$html = str_replace ('###GUESTID###',$result->gastid, $html );
					$result->gastkurz = $this->teamKurz[intval($result->gastid)];
					$html = str_replace ('###GUESTSHORT###',$result->gastkurz, $html );
					
					if ($result->ergebnis != '0:0')   // Spiel schon beendet
					{
						$html = str_replace ('###CLASSTICKERAKTIV###','', $html );
						$html = str_replace ('###AKTERGEBNIS###',$result->ergebnis, $html );
						
						If ( $dvlStatitikURL[$liga]) {
							$html = str_replace ('###STATISTIKBUTTON###', '<a href=\'' . $this->dvlStatitikURL[$liga] . '\' class=\'statistik_aktiv\'>&nbsp;</a>', $html );
						} else  {
							$html = str_replace ('###STATISTIKBUTTON###','<div  class=\'statistik_inaktiv\'>&nbsp;</div>', $html );
						}
						
						$html = str_replace ('###CLASSLINIESTATISTIKAKTIV###','bg_blau_duenn_grad', $html );
						
						
						$html = str_replace ('###AKTERGEBNIS###',$result->ergebnis, $html );
						$html = str_replace ('###AKTERGEBNIS###',$result->ergebnis, $html );
						
						$arraySatz = explode( ":" , $result->satz1 );						
						$html = str_replace ('###Set1Home###',$arraySatz[0], $html );
						$html = str_replace ('###Set1Guest###',$arraySatz[1], $html );
						$arraySatz = explode( ":" , $result->satz2 );						
												
						$html = str_replace ('###Set2Home###',$arraySatz[0], $html );
						$html = str_replace ('###Set2Guest###',$arraySatz[1], $html );
						$arraySatz = explode( ":" , $result->satz3 );						
						
						$html = str_replace ('###Set3Home###',$arraySatz[0], $html );
						$html = str_replace ('###Set3Guest###',$arraySatz[1], $html );
						$arraySatz = explode( ":" , $result->satz4 );						
						
						$html = str_replace ('###Set4Home###',$arraySatz[0], $html );
						$html = str_replace ('###Set4Guest###',$arraySatz[1], $html );
						$arraySatz = explode( ":" , $result->satz5 );						
						
						$html = str_replace ('###Set5Home###',$arraySatz[0], $html );
						$html = str_replace ('###Set5Guest###',$arraySatz[1], $html );
						 
						$html = str_replace ('###Spectators###',$result->zuschauer, $html );
						$html = str_replace ('###time###',$result->gesamtdauer, $html );
					}
					elseif ($result->ergebnis == '0:0')   // Spiel noch nicht beendet
					{
						$spielBeginnTimeObject = date_create_from_format ( 'd.m.Y H:i' , $result->datum . ' ' . $result->spielbeginn );
						$spielBeginnTimeStamp  = date_timestamp_get( $spielBeginnTimeObject );
						
						
						//print_r($spielBeginnTimeObject );
						 //echo $spielBeginnTimeStamp . ' - ' . time() . ' - '.$this->liveTickerSekBevorSpielBeginn . ' <br />';
						
						if (  ( $spielBeginnTimeStamp - $this->liveTickerSekBevorSpielBeginn ) < time() ) {  // Spiel wird gerade gespeilt
							
							$html = str_replace ('###CLASSTICKERAKTIV###','border_red', $html );
							
							$html = str_replace ('###CLASSLINIESTATISTIKAKTIV###','bg_rot_duenn_grad', $html );
							
							
							
							//aus soap-Schnittstelle
							
							
							$html = str_replace ('###STATISTIKBUTTON###','###AKTSATZHOME###<a href=\'###STATISTIKURL###\' class=\'###CLASSSTATISTIKURL###\'>&nbsp;</a>###AKTSATZGUEST### ', $html );
						
							$html = str_replace ('###AKTERGEBNIS###',$result->ergebnis, $html );
							$html = str_replace ('###Set1Home###','0', $html );
							$html = str_replace ('###Set1Guest###','0', $html );
							$html = str_replace ('###Set2Home###','0', $html );
							$html = str_replace ('###Set2Guest###','0', $html );
							$html = str_replace ('###Set3Home###','0', $html );
							$html = str_replace ('###Set3Guest###','0', $html );
							$html = str_replace ('###Set4Home###','0', $html );
							$html = str_replace ('###Set4Guest###','0', $html );
							$html = str_replace ('###Set5Home###','0', $html );
							$html = str_replace ('###Set5Guest###','0', $html );
							
							
							
							$html = str_replace ('###Spectators###',$result->zuschauer, $html );
							$html = str_replace ('###time###',$result->gesamtdauer, $html );
							
							
						} else {        // Spiel noch nicht angefangen
						    
							$html = str_replace ('###CLASSTICKERAKTIV###','ticker_spiel_inaktiv', $html );
							
							$html = str_replace ('###AKTERGEBNIS###',$result->ergebnis, $html );
							$html = str_replace ('###STATISTIKBUTTON###','<div  class=\'statistik_inaktiv\'>&nbsp;</div>', $html );
							$html = str_replace ('###CLASSLINIESTATISTIKAKTIV###','bg_grau_duenn_grad', $html );
							
							$html = str_replace ('###Set1Home###','0', $html );
							$html = str_replace ('###Set1Guest###','0', $html );
							$html = str_replace ('###Set2Home###','0', $html );
							$html = str_replace ('###Set2Guest###','0', $html );
							$html = str_replace ('###Set3Home###','0', $html );
							$html = str_replace ('###Set3Guest###','0', $html );
							$html = str_replace ('###Set4Home###','0', $html );
							$html = str_replace ('###Set4Guest###','0', $html );
							$html = str_replace ('###Set5Home###','0', $html );
							$html = str_replace ('###Set5Guest###','0', $html );
							
							
							
							$html = str_replace ('###Spectators###',$result->zuschauer, $html );
							$html = str_replace ('###time###',$result->gesamtdauer, $html );
							//$html = utf8_encode ($html);
						}
						
					}
					$i++;
					if ($content=='') {
						$content = ' {  '.$html; 
       				} 
                    else {
                     	$content .= ' ,  '.$html;
                    }
				}	
				
			
			}
			
         }
        if ($content!='') { $content .= ' }  '; } else { $content .= '""';} 
        //echo $content;
		return $content;
	}

	/* xmlTeamShedule: Funktion zur Ausgabe von Spielplan mit Ergebnissen eines Teams */
	
	function xmlTeamShedule($anzahl=NULL) 
	{
		$i 			= 1;
		$j 			= 1;
		$adresse	= $this->adresse;
        $kennung	= $this->kennung;
        $team		= $this->team;

		/* Prüfung auf Temporäre Datei */
		
		
		$DVL		= simplexml_load_file($adresse);
		
				
		/* Ausgabe der Daten */

		/* Einzelergebnisse */
		$content .=  "<table>";
		foreach ($DVL->einzelergebnis as $result)
		{
			if ($i % 2 == 0)
			{
				$class = "even";
			}
			else
			{
				$class = "odd";
			}
			
			if ($j==1 & $result->ergebnis == '0:0')
			{
				$class = $class." next";
			}
			
			if ($result->ergebnis != '0:0' & !isset($anzahl))
			{
				$erg	= explode(":",$result->ergebnis);
				if ($erg[0]>$erg[1] & strtolower($result->heim) == strtolower($team))
				{
					$class = $class." won";
				}
				elseif ($erg[0]<$erg[1] & strtolower($result->gast) == strtolower($team))
				{
					$class = $class." won";
				}
				else
				{
					$class = $class." lost";
				}
				$content .=  "	<tr class='dvlEinzelergebnis $class'>";
				$content .=  '		<td class="dvlDatum">'.str_replace('.20', '.', $result->datum).' '.$result->spielbeginn.'h</td>';
				$content .=  "		<td class='dvlTeams'><strong>$result->heim</strong> vs. <strong>$result->gast</strong></td>";
				$content .=  "		<td class='dvlErgebnis'><strong>$result->ergebnis</strong> ($result->satz1, $result->satz2, $result->satz3";
				if ($result->satz4 != '0:0') $content .=  ", $result->satz4";
				if ($result->satz5 != '0:0') $content .=  ", $result->satz5";
				$content .=  ") - ";
				$content .=  "$result->gesamtdauer min / $result->zuschauer Zuschauer";
				$content .=  "		</td>";
				$content .=  "	</tr>";
			}
			elseif ($result->ergebnis == '0:0' & (!isset($anzahl) or $anzahl == 0))
			{
				$content .=  "	<tr class='dvlEinzelergebnis $class'>";
				$content .=  '		<td class="dvlDatum">'.str_replace('.20', '.', $result->datum).' '.$result->spielbeginn.'h</td>';
				$content .=  "		<td class='dvlTeams'><strong>$result->heim</strong> vs. <strong>$result->gast</strong></td>";
				$content .=  "		<td class='dvlOrt'>$result->spielhalle ($result->hallenort)</td>";
				$content .=  "	</tr>";
				$j++;
			}
			elseif ($result->ergebnis == '0:0')
			{
				if ($j <= $anzahl)
				{
					$content .=  "	<tr class='dvlEinzelergebnis $class'>";
					$content .=  '		<td class="dvlDatum">'.str_replace('.20', '.', $result->datum).' '.$result->spielbeginn.'h</td>';
					$content .=  "		<td class='dvlTeams'><strong>$result->heim</strong> vs. <strong>$result->gast</strong></td>";
					$content .=  "		<td class='dvlOrt'>$result->spielhalle ($result->hallenort)</td>";
					$content .=  "	</tr>";
					$j++;
				}
			}
			$i++;
			
		}	
		$content .=  "</table>";
		return $content;
	}
	
}

?>