<!Doctype html>
<html>
<head>
	<title>Prototype</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../css/LayoutStyleSheet.css">
	<?php
		if(isset($_COOKIE["user"])) {
			$bruker = $_COOKIE["user"];
		}
	?>
</head>
<body>
	<div id="header">
		<h1>Header</h1>
	</div>
	<?php if(isset($_COOKIE["user"])) { ?>
	<p id="logged">Hallo, <?php echo "$bruker" ?></p>
	<?php } else { ?>
	<form method="post" action="../php/login.php" id="loginField" style="position: relative; float: right;">
		<input type="text" name="studentnummer">
		<input type="password" name="passord">
		<input type="submit" value="Login">
	</form>
	<?php } ?>
</body>
</html>
