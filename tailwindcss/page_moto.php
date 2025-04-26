<?php
include '../pdo.php';

if (isset($_GET['id_moto'])) {
    $id_moto = $_GET['id_moto'];
    $req = $bdd->prepare("SELECT * from moto where id_moto = :id");
    $req->bindParam(':id', $id_moto, PDO::PARAM_INT);
    $req->execute();
    $moto = $req->fetch(PDO::FETCH_ASSOC);
    // var_dump($moto);


    // $req = $bdd->prepare("SELECT * from commentaire where id_moto = :id");
    // $req->bindParam(':id', $id_moto, PDO::PARAM_INT);
    // $req->execute();
    // $commentaires = $req->fetchAll(PDO::FETCH_ASSOC);

    $req = $bdd->prepare("SELECT c.description, u.name FROM  commentaire c join user u on c.id_user = u.id WHERE c.id_moto = :id ;");
    $req->bindParam(':id', $id_moto, PDO::PARAM_INT);
    $req->execute();
    $commentaires = $req->fetchAll(PDO::FETCH_ASSOC);
    $rows = $req->rowCount();
}



?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://unpkg.com/@tailwindcss/browser@4"></script> -->
    <title>Document</title>
    <script src="../style.js"></script>

    <style>
        :root {
            --font: "Rubik Microbe";
        }

        @import url('https://fonts.googleapis.com/css2?family=Agdasima:wght@400;700&family=Audiowide&family=Hanalei&family=Rubik+Microbe&display=swap');

        #message {
            font-family: "Hanalei", serif;
            font-size: 4rem;
            color: darkorange;
        }
    </style>
</head>

<body class="bg-gray-900">
    <div class="text-blue-200 flex justify-center text-2xl hover:bg-blue-50 hover:text-blue-700 duration-100 delay-150 bg-gradient-to-r from-blue-400 via-red-400 to-indigo-600 bg-clip-text text-transparent">
        <a href="index.php" class="p-3">Retour à l'accueil...</a>
    </div>

    <div class="grid col-span-1 justify-center">

        <div id="message" class="flex justify-center border border-gray-100">

            <h1 class="uppercase">
                <?php echo $moto['nom_moto']; ?>
            </h1>

        </div>
        <div class="relative rounded w-200 h-180 overflow-hidden hover:shadow-xl grid grid-cols-3 ">
            <div class="col-span-2 object-contain scale-x-100">
                <div>
                    <div
                        class="bg-blue-200 text-white text-sm p-2 rounded-full inline absolute top-0 ml-2 mt-2 flex justify-center">

                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                            <path d="M441-120v-86q-53-12-91.5-46T293-348l74-30q15 48 44.5 73t77.5 25q41 0 69.5-18.5T587-356q0-35-22-55.5T463-458q-86-27-118-64.5T313-614q0-65 42-101t86-41v-84h80v84q50 8 82.5 36.5T651-650l-74 32q-12-32-34-48t-60-16q-44 0-67 19.5T393-614q0 33 30 52t104 40q69 20 104.5 63.5T667-358q0 71-42 108t-104 46v84h-80Z" />
                        </svg>
                        <span class="uppercase"><?php echo $moto['prix_moto'] . " £"; ?></span>
                    </div>
                    <div>
                        <img src="<?php echo $moto['image_moto'] ?>" alt=""
                            class="object-cover aspect-10/7  right-2 ">
                    </div>

                </div>
                <div>
                    <button>
                        <svg id="monsvg" xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="red">
                            <path d="M720-120H280v-520l280-280 50 50q7 7 11.5 19t4.5 23v14l-44 174h258q32 0 56 24t24 56v80q0 7-2 15t-4 15L794-168q-9 20-30 34t-44 14Zm-360-80h360l120-280v-80H480l54-220-174 174v406Zm0-406v406-406Zm-80-34v80H160v360h120v80H80v-520h200Z" />
                        </svg>
                    </button>

                </div>



            </div>
            <div class="p-4 font-bold text-white bg-black bg-opacity-20 text-base">
                <h2 class=" flex justify-center text-4xl text-yellow-400 mb-8">Description</h2>
                <?php echo $moto['com_moto'] ?>
            </div>
        </div>

    </div>
    </div>
    <div class="flex justify-center bg-blue-100 text-4xl">
            <?php if($rows==0) echo "Pas de commentaires"; ?>
        </div>
    <div class="bg-blue-100 h-100 w-100 p-10 grid grid-cols-3 gap-5">
        
        <?php foreach ($commentaires as $commentaire): ?>
            <div class="bg-gray-300 rounded-[30px] ">
                <div class="flex justify-start ">
                    <img src="user_icon.jpg" alt="" class="rounded-full h-10 aspect-auto p-1 ">
                    <p class="p-3"><?php echo $commentaire['name'] ?></p>
                </div>
                <div class="flex justify-center w-full ml-2 ">
                    <textarea name="" id="" rows="4" class="pl-1 pt-1 rounded-xl resize-none w-full " readonly><?php echo $commentaire['description'] ?></textarea>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <script>
        document.getElementById("monsvg").addEventListener("click", function() {
            let couleurActuelle = this.querySelector("path").getAttribute("fill");
            let nouvelleCouleur = couleurActuelle === "red" ? "green" : "red";
            this.querySelector("path").setAttribute("fill", nouvelleCouleur);
        })
    </script>

</body>

</html>