<?php
require '../php/config.php';

$sql = $database->prepare("CREATE TABLE bruker (studentnummer int NOT NULL, passord varchar(20), PRIMARY KEY (studentnummer));");
$sql->execute();

$sql = $database->prepare("CREATE TABLE reservasjon (romnummer int NOT NULL, dato date NOT NULL, fratid time NOT NULL, tiltid time NOT NULL, student int NOT NULL, antall int NOT NULL, prosjektor boolean, aktiv boolean, PRIMARY KEY (romnummer, dato, fratid, tiltid, student, antall), FOREIGN KEY (student) REFERENCES bruker(studentnummer));");
$sql->execute();

echo "Created tables";

?>
