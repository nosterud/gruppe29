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
			//echo $bruker . "<br>" . $dato . "<br>" . $tid1 . "<br>" . $tid2 . "<br>" . $ant . "<br>" . $rom . "<br>";
			if ($_POST["Prosjektor"] == "Ja") {
				//echo "Prosjektor ja<br>";
				$prosjektor = 1;
			} else {
				//echo "Prosjektor nei<br>";
				$prosjektor = 0;
			}
			if ($prosjektor == 1) {
				$sql = $database->prepare("SELECT romnummer, dato, fratid, tiltid, prosjektor FROM reservasjon WHERE prosjektor = 1;");
				$sql->setFetchMode(PDO::FETCH_OBJ);
				$sql->execute();
				while($test = $sql->fetch()) {
					if ($rom == $test->romnummer && $test->dato == $dato && strtotime($tid1) >= strtotime($test->fratid) && strtotime($tid1) < strtotime($test->tiltid) || $prosjektor == 1 && $rom == $test->romnummer && $test->dato == $dato && strtotime($tid1) <= strtotime($test->fratid) && strtotime($tid2) > strtotime($test->fratid)) {
						echo "Noen har allerede reservert prosjektoren på denne tiden<br>";
						$tid1 = "";
					}
				}
			}
			$sql = $database->prepare("SELECT max(antall) as num, dato, fratid, tiltid FROM reservasjon where romnummer = $rom GROUP BY student, romnummer, dato, fratid, tiltid;");
			$sql->setFetchMode(PDO::FETCH_OBJ);
			$sql->execute();
			$count = 0;
			while ($test = $sql->fetch()) {
				if ($test->dato == $dato && strtotime($tid1) < strtotime($test->fratid) && strtotime($tid1) < strtotime($test->tiltid) || $test->dato == $dato && strtotime($tid1) >= strtotime($test->fratid) && strtotime($tid2) > strtotime($test->tiltid) || $test->dato == $dato && strtotime($tid1) > strtotime($test->fratid) && strtotime($tid2) < strtotime($test->tiltid)) {
					$count += $ant;
					if ($count + $test->num > 4) {
						echo "Rommet har ikke plass! <br>";
						$rom = "";
					}
				}
			}
			if ($dato == "" || $tid1 == "" || $tid2 == "" || $rom == 0 || $ant == 0 || $bruker == "") {
				echo "Noe gikk galt!";
			} else {
				if ($tid1 < $tid2) {
					if ($dato > date("Y-m-d") || $dato == date("Y-m-d") && strtotime($tid1) > time()) {
						for ($i = 1; $i <= $ant; $i++) {
							$sql = $database->prepare("INSERT INTO reservasjon (romnummer, dato, fratid, tiltid, student, antall, prosjektor) VALUES ('$rom', '$dato', '$tid1', '$tid2', '$bruker', '$i', $prosjektor);");
							$sql->execute();
						}
						header("refresh: 1; url=../html/Layout.html");
					} else {
						echo "Bookingen kan ikke være før nå.";
					}
				} else {
					echo "Start-tiden må være mindre enn slutt-tiden!";
				}
			}
		} else {
			echo "Du er ikke logget inn, du vil bli dirigert til login-siden.";
			header("refresh: 5; url=login.php");
		}
		echo "<br><a href='../html/Layout.html'>Tilbake!</a>";
	}
?>