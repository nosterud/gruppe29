<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$dato = $tid = "";
		$ant = 0;
		$proj = false;
	
		$dato = $_POST["bday"];
		$tid = $_POST["usr_time"];
		$ant = $_POST["quantity"];
		echo $dato . "<br>" . $tid . "<br>" . $ant . "<br>";
		if ($_POST["Prosjektor"] == "Ja") {
			echo "Prosjektor ja";
		} else {
			echo "Prosjektor nei";
		}
	}
?>