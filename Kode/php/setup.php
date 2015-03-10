<?php
require 'config.php';

$sql = $database->prepare("CREATE TABLE bruker (brukernavn varchar(20) NOT NULL, passord varchar(20), PRIMARY KEY (brukernavn));");
$sql->execute();

$sql = $database->prepare("CREATE TABLE gruppe (gruppenummer int NOT NULL AUTO_INCREMENT, bruker varchar(20), PRIMARY KEY (gruppenummer, bruker), FOREIGN KEY (bruker) REFERENCES bruker(brukernavn));");
$sql->execute();

$sql = $database->prepare("CREATE TABLE reservasjon (romnummer int NOT NULL, dato date NOT NULL, tid time NOT NULL, gruppe int NOT NULL, prosjektor boolean, aktiv boolean, PRIMARY KEY (romnummer, dato, tid, gruppe), FOREIGN KEY (gruppe) REFERENCES gruppe(gruppenummer));");
$sql->execute();

echo "Created tables";

?>
