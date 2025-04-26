<?php
include 'pdo.php';
$data = $bdd->query('SELECT * from user');
$users = $data->fetchAll();
// echo 'Connexion reussi';
// var_dump($users);
// print_r($users);
?>
<?php
if (isset($_POST['ok'])) {
    $value = $_POST['name'];
    $email = $_POST['mail'];
    $password = $_POST['password'];

    if (!empty($_POST['name']) and !empty($_POST['mail']) and !empty($_POST['password'])) {
        $pseudo = $_POST['name'];
        $email = $_POST['mail'];
        $password = $_POST['password'];
        // $pass = password_hash($password, PASSWORD_DEFAULT);
        $sql = "SELECT * from user where email=? ";
        $req = $bdd->prepare($sql);

        $req->execute(array($email));
        // $req->execute();
        $cpt = $req->rowCount();
        if ($cpt == 0) {
            $sql = 'INSERT INTO user(id,name,email,password) values (null,:pseudo,:email,:password)';
            $stmt = $bdd->prepare($sql);
            // $stmt->bindParam(':id', "1");
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            $message=  'Inscription reussie .';
            $color="green";
            // header('Location : connexion.php');
            $delay = 5; // Par exemple, 5 secondes


            $url = "connexion.php";

            echo "<p>Veuillez patienter, vous serez redirigé dans $delay secondes...</p>";
            //<script>
            //     setTimeout(function(){
            //     window.location.href = '$url';
            //     }, " . ($delay * 1000) . ");
            // </script>"
            header('location: tailwindcss/connexion.php');

        } else {
            $color="red";
            $message = "vous avez deja un compte avec \"$email\"";
        }
    }else {
        $message = "veuillez remplir tous les champs";
    }
}
?>





<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="creation.css">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&family=Agu+Display&family=Caveat:wght@400..700&family=Dancing+Script:wght@400..700&family=Edu+AU+VIC+WA+NT+Arrows:wght@400..700&family=Jersey+15&family=Noto+Sans+JP:wght@100..900&family=Pacifico&family=Playwrite+IN:wght@100..400&family=Playwrite+PT+Guides&family=Playwrite+TZ+Guides&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&family=Agu+Display&family=Bona+Nova+SC:ital,wght@0,400;0,700;1,400&family=Caveat:wght@400..700&family=Dancing+Script:wght@400..700&family=Edu+AU+VIC+WA+NT+Arrows:wght@400..700&family=Jersey+15&family=Noto+Sans+JP:wght@100..900&family=Pacifico&family=Playwrite+IN:wght@100..400&family=Playwrite+PT+Guides&family=Playwrite+TZ+Guides&display=swap');


        form .container .ring .body .content img {
            width: 40px;
        }

        .container {
            display: grid;
            text-align: center;
            justify-content: center;
            gap: 10px;
            background-color: gray;
        }

        .container .header {
            font-size: 4rem;
            font-family: "Pacifico", serif;
        }

        .container .ring .body {
            height: 500px;
            width: 500px;
            display: grid;
            grid-template-columns: auto;
            grid-template-rows: auto auto auto auto;
            justify-items: start;
            gap: 10px;
            font-size: 2rem;
        }

        .container .ring .body .content input {
            /* height: 50px; */
            font-size: 30px;
            width: auto;
            flex: 1;
            border: 1px solid transparent;
            border-radius: 15px;
            background-color: transparent;
            font-family: "Bona Nova SC", serif;
            cursor: text;
        }

        .container .ring .body #button {
            display: flex;
        }

        .container .ring .body #button button {
            /* background: linear-gradient(to right,blue,yellow); */
            top: 20px;
            font-size: 20px;
            width: 150px;
            height: 70px;
            border-radius: 20px;
            /* column-gap: 20px; */
            background: linear-gradient(to left, orange, rosybrown);
            transition: 2s;
            color: wheat;
            margin: 50px;

        }

        .container .ring .body #button button:hover {
            color: green;
            background: antiquewhite;
            cursor: pointer;
            top: 50px;
            font-size: 30px;

        }

        .container .ajout {
            /* color: red; */
            opacity: 0.8;
            font-size: 1.5rem;
            font-family: "Jersey 15", serif;
        }

        .container .ring {
            position: relative;

        }


        .container .ring i {
            position: absolute;
            border: 0px solid white;
            inset: 0;
            transition: 1s;

        }

        .container .ring i:nth-child(2) {
            border-radius: 38% 62% 63% 37% / 41% 44% 56% 59%;
            animation: mymove 5s infinite linear;
        }

        .container .ring i:nth-child(3) {
            border-radius: 92% 94% 90% 100%/95% 86% 94% 99%;
            animation: mymove 10s infinite linear;
        }

        .container .ring i:nth-child(4) {
            border-radius: 98% 94% 90% 86%/90% 86% 94% 98%;
            animation: mymove2 7s infinite linear;
        }

        @keyframes mymove {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes mymove2 {
            0% {
                transform: rotate(360deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        .container .ring:hover i {
            border: 6px solid var(--clr);
            filter: drop-shadow(0 0 20px var(--clr));
        }

        .container .body .content {
            border: 1px solid black;
            border-radius: 2px;
            height: 70px;
            display: flex;
            width: 500px;

        }

        .container .body {
            display: block;
            justify-items: center;

        }

    </style>


</head>

<body>

    <form action="" method="post">
        <div class="container">
            <div class="header">
                <h1>Inscrivez vous </h1>
            </div>
            <p style="color: <?php if(isset($color)) echo $color; ?>;">
                <?php if(isset($message)) echo $message; ?>
            </p>
            <div class="ring">

                <div class="ajout" style="color: <?php if ($_SERVER["REQUEST_METHOD"] == "post") {
                                                        echo $_POST['color'];
                                                    } ?>;">

                </div>
                <!-- <i style="--clr:#fffd44;"></i>
                <i style="--clr:#ff0057;"></i>
                <i style="--clr:#00ff0a;"></i> -->
                <div class="body">
                    <div class="content">
                        <img src="user_icon.jpg" alt="">
                        <label for="name">User </label>
                        <input type="text" name="name" id="name" >
                    </div>
                    <div class="content">
                        <img src="email_icon.png" alt="">
                        <label for="mail">E-mail </label>
                        <input type="email" name="mail" id="mail" >
                    </div>
                    <div class="content">
                        <img src="password-icon.jpg" alt="">
                        <label for="password">Password </label>
                        <input type="password" name="password" id="password">
                    </div>
                    <div id="button">
                        <button type="submit" name="ok">Envoyer</button>
                        <button type="reset"> Annuler</button>
                    </div>
                </div>
            </div>

            <div class="footer" style="color: purple;">
                 <a href="tailwindcss/connexion.php">J'ai déja un compte !</a>
            </div>
        </div>

    </form>

<script>
   
</script>
</body>

</html>