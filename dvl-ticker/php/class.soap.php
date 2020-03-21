 <?php
 
 class SOAP{
 	
 	private $ch; 
 	private $result;
 	
 	function __construct($url,$postdata  ){
 	
 		
 		//echo $url;
 		//echo $postdata;
		$headers[]= "Content-Type: text/xml; charset=utf-8"; 
		 
		$this->ch = curl_init(); 
		 
		curl_setopt($this->ch, CURLOPT_HTTPHEADER,     $headers ); 
		curl_setopt($this->ch, CURLOPT_URL,            $url );   
		curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 5); 
		curl_setopt($this->ch, CURLOPT_TIMEOUT,        5); 
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($this->ch, CURLINFO_HEADER_OUT, true);
		curl_setopt($this->ch, CURLOPT_POST,           true ); 
		curl_setopt($this->ch, CURLOPT_POSTFIELDS,    $postdata); 
		$this->result = curl_exec($this->ch);
		 
		
	}
		
	function exec(){
		
		$this->result = curl_exec($this->ch);
		$code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
		//echo curl_getinfo($this->ch,CURLINFO_HEADER_OUT);
		
		return $code;
		
 	}
 	
 	function putResult(){
 		 try {		
				$p = xml_parser_create();
				xml_parse_into_struct($p, $this->result, $vals, $index);
				//echo '<pre>';print_r($index);print_r($vals);echo '</pre>';
				xml_parser_free($p);
				$erg =  array();
				
				foreach($vals as $i => $el  ){
					//echo $i.'-'.$el['tag'].'-'.$el['value'].'<br />';
					//If ( $el['tag'] and $el['value'])
					if ( $i < $index['PLAYERS_HOMETEAM'][0] ) {
						$erg[$el['tag']] = $el['value'];
					} else if ( ( $i > $index['PLAYERS_HOMETEAM'][0]) and ( $i < $index['PLAYERS_HOMETEAM'][1])) {
						$erg['PLAYERS_HOMETEAM'][$el['tag']][] = $el['value'];
					}else if ( ( $i > $index['PLAYERS_GUESTTEAM'][0]) and ( $i < $index['PLAYERS_GUESTTEAM'][1])){
						$erg['PLAYERS_GUESTTEAM'][$el['tag']][] = $el['value'];
					}
					 
				}
				$obj = (object) $erg;
	            
			}
			catch(Exception $e) {
		    	//echo($e->errorMessage()."\n");
		   		echo $xmlstr.'<br />';
			}	
 		
 		return  $obj;
	}
}
?>