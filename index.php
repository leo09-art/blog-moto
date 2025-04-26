<?php
include 'pdo.php';
$data = $bdd->query('SELECT * from user');
$users = $data->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
if (isset($_POST['ok'])) {
    if(!empty($_POST['mail'])) $email= $_POST['mail'];
    if (!empty($_POST['mail']) and !empty($_POST['password'])) {

        $email = $_POST['mail'];
        $password = $_POST['password'];

            $sql = "SELECT * from user where email=:email and password = :password";
            $req = $bdd->prepare(($sql));
            // $req->execute(array($email, $password));
            $req->bindParam(':email',$email);
            $req->bindParam(':password',$password);
            $req->execute();
            $cpt = $req->rowCount();
            if($cpt==1){
                $message="Vous avez été trouver";
                header('location: tailwindcss/index.php');
            }else{
                $message=  "inscrivez vous d'abord pour pouvoir vous connecter";
            }
 
    }else{
        $message="Veuillez remplir tous les champs";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&family=Agu+Display&family=Caveat:wght@400..700&family=Dancing+Script:wght@400..700&family=Edu+AU+VIC+WA+NT+Arrows:wght@400..700&family=Jersey+15&family=Noto+Sans+JP:wght@100..900&family=Playwrite+IN:wght@100..400&family=Playwrite+PT+Guides&family=Playwrite+TZ+Guides&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Audiowide&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Agdasima:wght@400;700&family=Audiowide&display=swap');
        form {
            background: linear-gradient(to top, burlywood, #81bfbc);
            background: url(background.jpg);
            object-fit: cover;
            /* background-color: (0,0,0,0.5); */
            background-size: cover;
            /* background-repeat: no-repeat; */
            /* object-fit: contain; */

        }

        form .container .body img {
            width: 40px;
        }

        .container {
            display: grid;
            grid-template-columns: auto auto;
            grid-template-rows: auto auto auto auto;
            text-align: center;
            grid-template-areas:
                "header header"
                "ajout ajout"
                "body body"
                "footer footer";
        }

        .container .footer {
            grid-area: footer;
            font-size: 1.2rem;
        }

        .container .header {
            grid-area: header;
            font-size: 4rem;
            color: burlywood;
            font-family: "Jersey 15", serif;
        }

        .container .header #h1 {
            content: "Connexion";
            position: absolute;
        }

        .container .header #h1original {
            text-shadow: 0px 0px 12px #81bfbc;
        }

        .container .header #h1 {
            animation: 7s theflash infinite ease-in;
        }

        @keyframes theflash {
            0% {
                opacity: 0;
                transform: translateX(-100%);
                text-shadow: 7px -13px 14px black;
                ;
            }

            50% {
                opacity: 0.5;
                transform: translateX(0);
                text-shadow: -11px -14px 13px #95b6c5;
                ;
            }

            100% {
                opacity: 0;
                transform: translateX(20%);
                text-shadow: -1px 0px 13px #95b6c5;
            }
        }

        .container .body {
            grid-area: body;
            font-size: 2rem;
        }

        .container .body input {
            height: 50px;
            width: 200px;
            margin: 15px;
            border-radius: 10px;
            transition: 1s;
            font-family: "Audiowide", serif;
        }

        .container .body label {
            font-family: "Caveat", serif;
            color: wheat;
            font-size: 50px;

        }

        .container .body input:hover {
            box-shadow: -9px -2px 18px 2px #6fb35d;
        }

        .container .body .button input {
            border: 0px solid teal;
            transition: 1s;
            height: 90px;
            width: 150px;
            font-size: 2rem;
            font-family: "Caveat", serif;
        }

        .container .body .button input:hover {
            border: 2px dashed teal;
            box-shadow: 0 4 15 red;
            background-color: black;
            color: antiquewhite;
            font-size: 40px;
        }

        .container .footer {
            text-align: center;
            display: grid;
            grid-template-rows: auto;
            grid-template-columns: auto auto;
            column-rule: 8px outset gray;
            grid-template-areas:
                "p1 p2";

        }

        .container .body .footer #p1 {
            grid-area: p1;
        }

        .container .body .footer #p2 {
            grid-area: p2;
        }
        .container #ajout{
            grid-area: ajout;
            font-family: "Agdasima", serif;
            font-size: 50px;
            font-weight: 400px;
        }
    </style>
</head>

<body>

    <form action="connexion.php" method="POST">
        <div class="container">
            <div id="ajout"  style="color:red;">
                <?php 
                    if(isset($message))
                        echo $message."<br/>";
                ?>
            </div>
            <div class="header">
                <h1 id="h1">Connexion</h1>
                <h1 id="h1original">Connexion</h1>
            </div>
            <div class="body">
                <div class="email">
                    <label for="mail">E-mail : </label>
                    <input type="email" name="mail" id="mail" value="<?php if(isset($email)) echo $email; ?>">
                    <img src="email_icon.png" alt="">
                </div>
                <div class="password">
                    <label for="password">Password : </label>
                    <input type="password" name="password" id="password">
                    <img src="password-icon.jpg" alt="">
                </div>
                <div class="button">
                    <input type="submit" value="Envoyer" name="ok">
                    <input type="reset" value="Annuler">
                </div>
            </div>
            <div class="footer" style="color:beige;">
                <p id="p1">Si vous n'avez pas de compte <a href="creation.php">Créer un compte !</a> </p>
                <!-- <p id="p2"><a href="password_oublie.php?email=".<?php if(isset($email)) echo $email; ?>>Mot de passe oublié!</a></p> -->
                <p id="p2"><a href="password_oublie.php?email=<?php if(isset($email))echo $email;?>">Mot de passe oublié!</a></p>
            </div>



    </form>

    </div>

    </div>
</body>

</html>