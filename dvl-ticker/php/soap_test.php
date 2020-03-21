<?php

require('./soap.php');

?>
<html>
<head> 
	<meta charset=utf-8 /> 
 
	<meta name="viewport" content="device-width" /> 
 
	<script src="jquery-1.6.2.min.js" type="text/javascript" > </script> 
    
    <!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]--> 
 
	<title>DVL-TICKER 2011/2012</title> 
 
	<link rel="stylesheet" href="dvl-ticker.css" type="text/css" media="screen,projection" /> 
    
</head>

<body>

<?php  echo erstelleStatistik() ?>

</body>
</html>
