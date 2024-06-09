<?php
session_start();
if (!(isset($_SESSION['Name']))) {
    header("Location: index.php"); /* Redirect browser */
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic tac toe</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            /* Centrer le contenu horizontalement */
            height: 100vh;
            /* Prendre la hauteur de la fenêtre entière */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url("tic.jpg") no-repeat;
            background-size: cover;
            display: flex;
            flex-direction: column;
        }

        .button-container button:hover {
            background-color: #0d5791;
            /* Nouvelle couleur de fond au survol */
            color: #fff;
            /* Nouvelle couleur du texte au survol */
        }

        p {
            font-size: 20px;
            font-weight: bold;
        }

        .button-container {
            border-radius: 10px;
            /* Bordures arrondies */
            /*background-color: rgba(255,69,178,1); */
            /* Couleur de fond avec opacité */
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            /* Espacement interne */
            display: flex;
            /* Changer le display en flex */
            flex-direction: column;
            /* Organiser les boutons en colonne */
            justify-content: center;
            /* Centrer les boutons verticalement */
            align-items: center;
            /* Centrer les boutons horizontalement */
            width: 75%;
            /* Agrandir la largeur */
            max-width: 600px;
            /* Définir une largeur maximale */
            height: 30%;
        }

        .button-container button {
            display: block;
            width: 80%;
            margin-bottom: 10px;
            padding: 20px;
            font-size: 20px;
            color: #fff;
            /* Couleur du texte des boutons */
            border: none;
            /* Supprimer les bordures */
            border-radius: 10px;
            /* Arrondir les coins */
            cursor: pointer;
            /* Curseur de souris en pointer */
            background: rgb(0, 33, 71);
            /* Dégradé linéaire */
            background-size: 200% 100%;
            transition: all 0.4s ease-in-out;
        }

        .button-container button:hover {
            background-position: left center;
            color: #fff;
            /* Change la couleur du texte au survol */
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="button-container">
        <button type="button" id="create_room" id="create_room">Create a room</button>
        <p><b>Or</b></p>
        <button type="button" id="join_room">Join a room</button>
    </div>

</body>
<script src="roomPage.js"></script>


</html>