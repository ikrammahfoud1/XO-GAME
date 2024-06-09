<?php
session_start();
if (!(isset($_SESSION['Name']))) {
    header("Location: index.php"); /* this redirect user to index page if user is not logged in */
    exit();
} ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Create a room</title>
    <?php


    $random_code = "";
    $id = "";

    include 'connection.php';
    if (isset($_POST['generate_code'])) {

        $conn = new mysqli($server, $username, $password);
        $random_code = random_int(100000, 999999);
        $requette = "INSERT INTO " . $dbname . ".`room`(`createurid`, `motpasse`)  VALUES (" . $_SESSION['Id'] . "," . $random_code . ")";
        $conn->query($requette);

        $requtte = "SELECT id FROM " . $dbname . ".`room` WHERE createurid=" . $_SESSION['Id'] . " and motpasse=$random_code";
        $resultat = $conn->query($requtte);
        while ($row = $resultat->fetch_assoc()) {
            $id =  $row['id'];
        }
    }


    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .wrapper {
            background-color: blue;
            width: 100vw;
        }

        .text {
            font-size: 20px;
            font-weight: 800;
            width: 100%;
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            width: 700px;
            transform: translateX(10%);
            border-radius: 15%;



        }

        .container .white {
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

        .container button {
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
    </style>

<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <form method="post">
            <input class="white" type="text" id="generatedCode" placeholder="click on button below to generate your code" readonly value="<?php echo $random_code ?>">
            <?php if (!$random_code)  echo '<button type="submit" name="generate_code" value="generate_code">Generate a room Code</button>';
            else echo '<button type="button" disabled  >Waiting a player to join room</button>';;
            ?>
        </form>
    </div>
</body>
<script>
    var id = <?php echo $id ?>;

    function verifierRoom() {
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == "user_joined_room") {
                    window.location = "session.php";
                }
            }
        };
        xmlhttp.open("GET", "checkroom.php?id=" + id, true);
        xmlhttp.send();
    }

    if (id) {
        verifierRoom();
        setInterval("verifierRoom();", 600);
    }
</script>

</html>