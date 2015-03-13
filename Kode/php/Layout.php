<?php
require 'config.php';
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_COOKIE["user"])) {
			$bruker = $_COOKIE["user"];
			$dato = $tid = "";
			$ant = $rom = 0;
			$proj = false;
			$dato = test_input($_POST["bday"]);
			$tid1 = test_input($_POST["from_time"]);
			$tid2 = test_input($_POST["to_time"]);
			$ant = test_input($_POST["quantity"]);
			$rom = test_input($_POST["rom"]);
			echo $bruker . "<br>" . $dato . "<br>" . $tid1 . "<br>" . $tid2 . "<br>" . $ant . "<br>" . $rom . "<br>";
			if ($_POST["Prosjektor"] == "Ja") {
				echo "Prosjektor ja<br>";
				$prosjektor = true;
			} else {
				echo "Prosjektor nei<br>";
				$prosjektor = false;
			}
			if ($dato == "" || $tid1 == "" || $tid2 == "" || $rom == 0 || $ant == 0 || $bruker == "") {
				echo "Noe gikk galt!";
			} else {
				if ($tid1 < $tid2) {
					if ($dato > date("Y-m-d") || $dato == date("Y-m-d") && strtotime($tid1) > time()) {
						$sql = $database->prepare("INSERT INTO reservasjon (romnummer, dato, fratid, tiltid, student, prosjektor) VALUES ('$rom', '$dato', '$tid1', '$tid2', '$bruker', $prosjektor);");
						$sql->execute();
					} else {
						echo "DATOEN ER FEIL";
					}
				} else {
					echo "TIDEN ER FEIL!";
				}
			}
		} else {
			header("Location: login.php");
		}
	}
?>