<?php

require('class.soap.php');
require('class.dataproject.php');
//echo $result;



function erstelleStatistik( $matchid = 15502, $homeid=3310, $guestid=3312,$liga='bl1m',$homeshort='MD', $guestshort='evivo', $datum="12.10.11 18.00h"){

	$dataptoject = new dataproject($matchid);
	$soap = new SOAP($dataptoject->getUrl(),$dataptoject->getBody());
	$topScoreBoard = '0 <span class=\'font_10px\'>-</span> 0';
	
	
	if( $soap->exec() == 200){ 
		$xmlstr=$soap->putResult();
		
		
		if ($liga=='bl1m' or $liga=='bl1f' ){  // 1. liga mit Statistik
			//$tpl_stats_raw 	= file_get_contents('/var/www/vhosts/volleyballserver.de/dvlticker/php/tpl_stats.html');
			$tpl_stats_raw 	= file_get_contents('tpl_stats.html');
			
			$delimter 		= '###HOMEROW###';
			$tpl_stats		= explode($delimter,$tpl_stats_raw );
			$stat_kopf		= $tpl_stats[0];
			$stat_home_tpl	= $tpl_stats[1];
			$stat_rest_raw	= $tpl_stats[2];
			$delimter		= '###GUESTROW###';
			$stat_rest		= explode($delimter,$stat_rest_raw );
			$stat_mitte		= $stat_rest[0];
			$stat_guest_tpl	= $stat_rest[1];
			$stat_rest		= $stat_rest[2];
			
			// Statistik Hometeam
			$i=0;
			$stat_home = '';
			$search 		= array('###HOMEROWCLASS###', '###PLAYERNR###', '###PLAYERNAME###', '###PLAYEDSET###', '###TOTPUNKTE###','###SERVETOT###',
									'###SERVEERR###', '###SERVEWIN###','###RECTOT###', '###RECERR###', '###RECWINPERC###','###SPIKETOT###', 
									'###SPIKEWIN###', '###SPIKEWINPERC###','###BLOCKWIN###');
			//print_r($xmlstr->PLAYERS_HOMETEAM[NUMBER]);
			foreach ($xmlstr->PLAYERS_HOMETEAM[NUMBER] as  $key => $number){
				if ($i % 2 == 1){
					$homeclass 	= 'odd';
				}
				else{
					$homeclass 	= 'even';
				}
				
				$spikewin[$key]	= round($xmlstr->PLAYERS_HOMETEAM['SPIKETOT'][$key] * $xmlstr->PLAYERS_HOMETEAM['SPIKEWINPERC'][$key] / 100);
				$recwin[$key]	= round($xmlstr->PLAYERS_HOMETEAM['RECTOT'][$key] * $xmlstr->PLAYERS_HOMETEAM['RECWINPERC'][$key] / 100);
				$totpunkte[$key]= $xmlstr->PLAYERS_HOMETEAM['BLOCKWIN'][$key] + $xmlstr->PLAYERS_HOMETEAM['SERVEWIN'][$key] + $spikewin[$key];
				
				$replace 		= array($homeclass, $number, $xmlstr->PLAYERS_HOMETEAM['SURNAME'][$key].' '.$xmlstr->PLAYERS_HOMETEAM[NAME][$key],$xmlstr->PLAYERS_HOMETEAM['PLAYEDSET'][$key], $totpunkte[$key], $xmlstr->PLAYERS_HOMETEAM['SERVETOT'][$key],
										$xmlstr->PLAYERS_HOMETEAM['SERVEERR'][$key], $xmlstr->PLAYERS_HOMETEAM['SERVEWIN'][$key], $xmlstr->PLAYERS_HOMETEAM['RECTOT'][$key], $xmlstr->PLAYERS_HOMETEAM['RECERR'][$key], round($xmlstr->PLAYERS_HOMETEAM['RECWINPERC'][$key]).'%', $xmlstr->PLAYERS_HOMETEAM['SPIKETOT'][$key],
										$spikewin[$key], round($xmlstr->PLAYERS_HOMETEAM['SPIKEWINPERC'][$key]).'%', $xmlstr->PLAYERS_HOMETEAM['BLOCKWIN'][$key]);
				$i++;
				$stat_home 		.= str_replace( $search, $replace , $stat_home_tpl);
				
			}
			
				$homeclass 	= 'summe';
				$replace 		= array($homeclass, '', 'TEAM','', array_sum($totpunkte), array_sum($xmlstr->PLAYERS_HOMETEAM['SERVETOT']),
										array_sum($xmlstr->PLAYERS_HOMETEAM['SERVEERR']), array_sum($xmlstr->PLAYERS_HOMETEAM['SERVEWIN']), array_sum($xmlstr->PLAYERS_HOMETEAM['RECTOT']), array_sum($xmlstr->PLAYERS_HOMETEAM['RECERR']),round( 100 * array_sum($recwin) / array_sum($xmlstr->PLAYERS_HOMETEAM['RECTOT']) ).'%', array_sum($xmlstr->PLAYERS_HOMETEAM['SPIKETOT']),
										array_sum($spikewin), round(100 * array_sum($spikewin) / array_sum($xmlstr->PLAYERS_HOMETEAM['SPIKETOT']) ).'%', array_sum($xmlstr->PLAYERS_HOMETEAM['BLOCKWIN']));
				
				$stat_home 		.= str_replace( $search, $replace , $stat_home_tpl);
				
			// Statistik guestteam
			$i=0;
			$stat_guest = '';
			$search 		= array('###GUESTROWCLASS###', '###PLAYERNR###', '###PLAYERNAME###', '###PLAYEDSET###', '###TOTPUNKTE###','###SERVETOT###',
									'###SERVEERR###', '###SERVEWIN###','###RECTOT###', '###RECERR###', '###RECWINPERC###','###SPIKETOT###', 
									'###SPIKEWIN###', '###SPIKEWINPERC###','###BLOCKWIN###');
			 
			foreach ($xmlstr->PLAYERS_GUESTTEAM['NUMBER'] as  $key => $number){
				if ($i % 2 == 1){
					$guestclass 	= 'odd';
				}
				else{
					$guestclass 	= 'even';
				}
				
				$spikewin[$key]	= round($xmlstr->PLAYERS_GUESTTEAM['SPIKETOT'][$key] * $xmlstr->PLAYERS_GUESTTEAM['SPIKEWINPERC'][$key] / 100);
				$recwin[$key]	= round($xmlstr->PLAYERS_GUESTTEAM['RECTOT'][$key] * $xmlstr->PLAYERS_GUESTTEAM['RECWINPERC'][$key] / 100);
				$totpunkte[$key]= $xmlstr->PLAYERS_GUESTTEAM['BLOCKWIN'][$key] + $xmlstr->PLAYERS_GUESTTEAM['SERVEWIN'][$key] + $spikewin[$key];
				
				$replace 		= array($guestclass, $number, $xmlstr->PLAYERS_GUESTTEAM['SURNAME'][$key].' '.$xmlstr->PLAYERS_GUESTTEAM['NAME'][$key],$xmlstr->PLAYERS_GUESTTEAM['PLAYEDSET'][$key], $totpunkte[$key], $xmlstr->PLAYERS_GUESTTEAM['SERVETOT'][$key],
										$xmlstr->PLAYERS_GUESTTEAM['SERVEERR'][$key], $xmlstr->PLAYERS_GUESTTEAM['SERVEWIN'][$key], $xmlstr->PLAYERS_GUESTTEAM['RECTOT'][$key], $xmlstr->PLAYERS_GUESTTEAM['RECERR'][$key], round($xmlstr->PLAYERS_GUESTTEAM['RECWINPERC'][$key]).'%', $xmlstr->PLAYERS_GUESTTEAM['SPIKETOT'][$key],
										$spikewin[$key], round($xmlstr->PLAYERS_GUESTTEAM['SPIKEWINPERC'][$key]).'%', $xmlstr->PLAYERS_GUESTTEAM['BLOCKWIN'][$key]);
				$i++;
				$stat_guest 		.= str_replace( $search, $replace , $stat_guest_tpl);
				
			}
			
			$guestclass 	= 'summe';
			$replace 		= array($guestclass, '', 'TEAM','', array_sum($totpunkte), array_sum($xmlstr->PLAYERS_GUESTTEAM['SERVETOT']),
										array_sum($xmlstr->PLAYERS_GUESTTEAM['SERVEERR']), array_sum($xmlstr->PLAYERS_GUESTTEAM['SERVEWIN']), array_sum($xmlstr->PLAYERS_GUESTTEAM['RECTOT']), array_sum($xmlstr->PLAYERS_GUESTTEAM['RECERR']),round( 100 * array_sum($recwin) / array_sum($xmlstr->PLAYERS_GUESTTEAM['RECTOT']) ).'%', array_sum($xmlstr->PLAYERS_GUESTTEAM['SPIKETOT']),
										array_sum($spikewin), round(100 * array_sum($spikewin) / array_sum($xmlstr->PLAYERS_GUESTTEAM['SPIKETOT']) ).'%', array_sum($xmlstr->PLAYERS_GUESTTEAM['BLOCKWIN']));
				
			$stat_guest 		.= str_replace( $search, $replace , $stat_guest_tpl);
			$search 		= array('###HOMETEAM###' , '###GUESTTEAM###');
			$replace 		= array($xmlstr->HOMETEAM, $xmlstr->GUESTTEAM);
			$tpl_stats 		= str_replace( $search, $replace , $tpl_stats);
			
			
			//$tpl_ticker		= file_get_contents('/var/www/vhosts/volleyballserver.de/dvlticker/php/tpl_ticker.html');
			$tpl_ticker		= file_get_contents('tpl_ticker.html');
			$html 			=  $tpl_ticker.$stat_kopf.$stat_home.$stat_mitte.$stat_guest.$stat_rest;
			
		} else {  // 2. liga ohne Statistik
			$tpl_ticker		= file_get_contents('/var/www/vhosts/volleyballserver.de/dvlticker/php/tpl_ticker.html');
			//$tpl_ticker		= file_get_contents('tpl_ticker.html');
			$html 			=  $tpl_ticker;
		}
		
		if  ( ( $xmlstr->SET1HOME == 0 ) and ( $xmlstr->SET1GUEST == 0 ) ) {
			$classTickerAktiv ='';
			$statistkButton = '<div  class=\'statistik_inaktiv\'>&nbsp;</div>';
			$classLinieStatistikAktiv='bg_grau_duenn_grad';
		}else { 
			
			
			if ( $liga == 'bl1m' or $liga == 'bl1f' ){ // 1. liga mit Statistik
				$statistikButton = '<div  class=\'statistik_aktiv\'>
											
											<a onclick=\'$(&quot;#statistik_'.$xmlstr->FEDERATIONMATCHNUMBER.'&quot;).show(&quot;slow&quot;);\' class=\'statistik_aktiv\'>&nbsp;</a>
											
										   </div>';
			}else { // 2. liga ohne Statistik
				$statistikButton = '<div  class=\'statistik_inaktiv\'>
											
											<a onclick=\'alert(&quot;Statistik in der 2.Liga erst nach dem Spiel &quot;)\' class=\'statistik_inaktiv\'>&nbsp;</a>
											
										   </div>';
			}
			
			$aktSatz =$xmlstr->WONSETHOME+$xmlstr->WONSETGUEST+1;
			
			switch ($aktSatz) {
			
				case 1: $topScoreBoard = $xmlstr->SET1HOME.' <span class=\'font_10px\'>1</span> '.$xmlstr->SET1GUEST;
					break;
				case 2: $topScoreBoard = $xmlstr->SET2HOME.' <span class=\'font_10px\'>2</span> '.$xmlstr->SET2GUEST;
					break;
				case 3: $topScoreBoard = $xmlstr->SET3HOME.' <span class=\'font_10px\'>3</span> '.$xmlstr->SET3GUEST;
					break;
				case 4: $topScoreBoard = $xmlstr->SET4HOME.' <span class=\'font_10px\'>4</span> '.$xmlstr->SET4GUEST;
					break;
				case 5: $topScoreBoard = $xmlstr->SET5HOME.' <span class=\'font_10px\'>5</span> '.$xmlstr->SET5GUEST;
					break;
				default:$topScoreBoard = '0 <span class=\'font_10px\'>-</span> 0';
			}
			
			
			$classTickerAktiv 			= "border_red";
			$classLinieStatistikAktiv	= 'bg_rot_duenn_grad';
			$statistkButton 			= '<b>'.$xmlstr->WONSETHOME.'</b>
											'.$statistikButton.'
										   <b>'.$xmlstr->WONSETGUEST.'</b>';
		}
		
		$search 		= array('###LIGA###','###HOMEID###','###GUESTID###', '###HOME###', '###GUEST###',
							'###SPIELNR###','###SPIELDATUM###','###CLASSTICKERAKTIV###','###STATISTIKBUTTON###','###CLASSLINIESTATISTIKAKTIV###','###AKTERGEBNIS###','###HOMESHORT###','###Set1Home###','###Set1Guest###','###GUESTSHORT###','###Set2Home###','###Set2Guest###',
							'###Set3Home###','###Set3Guest###','###Set4Home###','###Set4Guest###','###Spectators###','###Set5Home###','###Set5Guest###','###time###');
		$replace 		= array($liga, $homeid, $guestid, $xmlstr->HOMETEAM, $xmlstr->GUESTTEAM,
							$xmlstr->FEDERATIONMATCHNUMBER,$datum,$classTickerAktiv,$statistkButton,$classLinieStatistikAktiv, $topScoreBoard,  $homeshort,$xmlstr->SET1HOME,$xmlstr->SET1GUEST,$guestshort,$xmlstr->SET2HOME,$xmlstr->SET2GUEST,
							$xmlstr->SET3HOME,$xmlstr->SET3GUEST,$xmlstr->SET4HOME,$xmlstr->SET4GUEST,$xmlstr->SPECTATORS,$xmlstr->SET5HOME,$xmlstr->SET5GUEST,$xmlstr->TIMESET1+$xmlstr->TIMESET2+$xmlstr->TIMESET3+$xmlstr->TIMESET4+$xmlstr->TIMESET5+$xmlstr->TIMEGOLDENSET);
		$html 			= str_replace( $search, $replace , $html);
		
		return $html;
		
	}


}
 

?>
