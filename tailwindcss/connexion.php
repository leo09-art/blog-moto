<?php
include '../pdo.php';
$data = $bdd->query('SELECT * from user');
$users = $data->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['deco'])){
    $deco = $_GET['deco'];
}

if (isset($_POST['ok'])) {
    if (!empty($_POST['mail'])) $email = htmlspecialchars($_POST['mail']);
    if (!empty($_POST['mail']) and !empty($_POST['password'])) {

        $email = htmlspecialchars($_POST['mail']);
        $password = htmlspecialchars($_POST['password']);

        $sql = "SELECT * from user where email=:email and password = :password";
        $req = $bdd->prepare(($sql));
        // $req->execute(array($email, $password));
        $req->bindParam(':email', $email);
        $req->bindParam(':password', $password);
        $req->execute();
        $person = $req->fetch();
        $cpt = $req->rowCount();
        if ($cpt == 1) {
            $message = "Vous avez été trouver";
            session_start();
            setcookie('nom', $person['name'], time() + 3600*2 );
            setcookie('email', $person['email'], time() + 3600*2 );
            header('location:index.php');
        } else {
            $message =  "Mot de passe incorrect ou inscrivez vous d'abord pour pouvoir vous connecter";
        }
    } else {
        $message = "Veuillez remplir tous les champs";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../style.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Boldonse&display=swap');
        @theme{
            --font-display: "Boldonse", system-ui;
        }
    </style>

</head>

<body class="h-[100vh] bg-black w-[100vh] text-white p-3">
    <h2 class="flex justify-center items-center text-red-500">
        <?php if(isset($deco)) echo $deco; ?>
    </h2>

    <div class="flex justify-center items-center h-[50%] w-[100vw] p-[10%] text-[9rem] bg-black gap-2 top-[5px] font-bold">
        <div class="">Bike</div>
        <div class="text-black bg-yellow-400 rounded-xl">hub</div>
    </div>

    <form action="connexion.php" method="POST" class="h-[100vh] w-[100vw]">
        <div class="bg-black-">
            <div id="ajout" style="color:red;">
                <?php
                if (isset($message))
                    echo $message . "<br/>";
                ?>
            </div>
            <div class="header">
                <h1 class="text-[3rem] flex justify-center font-bold">Connexion</h1>
            </div>
            <div class="body">
                <div class="text-[2rem] flex justify-center m-2 gap-2">
                    <label for="mail">E-mail  </label>
                    <input type="email" name="mail" id="mail" value="<?php if (isset($email)) echo $email; ?>" class="rounded-lg text-black" required>
                </div>

                <div class="text-[2rem] flex justify-center m-2 gap-2">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required class="text-black rounded-lg">
                </div>

                <div class="text-[1.5rem] flex justify-center m-2 gap-20">
                    <input type="submit" value="Envoyer" name="ok" class="shadow-lg hover:shadow-blue-500/50 rounded-full" required>
                    <input type="reset" value="Annuler" class="" onmouseover="this.style.textShadow='5px 2px 4px rgba(18, 187, 108, 0.88)'" onmouseout="this.style.textShadow='none'">
                </div>
            </div>
            <div class="flex justify-center" style="color:beige;">
                <p id="p1">Si vous n'avez pas de compte <a href="../creation.php" class="text-indigo-300">Créer un compte !</a> </p>
                <!-- <p id="p2"><a href="password_oublie.php?email=".<?php if (isset($email)) echo $email; ?>>Mot de passe oublié!</a></p> -->
                <p id="p2" class="pl-10"><a href="password_oublie.php?email=<?php if (isset($email)) echo $email; ?>"  class="text-fuchsia-300">Mot de passe oublié!</a></p>
            </div>

        </div>

    </form>

    </div>

    </div>
</body>

</html>