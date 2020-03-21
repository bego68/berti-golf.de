<?php 

class dataproject{
	
private $request = array (
          	'HelloWorldResponse' => array( 	'body' => 	'<?xml version="1.0" encoding="utf-8"?>
															<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
																<soap:Body><HelloWorldResponse xmlns="http://VOLLEYBALL/WS_Livescore/" >
																	<HelloWorldResult> Hallo Berti</HelloWorldResult></HelloWorldResponse>  
																</soap:Body>
															</soap:Envelope>',
											'url' =>	'http://dvl.dataproject-stats.com/WebServices/WS_Livescore.asmx?op=HelloWorldResponse?wsdl' 
											
										),
			'MatchInfo'  => 	array( 		'body' => 	'<?xml version="1.0" encoding="utf-8"?>
															<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
															  <soap:Body>
															    <MatchInfoByIDPHP xmlns="http://VOLLEYBALL/WS_Livescore/">
															      <FederationMatchID>###FederationMatchID###</FederationMatchID>
															      <Username>###Username###</Username>
															      <Password>###Password###</Password>
															      <Key>###Key###</Key>
															    </MatchInfoByIDPHP>
															  </soap:Body>
															</soap:Envelope>',
										    'url' =>	"http://dvl.dataproject-stats.com/WebServices/WS_Livescore.asmx?op=MatchInfo?wsdl"
										),
										
			'MatchInfoPHP'  => array( 		'body' => 	'<?xml version="1.0" encoding="utf-8"?>
																<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
																  <soap12:Body>
																    <MatchInfoPHP xmlns="http://VOLLEYBALL/WS_Livescore/">
																      <FederationMatchNumber>###FederationMatchNumber###</FederationMatchNumber>
																      <Username>###Username###</Username>
																      <Password>###Password###</Password>
																      <Key>###Key###</Key>
																    </MatchInfoPHP>
																  </soap12:Body>
																</soap12:Envelope>',
						    				'url'	=>	"http://dvl.dataproject-stats.com/WebServices/WS_Livescore.asmx?op=MatchInfoPHP?wsdl",
										),
			'MatchInfoByIDPHP' 	 => array( 		'body' => 	'<?xml version="1.0" encoding="utf-8"?>
															<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
															  <soap12:Body>
															    <MatchStatsByIDPHP xmlns="http://VOLLEYBALL/WS_Livescore/">
															      <FederationMatchID>###FederationMatchID###</FederationMatchID>
															      <Username>###Username###</Username>
															      <Password>###Password###</Password>
															      <Key>###Key###</Key>
															  </soap12:Body>
															</soap12:Envelope>',
										'url'	=>	"http://dvl.dataproject-stats.com/WebServices/WS_Livescore.asmx?op=MatchInfoByIDPHP?wsdl"
										),
			'MatchStatsByIDPHP'  => 	array( 		'body' => 	'<?xml version="1.0" encoding="utf-8"?>
																<soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
																  <soap12:Body>
																    <MatchStatsByIDPHP xmlns="http://VOLLEYBALL/WS_Livescore/">
																       <FederationMatchID>###FederationMatchID###</FederationMatchID>
																	   <Username>###Username###</Username>
																	   <Password>###Password###</Password>
																	   <Key>###Key###</Key>
																    </MatchStatsByIDPHP>
																  </soap12:Body>
																</soap12:Envelope>',
										'url'	=>	"http://dvl.dataproject-stats.com/WebServices/WS_Livescore.asmx?op=MatchStatsByIDPHP?wsdl"
										)
				);
				
	private $url='http://dvl.dataproject-stats.com/WebServices/WS_Livescore.asmx?op=HelloWorldResponse?wsdl';	
	private $body='';	

	
	function __construct($FederationMatchID=14567, $request='MatchStatsByIDPHP',$Username='DVL_Online_User',$Password='DVL_s2009+',	$Key='Online',$FederationMatchNumber=0){
		$finde 		= array('###FederationMatchID###', '###request###','###Username###','###Password###',	'###Key###','###FederationMatchNumber###');
		$ersetze 	= array( $FederationMatchID, $request, $Username, $Password, $Key, $FederationMatchNumber);
		$this->url	= $this->request[$request]['url'];
		$this->body	= str_replace( $finde, $ersetze ,$this->request[$request]['body']);
		
	}
	
	function getUrl(){
		return $this->url;
	}	

	function getBody(){
		return $this->body;
	}	
														
		
}


?>