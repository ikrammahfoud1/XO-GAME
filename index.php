<?php
session_start();
if (isset($_SESSION['Name'])) {
    header("Location:roomPage.php");
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Welcome to Toe!</title>
    <?php
    $register_error = "";
    $login_error = "";

    include 'connection.php';

    $conn = new mysqli($server, $username, $password);


    if (isset($_POST['submit'])) {

        switch ($_POST['submit']) {
            case "Login":


                $sql = 'SELECT * FROM ' . $dbname . '.utilisateur ';
                $result = $conn->query($sql); // 

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($row['nomutilisateur'] == $_POST['utilisateur'] && $row['motpasse'] == $_POST['motpasse']) {

                            $_SESSION['Name'] =  $row['nomutilisateur'];
                            $_SESSION['Id'] = $row['id'];

                            header("Location: roomPage.php");
                            exit();
                        } else {
                            $login_error = "UserName or Password Is Incorrect!";
                        }
                    }
                }

                break;
            case "Signup":
                $utilisateur = "";
                $motpasse = "";
                $confirm_motpasse = "";
                $motpasse = $_POST['motpasse'];
                $confirm_motpasse = $_POST['confirm_motpasse'];
                $utilisateur = $_POST['utilisateur'];
                if ($confirm_motpasse == $motpasse) {

                    include 'connection.php';
                    $conn = new mysqli($server, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        $register_error = die("Connection failed: " . $conn->connect_error);
                    }

                    $requete = "SELECT * FROM `utilisateur` WHERE nomutilisateur='" . $utilisateur . "'";
                    $resultat = $conn->query($requete);
                    if ($resultat->num_rows > 0) {
                        $register_error = "Username Already Exists!";
                    } else {

                        $requete = "INSERT INTO `utilisateur`(`nomutilisateur`, `motpasse`) VALUES ('" . $utilisateur . "','" . $motpasse . "')";
                        if ($conn->query($requete) == true) {

                            $requete = "select * from utilisateur where nomutilisateur='" . $utilisateur . "'";
                            $resultat = $conn->query($requete);
                            while ($row = $resultat->fetch_assoc()) {
                                $_SESSION['Name'] =  $row['nomutilisateur'];
                                $_SESSION['Id'] =  $row['id'];

                                header("Location:roomPage.php");
                                exit();
                            }
                        }
                    }
                } else {
                    $register_error = "Passwords not matched!";
                }
                break;
        }
    }

    $conn->close();





    ?>



    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        html,
        body {
            display: grid;
            height: 100%;
            width: 100%;
            place-items: center;
            background: url("tic.jpg") no-repeat center center;
            background-size: cover;
        }

        ::selection {
            background: #fa4299;
            color: #fff;
        }

        .wrapper {
            overflow: hidden;
            max-width: 390px;
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 15px 20px rgba(0, 0, 0, 0.1);

        }

        .wrapper .title-text {
            display: flex;
            width: 200%;
        }

        .wrapper .title {
            width: 50%;
            font-size: 35px;
            font-weight: 600;
            text-align: center;
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .wrapper .slide-controls {
            position: relative;
            display: flex;
            height: 50px;
            width: 100%;
            overflow: hidden;
            margin: 30px 0 10px 0;
            justify-content: space-between;
            border: 1px solid lightgrey;
            border-radius: 5px;
        }

        .slide-controls .slide {
            height: 100%;
            width: 100%;
            color: #fff;
            font-size: 18px;
            font-weight: 500;
            text-align: center;
            line-height: 48px;
            cursor: pointer;
            z-index: 1;
            transition: all 0.6s ease;
        }

        .slide-controls label.signup {
            color: #000;
        }

        .slide-controls .slider-tab {
            position: absolute;
            height: 100%;
            width: 50%;
            left: 0;
            z-index: 0;
            border-radius: 5px;
            background: linear-gradient(to right, #a445b2, #fa4299);

            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        input[type="radio"] {
            display: none;
        }

        #signup:checked~.slider-tab {
            left: 50%;
        }

        #signup:checked~label.signup {
            color: #fff;
            cursor: default;
            user-select: none;
        }

        #signup:checked~label.login {
            color: #000;
        }

        #login:checked~label.signup {
            color: #000;
        }

        #login:checked~label.login {
            cursor: default;
            user-select: none;
        }

        .wrapper .form-container {
            width: 100%;
            overflow: hidden;
        }

        .form-container .form-inner {
            display: flex;
            width: 200%;
        }

        .form-container .form-inner form {
            width: 50%;
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .form-inner form .field {
            height: 50px;
            width: 100%;
            margin-top: 20px;
        }

        .form-inner form .field input {
            height: 100%;
            width: 100%;
            outline: none;
            padding-left: 15px;
            border-radius: 5px;
            border: 1px solid lightgrey;
            border-bottom-width: 2px;
            font-size: 17px;
            transition: all 0.3s ease;
        }

        .form-inner form .field input:focus {
            border-color: #fc83bb;
            /* box-shadow: inset 0 0 3px #fb6aae; */
        }

        .form-inner form .field input::placeholder {
            color: #999;
            transition: all 0.3s ease;
        }

        form .field input:focus::placeholder {
            color: #b3b3b3;
        }

        .form-inner form .pass-link {
            margin-top: 5px;
        }

        .form-inner form .signup-link {
            text-align: center;
            margin-top: 30px;
        }

        .form-inner form .pass-link a,
        .form-inner form .signup-link a {
            color: #fa4299;
            text-decoration: none;
        }

        .form-inner form .pass-link a:hover,
        .form-inner form .signup-link a:hover {
            text-decoration: underline;
        }

        form .btn {
            height: 50px;
            width: 100%;
            border-radius: 5px;
            position: relative;
            overflow: hidden;
        }

        form .btn .btn-layer {
            height: 100%;
            width: 300%;
            position: absolute;
            left: -100%;
            background: linear-gradient(to right, #ff0000, #0d5791, #0000ff);



            border-radius: 5px;
            transition: all 0.4s ease;
            ;
        }

        form .btn:hover .btn-layer {
            left: 0;
        }

        form .btn input[type="submit"] {
            height: 100%;
            width: 100%;
            z-index: 1;
            position: relative;
            background: none;
            border: none;
            color: #fff;
            padding-left: 0;
            border-radius: 5px;
            font-size: 20px;
            font-weight: 500;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <div class="title-text">
            <div class="title login">Login Form</div>
            <div class="title signup">Signup Form</div>
        </div>
        <div class="form-container">
            <div class="slide-controls">
                <input type="radio" name="slide" id="login" checked>
                <input type="radio" name="slide" id="signup">
                <label for="login" class="slide login">Login</label>
                <label for="signup" class="slide signup">Signup</label>
                <div class="slider-tab"></div>
            </div>
            <div class="form-inner">
                <form id="login_form" class="login" method="POST">
                    <div class="field">
                        <input type="text" placeholder="Username" name="utilisateur" required>
                    </div>
                    <div class="field">
                        <input type="password" placeholder="Password" name="motpasse" required>
                    </div>

                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" id="login" value="Login" name="submit">
                    </div>
                    <?php echo '<p style="color:red">' . $login_error . "</p>" ?>

                    <div class="signup-link">Not a member? <a href="">Signup now</a></div>
                </form>
                <form id="signup_form" class="signup" method="POST" action="index.php#signup">
                    <div class="field">
                        <input type="text" placeholder="Username" name="utilisateur" required>
                    </div>
                    <div class="field">
                        <input type="password" placeholder="Password" name="motpasse" required>
                    </div>
                    <div class="field">
                        <input type="password" placeholder="Confirm password" name="confirm_motpasse" required>
                    </div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" id="register" value="Signup" name="submit">
                    </div>
                    <?php echo '<p style="color:red">' . $register_error . "</p>" ?>

                </form>
            </div>
        </div>
    </div>
    <script src="login.js"></script>

</body>

</html>