<?php
session_start();
include 'connection.php';
$conn = new mysqli($server, $username, $password);
if (isset($_GET['id'])) {
    $roomid = $_GET['id'];



    $requette = "SELECT * FROM " . $dbname . ".`session` WHERE  roomid=" . $roomid;
    $resultat = $conn->query($requette);
    if ($resultat->num_rows === 1) {
        while ($row = $resultat->fetch_assoc()) {
            $_SESSION["sessionid"] =  $row['id'];
            $_SESSION['type'] = 'createur';
        }
        echo "user_joined_room";
    } else echo "false";
} else
    echo "false";
