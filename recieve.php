<?php
session_start();
if (isset($_GET['rec'])) {
	include 'connection.php';
	$session_resultat = "";
	$conn = new MySQLi($server, $username, $password);
	$requette = "select * from " . $dbname . ".session where id=" . $_SESSION['sessionid'];
	$resultat = $conn->query($requette);

	$requette = "select * from " . $dbname . ".session where id=" . $_SESSION['sessionid'];
	$resultat = $conn->query($requette);
	while ($row = $resultat->fetch_assoc()) {

		echo json_encode(array($row['carreau1'], $row['carreau2'], $row['carreau3'], $row['carreau4'], $row['carreau5'], $row['carreau6'], $row['carreau7'], $row['carreau8'], $row['carreau9']));
	}
}
