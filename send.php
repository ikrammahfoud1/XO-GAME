<?php
session_start();
if (isset($_GET['carreau'])) {
	include 'connection.php';
	$conn = new MySQLi($server, $username, $password);
	$requette = "select * from " . $dbname . ".session where id=" . $_SESSION['sessionid'];
	$resultat = $conn->query($requette);
	$val = 0;
	$carreau = $_GET['carreau'];
	while ($row = $resultat->fetch_assoc()) {
		$joueur1id = $row['joueur1id'];
		$joueur2id = $row['joueur2id'];
		$bx = $row['carreau' . $carreau];
		$connectedid = $_SESSION['Id'];
		if ($connectedid ==  $joueur1id)
			$val = 1;
		else if ($connectedid == $joueur2id)
			$val = 2;
	}
	if ($bx == 0) {
		$carreau = $_GET['carreau'];
		$requette = "UPDATE " . $dbname . ".`session` SET `carreau" . $carreau . "`=" . $val . " WHERE id=" . $_SESSION['sessionid'];
		$conn->query($requette);
	} else {
		echo $conn->error;
	}
}
