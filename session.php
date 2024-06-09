<?php
session_start();
if (!(isset($_SESSION['Name']))) {
    header("Location: index.php");
    exit();
}
if (!(isset($_SESSION['sessionid']))) {
    header("Location: roomPage.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Game</title>
    <?php
    $utilisateur2 = "";
    include 'connection.php';
    $conn = new MySQLi($server, $username, $password);
    $requette = "select * from " . $dbname . ".session  where session.id=" . $_SESSION['sessionid'];
    $resultat = $conn->query($requette);

    while ($row = $resultat->fetch_assoc()) {
        $joueur = $_SESSION['type'] == "visiteur" ? "joueur1id" : "joueur2id";
        $requette = "select * from " . $dbname . ".utilisateur  where id=" . $row[$joueur];
        $resultat = $conn->query($requette);
        while ($row1 = $resultat->fetch_assoc()) {
            $utilisateur2 = $row1["nomutilisateur"];
        }
    }

    if (isset($_POST["home"])) {

        unset($_SESSION["sessionid"]);
        unset($_SESSION["type"]);
        header("Location: roomPage.php");
        exit();
    }

    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
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



        input[type="radio"] {
            position: absolute;
            top: -9999em;
        }

        html,
        body {
            font-family: Mandali, Arial, sans-serif;
            font-size: 16px;
        }

        .center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        #board {
            width: 50vmin;
            height: 50vmin;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            grid-template-rows: 1fr 1fr 1fr;
        }

        .tile {
            margin: 5%;
            position: relative;
        }

        .tile label,
        .tile div {
            display: block;
            height: 100%;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background: rgba(255, 255, 255, 0.80);
            font-family: Raleway, Courier, 'Courier New', Sans, sans-serif;
            font-weight: bolder;
        }

        .tile div {
            display: none;
            overflow: hidden;
            text-shadow: 0 1px 6px rgba(0, 0, 0, 0.85)
        }

        label[for$='-x'] {
            z-index: 1;
        }

        input:checked~#board label[for$='-o'] {
            z-index: 2;
        }

        input:checked~input:checked~#board label[for$='-x'] {
            z-index: 3;
        }

        input:checked~input:checked~input:checked~#board label[for$='-o'] {
            z-index: 4;
        }

        input:checked~input:checked~input:checked~input:checked~#board label[for$='-x'] {
            z-index: 5;
        }

        input:checked~input:checked~input:checked~input:checked~input:checked~#board label[for$='-o'] {
            z-index: 6;
        }

        input:checked~input:checked~input:checked~input:checked~input:checked~input:checked~#board label[for$='-x'] {
            z-index: 7;
        }

        input:checked~input:checked~input:checked~input:checked~input:checked~input:checked~input:checked~#board label[for$='-o'] {
            z-index: 8;
        }

        input:checked~input:checked~input:checked~input:checked~input:checked~input:checked~input:checked~input:checked~#board label[for$='-x'] {
            z-index: 9;
        }

        input[id*='-0-']:checked~#board label[for*='-0-'],
        input[id*='-1-']:checked~#board label[for*='-1-'],
        input[id*='-2-']:checked~#board label[for*='-2-'],
        input[id*='-3-']:checked~#board label[for*='-3-'],
        input[id*='-4-']:checked~#board label[for*='-4-'],
        input[id*='-5-']:checked~#board label[for*='-5-'],
        input[id*='-6-']:checked~#board label[for*='-6-'],
        input[id*='-7-']:checked~#board label[for*='-7-'],
        input[id*='-8-']:checked~#board label[for*='-8-'] {
            display: none;
        }

        input[id*='-0-']:checked~#board #tile-0 div,
        input[id*='-1-']:checked~#board #tile-1 div,
        input[id*='-2-']:checked~#board #tile-2 div,
        input[id*='-3-']:checked~#board #tile-3 div,
        input[id*='-4-']:checked~#board #tile-4 div,
        input[id*='-5-']:checked~#board #tile-5 div,
        input[id*='-6-']:checked~#board #tile-6 div,
        input[id*='-7-']:checked~#board #tile-7 div,
        input[id*='-8-']:checked~#board #tile-8 div {
            display: block;
        }

        input[id*='-0-x']:checked~#board #tile-0 div::before,
        input[id*='-1-x']:checked~#board #tile-1 div::before,
        input[id*='-2-x']:checked~#board #tile-2 div::before,
        input[id*='-3-x']:checked~#board #tile-3 div::before,
        input[id*='-4-x']:checked~#board #tile-4 div::before,
        input[id*='-5-x']:checked~#board #tile-5 div::before,
        input[id*='-6-x']:checked~#board #tile-6 div::before,
        input[id*='-7-x']:checked~#board #tile-7 div::before,
        input[id*='-8-x']:checked~#board #tile-8 div::before {
            content: "X";
            background: #004974;
            color: #89dcf6;
        }

        input[id*='-0-o']:checked~#board #tile-0 div::before,
        input[id*='-1-o']:checked~#board #tile-1 div::before,
        input[id*='-2-o']:checked~#board #tile-2 div::before,
        input[id*='-3-o']:checked~#board #tile-3 div::before,
        input[id*='-4-o']:checked~#board #tile-4 div::before,
        input[id*='-5-o']:checked~#board #tile-5 div::before,
        input[id*='-6-o']:checked~#board #tile-6 div::before,
        input[id*='-7-o']:checked~#board #tile-7 div::before,
        input[id*='-8-o']:checked~#board #tile-8 div::before {
            content: "O";
            background: #a60011;
            color: #ffc7b5;
        }

        .tile label:hover {
            cursor: pointer;
            background: rgba(255, 255, 255, 0.5);
        }

        .tile label::before,
        .tile div::before {
            color: #000;
            position: absolute;
            text-align: center;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 7.5vmin;
            font-weight: bold;
        }

        .tile div::before {
            padding: 100%;
        }

        .tile label[for$='-o']:hover::before {
            content: "O";
        }

        .tile label[for$='-x']:hover::before {
            content: "X";
        }

        #tile-0 {
            grid-column: 1;
            grid-row: 1;
        }

        #tile-0 label,
        #tile-0 div {
            border-radius: 10% 0 0 0;
        }

        #tile-1 {
            grid-column: 2;
            grid-row: 1;
        }

        #tile-2 {
            grid-column: 3;
            grid-row: 1;
        }

        #tile-2 label,
        #tile-2 div {
            border-radius: 0 10% 0 0;
        }

        #tile-3 {
            grid-column: 1;
            grid-row: 2;
        }

        #tile-4 {
            grid-column: 2;
            grid-row: 2;
        }

        #tile-5 {
            grid-column: 3;
            grid-row: 2;
        }

        #tile-6 {
            grid-column: 1;
            grid-row: 3;
        }

        #tile-6 label,
        #tile-6 div {
            border-radius: 0 0 0 10%;
        }

        #tile-7 {
            grid-column: 2;
            grid-row: 3;
        }

        #tile-8 {
            grid-column: 3;
            grid-row: 3;
        }

        #tile-8 label,
        #tile-8 div {
            border-radius: 0 0 10% 0;
        }

        #end {
            background: rgba(255, 255, 255, 0.85);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: none;
        }

        #message {
            text-align: center;
            font-size: 2rem;
            line-height: 2.2rem;
            font-weight: bold;
            display: flex;
            flex-direction: column;
            gap: 2rem;
            text-transform: uppercase;
        }






        #message input {
            background: #000;
            color: #fff;
            font-size: 1rem;
            padding: 0.5rem 1.75rem;
            margin: auto auto;
            margin-top: 2rem;
        }





        .container {
            width: 700px;
            border-radius: 15%;
            position: "relative";
            display: flex;
            flex-direction: column;
            align-items: center;
            pointer-events: all;
        }

        .turn {
            color: black;
            text-align: center;
            background-color: red;
            padding: 10px;
            font-weight: 600;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            position: absolute;
            bottom: 100px;
        }


        .home {
            display: block;
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

        .home {
            background-position: left center;
            color: #fff;
            /* Change la couleur du texte au survol */
        }
    </style>

<body>
    <?php include 'header.php'; ?>

    <div class="container" id="container">

        <form id="tictactoe" method="post">


            <input type="radio" name="cell-0" id="cell-0-x" />
            <input type="radio" name="cell-0" id="cell-0-o" />
            <input type="radio" name="cell-1" id="cell-1-x" />
            <input type="radio" name="cell-1" id="cell-1-o" />
            <input type="radio" name="cell-2" id="cell-2-x" />
            <input type="radio" name="cell-2" id="cell-2-o" />
            <input type="radio" name="cell-3" id="cell-3-x" />
            <input type="radio" name="cell-3" id="cell-3-o" />
            <input type="radio" name="cell-4" id="cell-4-x" />
            <input type="radio" name="cell-4" id="cell-4-o" />
            <input type="radio" name="cell-5" id="cell-5-x" />
            <input type="radio" name="cell-5" id="cell-5-o" />
            <input type="radio" name="cell-6" id="cell-6-x" />
            <input type="radio" name="cell-6" id="cell-6-o" />
            <input type="radio" name="cell-7" id="cell-7-x" />
            <input type="radio" name="cell-7" id="cell-7-o" />
            <input type="radio" name="cell-8" id="cell-8-x" />
            <input type="radio" name="cell-8" id="cell-8-o" />

            <div id="board" class="center">
                <div class="tile" id="tile-0">
                    <?php if ($_SESSION['type'] == "visiteur")  echo '<label for="cell-0-o"></label>';
                    else echo '<label for="cell-0-x"></label>'
                    ?>
                    <div></div>
                </div>
                <div class="tile" id="tile-1">
                    <?php if ($_SESSION['type'] == "visiteur")  echo '<label for="cell-1-o"></label>';
                    else echo '<label for="cell-1-x"></label>'
                    ?>
                    <div></div>
                </div>
                <div class="tile" id="tile-2">
                    <?php if ($_SESSION['type'] == "visiteur")  echo '<label for="cell-2-o"></label>';
                    else echo '<label for="cell-2-x"></label>'
                    ?>
                    <div></div>
                </div>
                <div class="tile" id="tile-3">
                    <?php if ($_SESSION['type'] == "visiteur")  echo '<label for="cell-3-o"></label>';
                    else echo '<label for="cell-3-x"></label>'
                    ?>
                    <div></div>
                </div>
                <div class="tile" id="tile-4">
                    <?php if ($_SESSION['type'] == "visiteur")  echo '<label for="cell-4-o"></label>';
                    else echo '<label for="cell-4-x"></label>'
                    ?>
                    <div></div>
                </div>
                <div class="tile" id="tile-5">
                    <?php if ($_SESSION['type'] == "visiteur")  echo '<label for="cell-5-o"></label>';
                    else echo '<label for="cell-5-x"></label>'
                    ?>
                    <div></div>
                </div>
                <div class="tile" id="tile-6">
                    <?php if ($_SESSION['type'] == "visiteur")  echo '<label for="cell-6-o"></label>';
                    else echo '<label for="cell-6-x"></label>'
                    ?>
                    <div></div>
                </div>
                <div class="tile" id="tile-7">
                    <?php if ($_SESSION['type'] == "visiteur")  echo '<label for="cell-7-o"></label>';
                    else echo '<label for="cell-7-x"></label>'
                    ?>
                    <div></div>
                </div>
                <div class="tile" id="tile-8">
                    <?php if ($_SESSION['type'] == "visiteur")  echo '<label for="cell-8-o"></label>';
                    else echo '<label for="cell-8-x"></label>'
                    ?>
                    <div></div>
                </div>
            </div>
            <div id="end">
                <div id="message" class="center">
                    <span id="msg"></span>
                    <button type="submit" for="tictactoe" class="home" id="home" name="home" value="return">Return Home</button>
                </div>
            </div>

        </form>
        <div class="turn" id="turn"></div>




    </div>
</body>


<script>
    function send(box) {
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {

            }
        };
        xmlhttp.open("GET", "send.php?carreau=" + box, true);
        xmlhttp.send();
    }

    function recieve() {
        const oponentname = "<?php echo $utilisateur2 ?>";

        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            var type = "<?php echo $_SESSION['type'] ?>";
            if (this.readyState == 4 && this.status == 200) {


                var carreaux = JSON.parse(this.responseText);



                var turn = carreaux.filter(value => value == 0).length % 2;
                if (
                    carreaux[0] == 1 && carreaux[1] == 1 && carreaux[2] == 1 ||
                    carreaux[3] == 1 && carreaux[4] == 1 && carreaux[5] == 1 ||
                    carreaux[6] == 1 && carreaux[7] == 1 && carreaux[8] == 1 ||

                    carreaux[0] == 1 && carreaux[3] == 1 && carreaux[6] == 1 ||
                    carreaux[1] == 1 && carreaux[4] == 1 && carreaux[7] == 1 ||
                    carreaux[2] == 1 && carreaux[5] == 1 && carreaux[8] == 1 ||

                    carreaux[0] == 1 && carreaux[4] == 1 && carreaux[8] == 1 ||
                    carreaux[2] == 1 && carreaux[4] == 1 && carreaux[6] == 1
                ) {
                    document.getElementById('turn').style.display = "none";
                    document.getElementById('end').style.display = "block"
                    document.getElementById('msg').innerHTML = "<?php echo $_SESSION["type"] ?>" == "visiteur" ? `${oponentname} win` : "You win"
                    document.getElementById('container').style.pointerEvents = "all"



                } else if (
                    carreaux[0] == 2 && carreaux[1] == 2 && carreaux[2] == 2 ||
                    carreaux[3] == 2 && carreaux[4] == 2 && carreaux[5] == 2 ||
                    carreaux[6] == 2 && carreaux[7] == 2 && carreaux[8] == 2 ||

                    carreaux[0] == 2 && carreaux[3] == 2 && carreaux[6] == 2 ||
                    carreaux[1] == 2 && carreaux[4] == 2 && carreaux[7] == 2 ||
                    carreaux[2] == 2 && carreaux[5] == 2 && carreaux[8] == 2 ||

                    carreaux[0] == 2 && carreaux[4] == 2 && carreaux[8] == 2 ||
                    carreaux[2] == 2 && carreaux[4] == 2 && carreaux[6] == 2

                ) {
                    document.getElementById('turn').style.display = "none";
                    document.getElementById('end').style.display = "block"
                    document.getElementById('msg').innerHTML = "<?php echo $_SESSION["type"] ?>" == "createur" ? `${oponentname} win` : "You win"
                    document.getElementById('container').style.pointerEvents = "all"


                } else if (carreaux.filter(value => value == 0).length === 0) {
                    document.getElementById('turn').style.display = "none";
                    document.getElementById('end').style.display = "block"
                    document.getElementById('msg').innerHTML = "Draw"
                    document.getElementById('container').style.pointerEvents = "all"


                } else if ((turn == 1 && type == "createur") || (turn == 0 && type == "visiteur")) {
                    document.getElementById('turn').innerHTML = "Your turn";
                    document.getElementById('container').style.pointerEvents = "all"

                } else {
                    document.getElementById('turn').innerHTML = `${oponentname}'s turn`
                    document.getElementById('container').style.pointerEvents = "none"


                }


                carreaux.forEach((value, index) => {
                    if (value == '2') {
                        document.getElementById(`cell-${index}-o`).setAttribute("checked", true)
                    }
                    if (value == '1') {
                        document.getElementById(`cell-${index}-x`).setAttribute("checked", true)
                    }

                })


            }
        };
        xmlhttp.open("GET", "recieve.php?rec=1", true);
        xmlhttp.send();
    }
    recieve();
    setInterval("recieve();", 500);

    [1, 2, 3, 4, 5, 6, 7, 8, 9].forEach(i => {

        document.getElementById(`tile-${i-1}`).addEventListener("click", () => {
            send(i)
        })

    })
</script>


</html>