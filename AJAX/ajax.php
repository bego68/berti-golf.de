<?php
	if ($_GET) {
		echo $_GET["ajaxget"];
	} else if ($_POST) {
		echo $_POST["ajaxpost"];
	} else {
		echo "Direktaufruf oder load()-Daten (GET)";
	}
?>