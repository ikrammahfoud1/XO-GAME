<?php
session_start();
if (!(isset($_SESSION['Name']))) {
    header("Location: index.php");
    exit();
} ?>

<?php
$error = "";
$id = "";
$createurId = "";
if (isset($_POST['code'])) {
    $code = $_POST['code'];
    include "connection.php";

    $conn = new mysqli($server, $username, $password);

    $requette = "SELECT * FROM " . $dbname . ".`room` WHERE  motpasse=" . $code;
    $resultat = $conn->query($requette);

    if ($resultat->num_rows === 0) {

        $error = "No room with this pass code";
    } else {
        while ($row = $resultat->fetch_assoc()) {
            $id =  $row['id'];
            $createurId =  $row['createurid'];
        }
        $requette = "SELECT * FROM " . $dbname . ".`session` WHERE  roomid=" . $id;
        $resultat = $conn->query($requette);

        if ($resultat->num_rows === 1) {
            $error = "Game already played";
        } else {


            $requette = "INSERT INTO " . $dbname . ".`session`(`joueur2id`, `joueur1id`, `carreau1`, `carreau2`, `carreau3`, `carreau4`, `carreau5`, `carreau6`, `carreau7`, `carreau8`, `carreau9`,`roomid`) VALUES (" . $_SESSION['Id'] . "," . $createurId . ",0,0,0,0,0,0,0,0,0," . $id . ")";
            $conn->query($requette);
            $requette = "select * from " . $dbname . ".session where roomid =" . $id;
            $resultat = $conn->query($requette);
            while ($row = $resultat->fetch_assoc()) {
                $_SESSION['sessionid'] = $row['id'];
            }
            $_SESSION['type'] = 'visiteur';

            header("Location: session.php");
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Join a room</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .error {
            color: red;
            text-align: center;
            background-color: red;
            padding: 10px;
            font-weight: 600;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            transform: translateX(-10%);


        }

        body {
            font-family: Arial, sans-serif;
            text-align: center;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url("tic.jpg") no-repeat;
            background-size: cover;
        }

        .container .code {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 20px;
            font-size: 20px;
            color: #000000;
            border: none;
            /* Supprimer les bordures */
            border-radius: 10px;
            /* Arrondir les coins */
            cursor: pointer;
            /* Curseur de souris en pointer */
            background: #fff;
            /* Dégradé linéaire */
            background-size: 200% 100%;
            transition: all 0.4s ease-in-out;
            transform: translateX(-10%);
            box-shadow: #0000ff;
        }

        .container .button {
            display: block;
            width: 50%;
            margin-bottom: 10px;
            transform: translateX(30%);
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
            background: linear-gradient(to right, #a445b2, #fa4299);
            ;
            /* Dégradé linéaire */
            background-size: 200% 100%;
            transition: all 0.4s ease-in-out;
        }

        .container {
            width: 700px;
            transform: translateX(10%);
            border-radius: 15%;
        }
    </style>

<body>
    <?php include 'header.php'; ?>

    <div class="container">

        <form method="post">
            <input class="code" type="text" id="code" placeholder="Enter your room code " name="code" type="number" required>
            <input class="button" type="submit" id="join" value="Join now" name="join_room">

        </form>
        <?php
        if ($error)         echo '<div class="error">' . $error . "</div>" ?>


    </div>
</body>

</html>