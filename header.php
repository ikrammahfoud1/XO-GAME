<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .nav {
            position: absolute;
            top: 0px;
            right: 0px;
            width: 100vw;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            background-color: rgba(255, 255, 255, 0.8);
            align-items: center;



        }
    </style>
</head>

<div class="nav">
    <span style="flex:1; text-align:start;font-size: 20px; font-weight:800;">Welcome
        <?php
        if (isset($_SESSION['Id'])) {
            include 'connection.php';
            $conn = new MySQLi($server, $username, $password);
            $requete = "select * from " . $dbname . ".utilisateur where id=" . $_SESSION['Id'];
            $resultat = $conn->query($requete);

            while ($row = $resultat->fetch_assoc()) {

                $nomutilisateur = $row['nomutilisateur'];
            }

            echo $nomutilisateur;
        }


        ?>
    </span>
    <a href="logout.php" class="btn btn-info btn-lg" style="background-color: rgb(0, 33, 71); border:none;">
        <span class="glyphicon glyphicon-log-out"></span> Log out
    </a>
</div>