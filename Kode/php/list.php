<?php
require 'config.php';

$sql = $database->prepare("SELECT romnummer, dato, fratid, tiltid, student, prosjektor, max(antall) as num FROM reservasjon GROUP BY student, romnummer, dato, fratid, tiltid ORDER BY dato, fratid ASC;");
$sql->setFetchMode(PDO::FETCH_OBJ);
$sql->execute();
echo "<table style='width:500'>";
echo "<tr><th>Rom</th><th>Dato</th><th>Fra</th><th>Til</th><th>Student</th><th>Antall</th><th>Prosjektor</th></tr>";
while($item = $sql->fetch()) {
	if (date("Y-m-d") < $item->dato || date("Y-m-d") == $item->dato && time() < strtotime($item->fratid)) {
		echo "<tr>";
		echo "<td>$item->romnummer</td><td>$item->dato</td><td>$item->fratid</td><td>$item->tiltid</td><td>$item->student</td><td>$item->num</td>";
		if ($item->prosjektor == "1") {
			echo "<td>Ja</td>";
		} else {
			echo "<td>Nei</td>";
		}
		echo "</tr>";
	}
}
echo "</table>";

?>
