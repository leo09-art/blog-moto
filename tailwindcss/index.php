<?php
include '../pdo.php';

$req = $bdd->query('SELECT * from moto');
$motos = $req->fetchAll(PDO::FETCH_ASSOC);

$req = $bdd->prepare("SELECT * from user where email = ?");
$req->execute([$_COOKIE['email']]);
$person = $req->fetch(PDO::FETCH_ASSOC);



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ok'])) {
        $id_moto = $_POST['id_final'];
        $commentaire = $_POST['textarea'];
        if (!empty($commentaire)) {
            $req = $bdd->prepare('INSERT INTO commentaire (description,id_user , id_moto) VALUES (:commentaire,:id_user, :id_moto)');
            $req->bindParam(':commentaire', $commentaire);
            $req->bindParam(':id_user', $person['id']);
            $req->bindParam(':id_moto', $id_moto);
            $req->execute();

            $req = $bdd->prepare('UPDATE moto set nb_comment_moto = nb_comment_moto + 1 where id_moto = ?');
            $req->execute([$id_moto]);
            $id_moto = $_POST['id_final'];
        }
    }
    if (isset($_POST['ok1'])) {
        // var_dump($_POST);
        $req = $bdd->prepare("SELECT * from like_moto where id_user =:id_user and id_moto =:id_moto");
        $req->bindParam(':id_user', $person['id']);
        $req->bindParam(':id_moto', $_POST['id_final']);
        $req->execute();
        $rows = $req->rowCount();
        if ($rows == 0) {
            $req = $bdd->prepare('INSERT INTO like_moto (id_user , id_moto) VALUES (?,?)');
            $req->execute([$person['id'], $_POST['id_final']]);
            $req = $bdd->prepare("UPDATE moto set nb_like_moto = nb_like_moto + 1 where id_moto = ?");
            $req->execute([$_POST['id_final']]);
        } else {
            $req = $bdd->prepare("UPDATE moto set nb_like_moto = nb_like_moto - 1 where id_moto = ?");
            $req->execute([$_POST['id_final']]);
            $req = $bdd->prepare("DELETE from like_moto where id_user = ? and id_moto = ?");
            $req->execute([$person['id'], $_POST['id_final']]);
        }
    }

    // var_dump($_POST);
    $req = $bdd->query('SELECT * from moto');
    $motos = $req->fetchAll(PDO::FETCH_ASSOC);

    $req = $bdd->prepare("SELECT * from user where email = ?");
    $req->execute([$_COOKIE['email']]);
    $person = $req->fetch(PDO::FETCH_ASSOC);
}


if (isset($_POST['fermer'])) {
    setcookie('nom', '', time() - 3600 * 2);
    // session_destroy();
    header('Location: ../connexion.php');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../style.js"></script>

    <!-- <script src="https://unpkg.com/@tailwindcss/browser@4"></script> -->
    <script src="darkmode.js" defer></script>
    <script src="popup.js"></script>
    <style>
        /* @theme {
            
        --color-clifford: #da373d;
      } */

        :root {
            --base-color: #070b1d;
            --base-variant: #101425;
            --text-color: #ffffff;
            --secondary-text: #a4a5b8;
            --primary-color: #3a435d;
            --accent-color: #0071ff;
        }

        .darkmode {
            --base-color: #070b1d;
            --base-variant: #101425;
            --text-color: #ffffff;
            --secondary-text: #a4a5b8;
            --primary-color: #3a435d;
            --accent-color: #0071ff;
        }

        #theme-switch {
            height: 50px;
            width: 50px;
            padding: 0;
            border-radius: 50%;
            background-color: var(--secondary-text);
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 200px;
            left: 11px;
            fill: var(--base-variant);
        }

        #theme-switch svg:last-child {
            display: none;
        }

        .darkmode #theme-switch {
            background-color: var(--base-variant);
            /* color: var(--secondary-text); */
        }

        .darkmode #theme-switch svg:first-child {
            display: none;
        }

        .darkmode #theme-switch svg:last-child {
            display: block;
        }

        .darkmode {
            color: var(--text-color);
            background-color: var(--base-variant);
            color: #a4a5b8;
        }

        #popup-overlay {
            z-index: 2;
            background-color: rgb(25, 25, 25, 0.8);
            /* position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;*/
            display: none;



        }

        #tete {
            z-index: 2;
        }

        #popup-overlay.open {
            display: block !important;
        }

        #bg {
            z-index: 0;
        }
    </style>
</head>

<body id="haut" class="text-[#BE3D2A]">


    <section id="bg" class="">

        <div id="tete" class="flex justify-between sticky top-0 bg-[#F5C45E] h-[100px] w-[98vw] rounded-xl z-98 fixed">
            <div>
                <div class="text-center flex gap-3">

                    <p class="text-3xl ml-5 py-5">Bienvenue</p>
                    <p>
                    <h1 class=" py-5 text-4xl bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 bg-clip-text text-transparent"><?php echo $_COOKIE['nom']; ?></h1>
                    </p>
                </div>
            </div>
            <div class=" flex justify-center justify-items-center ">
                <ul class="flex justify-center">
                    <li class=""><a href="index.php" class="p-3 m-6 flex items-center justify-center ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6 width-2 ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Accueil</a></li>
                    <li><a href="propos.php" class="p-3 m-6 ">

                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                                <path d="M40-160v-160q0-34 23.5-57t56.5-23h131q20 0 38 10t29 27q29 39 71.5 61t90.5 22q49 0 91.5-22t70.5-61q13-17 30.5-27t36.5-10h131q34 0 57 23t23 57v160H640v-91q-35 25-75.5 38T480-200q-43 0-84-13.5T320-252v92H40Zm440-160q-38 0-72-17.5T351-386q-17-25-42.5-39.5T253-440q22-37 93-58.5T480-520q63 0 134 21.5t93 58.5q-29 0-55 14.5T609-386q-22 32-56 49t-73 17ZM160-440q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T280-560q0 50-34.5 85T160-440Zm640 0q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T920-560q0 50-34.5 85T800-440ZM480-560q-50 0-85-35t-35-85q0-51 35-85.5t85-34.5q51 0 85.5 34.5T600-680q0 50-34.5 85T480-560Z" />
                            </svg>
                            A propos</a></li>
                    <li><a href="portefolio.php" class="p-3 m-6 ">

                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                                <path d="M690-480h60v-68l59 34 30-52-59-34 59-34-30-52-59 34v-68h-60v68l-59-34-30 52 59 34-59 34 30 52 59-34v68ZM80-120q-33 0-56.5-23.5T0-200v-560q0-33 23.5-56.5T80-840h800q33 0 56.5 23.5T960-760v560q0 33-23.5 56.5T880-120H80Zm556-80h244v-560H80v560h4q42-75 116-117.5T360-360q86 0 160 42.5T636-200ZM360-400q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM182-200h356q-34-38-80.5-59T360-280q-51 0-97 21t-81 59Zm178-280q-17 0-28.5-11.5T320-520q0-17 11.5-28.5T360-560q17 0 28.5 11.5T400-520q0 17-11.5 28.5T360-480Zm120 0Z" />
                            </svg>
                            Portefolio</a></li>
                    <li><a href="contact.php" class="p-3 m-6 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6 ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 1 0-2.636 6.364M16.5 12V8.25" />
                            </svg>
                            Contact</a></li>

                </ul>

            </div>
            <div class="flex justify-end ">
                <!-- <button name="fermer" class="rounded-full px-2 py-3 cursor-pointer border border-blue-500 hover:bg-blue-800 hover:text-white">DECONNEXION</button> -->
                <a class="rounded-full px-2 py-3 cursor-pointer border border-blue-500 hover:bg-blue-800 hover:text-white flex items-center" href="connexion.php?deco=Vous êtes deconnecté(e)">DECONNEXION</a>

            </div>
        </div>


        <div>
            <div class="text-gray-400 font-mono z-10">
                <div class="grid md:grid-cols-4 ">
                    <div class="p-4 md:col-span-1 justify-end">
                        <nav>
                            <div class="flex items-center">
                                <div class="grid grid-cols-2 gap-1">
                                    <div class="bg-emerald-200 h-5 w-5 "></div>
                                    <div class="bg-purple-200 h-5 w-5"></div>
                                    <div class="bg-blue-700 h-5 w-5"></div>
                                    <div class="bg-yellow-700 h-5 w-5"></div>

                                </div>
                                <h1 class="text-2xl font-bold ml-2">
                                    <a href=""
                                        class="text-gray-300 md: text-blue-300 lg:text-purple-300 hover:text-purple-700 uppercase">smc
                                        ada</a>
                                </h1>
                            </div>

                        </nav>
                    </div>
                    <main class="p-4 md:p-14 md:col-span-3">

                        <!-- creer le formulaire du popup -->
                        <form action="" method="post">
                            <section id="popup-overlay" class=" fixed top-0 bottom-0 left-0 right-0 bg-red-500">
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-99 bg-red-900 w-[70vh]">
                                    <h2 class="text-2xl" id="laisse_com">Laisser votre commentaire </h2>
                                    <textarea name="textarea" id="" rows="12" cols="50" placeholder="Votre commentaire..." class="w-[70vh]"></textarea>
                                    <div class="absolute top-[-20px] right-[-15px] bg-black text-white p-2">
                                        <input type="button" onclick="togglePopup('moo',2)" value="Fermer">
                                    </div>
                                    <div class="w-[100%] flex justify-around">

                                        <input onclick="togglePopup()" type="submit" name="ok" id="ok" value="Valider" class="hover:bg-green-500 p-3 mb-1 rounded bg-white hover:scale-[1.2] duration-300 delay-300">
                                        <input type="text" name="id_final" id="id_final">

                                    </div>
                                </div>

                            </section>
                        </form>


                        <div id="accueil">
                            <header class="mt-8">
                                <h2 class="text-sky-400 text-5xl font-semibold uppercase">auto moto</h2>
                                <h3 class="font-semibold">Pour les pros</h3>
                            </header>
                            <div>
                                <div>
                                    <h4 class="text-gray-700 text-3xl my-4 border-b pb-2 border-gray-100">Les plus recents</h4>


                                    <div class="py-16 grid md:grid-cols-2 lg:grid-cols-3  gap-4  ">
                                        <!-- parcourir toutes les motos de la bd -->
                                        <?php foreach ($motos as $index => $moto) : ?>
                                            <!-- creer un formulaire pour chaque moto afin de pouvoir recuperer les id des motos selectionnées -->
                                            <form action="" method="post" id="myform-<?php echo $index ?>">
                                                <div id="moto-<?php echo $index ?>" class="moto-item rounded overflow-hidden shadow-md relative my-2 hover:shadow-2xl col-span-1 grow">
                                                    <a id="lien-<?php echo $index ?>"><img alt=""
                                                            class="w-full sm:h-48 md:h-42 lg:h-36  object-cover hover:scale-[1.2] delay-100 duration-300" id="image-<?php echo $index ?>"></a>
                                                    <div class="m-4 grid grid-cols-8 xl:block gap-2">
                                                        <div class="col-span-4 grid grid-rows-2 ">
                                                            <span class="font-bold text-2xl uppercase row-span-1" id="nom-<?php echo $index ?>"></span>
                                                            <input type="button" name="ok1" value="Commenter" id="popup-<?php echo $index ?>" class="row-span-1 p-1 bg-gray-800 hover:text-[#60B5FF] hover:text-[24px] min-h-[50px] flex justify-center items-center hover:bg-[#123458] duration-100 delay-100">

                                                            <!-- recupere l'id de la moto pour le popup -->
                                                            <!-- <input type="text" name="id_moto-<?php echo $index ?>" id="id_moto-<?php echo $index ?>" class="block"> -->
                                                        </div>
                                                        <div class="col-span-4  flex justify-around gap-4">
                                                            <div class="mt-5  pt-[15%]">
                                                                <div id="like-<?php echo $index ?>" class="flex justify-center items-center gap-2">
                                                                </div>
                                                                <!-- le champ permettant de liker la moto -->
                                                                <div id="like_boutton-<?php echo $index ?>" class="p-[5px] flex justify-center bg-transparent">
                                                                    <?php
                                                                    $req = $bdd->prepare("SELECT 1 from like_moto where id_user=? and id_moto = ?");
                                                                    $req->execute([$person['id'], $moto['id_moto']]);
                                                                    $hasliked = $req->fetch();
                                                                    ?>
                                                                    <!-- <input type="submit" class="svg-submit g-white rounded-lg" name="ok1" value=""> -->
                                                                    <button type="submit" class="svg-submit g-white rounded-lg scale-150 " name="ok1" id="ok1"><?php if ($hasliked) {
                                                                                                                                                                    echo "❤️";
                                                                                                                                                                } else {
                                                                                                                                                                    echo "🤍";
                                                                                                                                                                } ?></button>
                                                                    <input type="hidden" id="like_cache-<?php echo $index ?>" name="id_final">
                                                                </div>



                                                            </div>
                                                            <!-- le champ qui permet d'afficher le popup -->
                                                            <div id="commentaire-<?php echo $index ?>" class="flex justify-center items-center gap-2">

                                                            </div>
                                                        </div>


                                                    </div>

                                                    <!-- afficher le prix de la moto -->
                                                    <div
                                                        class="bg-blue-200 text-white text-sm p-2 rounded-full inline absolute top-0 ml-2 mt-2 flex justify-center">

                                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                                                            <path d="M441-120v-86q-53-12-91.5-46T293-348l74-30q15 48 44.5 73t77.5 25q41 0 69.5-18.5T587-356q0-35-22-55.5T463-458q-86-27-118-64.5T313-614q0-65 42-101t86-41v-84h80v84q50 8 82.5 36.5T651-650l-74 32q-12-32-34-48t-60-16q-44 0-67 19.5T393-614q0 33 30 52t104 40q69 20 104.5 63.5T667-358q0 71-42 108t-104 46v84h-80Z" />
                                                        </svg>
                                                        <span class="uppercase" id="prix-<?php echo $index ?>"></span>
                                                    </div>
                                                </div>

                                            </form>
                                        <?php endforeach; ?>
                                    </div>

                                </div>

                            </div>
                            <div class=" flex justify-center gap-3 sm:flex md:grid-rows-1">
                                <div class="bg-gray-100 text-gray-800 py-2 px-3"><a href="https://www.signalauto.net/les-10-meilleurs-sites-dachat-de-moto/">Afficher plus d'auto...</a></div>
                            </div>
                        </div>
                    </main>


                </div>


            </div>


        </div>

        <button id="theme-switch">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                <path d="M480-280q-83 0-141.5-58.5T280-480q0-83 58.5-141.5T480-680q83 0 141.5 58.5T680-480q0 83-58.5 141.5T480-280ZM200-440H40v-80h160v80Zm720 0H760v-80h160v80ZM440-760v-160h80v160h-80Zm0 720v-160h80v160h-80ZM256-650l-101-97 57-59 96 100-52 56Zm492 496-97-101 53-55 101 97-57 59Zm-98-550 97-101 59 57-100 96-56-52ZM154-212l101-97 55 53-97 101-59-57Z" />
            </svg>

            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
                <path d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Z" />
            </svg>
        </button>
        <footer class="m-10 bg-gray-500 pt-8 text-[#4B164C]" id="propos">
            <div>
                <div class="grid md:grid-cols-1 lg:grid-cols-3 mb-5 ">
                    <div class="ml-5 h-50 grid justify-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                            <path d="M798-120q-125 0-247-54.5T329-329Q229-429 174.5-551T120-798q0-18 12-30t30-12h162q14 0 25 9.5t13 22.5l26 140q2 16-1 27t-11 19l-97 98q20 37 47.5 71.5T387-386q31 31 65 57.5t72 48.5l94-94q9-9 23.5-13.5T670-390l138 28q14 4 23 14.5t9 23.5v162q0 18-12 30t-30 12ZM241-600l66-66-17-94h-89q5 41 14 81t26 79Zm358 358q39 17 79.5 27t81.5 13v-88l-94-19-67 67ZM241-600Zm358 358Z" />
                        </svg>(+228)96 62 73 88

                    </div>
                    <div class="ml-5 h-50 grid justify-items-center">

                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                            <path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z" />
                        </svg> olympiolionel0@gmail.com

                    </div>
                    <div class="ml-5 grid justify-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f">
                            <path d="M480-480q33 0 56.5-23.5T560-560q0-33-23.5-56.5T480-640q-33 0-56.5 23.5T400-560q0 33 23.5 56.5T480-480Zm0 294q122-112 181-203.5T720-552q0-109-69.5-178.5T480-800q-101 0-170.5 69.5T240-552q0 71 59 162.5T480-186Zm0 106Q319-217 239.5-334.5T160-552q0-150 96.5-239T480-880q127 0 223.5 89T800-552q0 100-79.5 217.5T480-80Zm0-480Z" />
                        </svg> 203 Fake St.Mountain View, San Francisco, california,USA
                    </div>


                </div>
                <div class="grid sm:grid-cols-1  lg:grid-cols-5 m-10">
                    <div class="grid justify-items-center">
                        <h2 class="text-2xl mb-2">About</h2>
                        <p>Our Story</p>
                        <p>Awards</p>
                        <p>Our team</p>
                        <p>Career</p>
                    </div>
                    <div class="grid justify-items-center">
                        <h2 class="text-2xl mb-2">Company</h2>
                        <p>Our services</p>
                        <p>Clients</p>
                        <p>Contact</p>
                        <p>Press</p>
                    </div>
                    <div class="grid justify-items-center">
                        <h2 class="text-2xl mb-2">Resources</h2>
                        <p>Blog</p>
                        <p>Newletter</p>
                        <p>Privacy Policy</p>
                    </div>
                    <div class="grid justify-items-center col-span-2">
                        <h2 class="text-2xl mb-2">Subcribe</h2>
                        <p>Our Story</p>
                        <p>get digital marketing updates in your mailbox</p>

                    </div>

                </div class="ml-50">
                <div>Copyright &copy;2025 All rights reserved | This template is made with &#9829 by <span class="text-blue-500">Colorlib.com</span></div>

            </div>


        </footer>

        <div class="ml-auto mr-auto text-center m-10 relative w-fit  before:w-0 before:h-[2px] hover:before:w-full  before:bg-blue-500 before:absolute before:bottom-0 before:left-0 before:duration-500"> <a href="#haut">retourner en haut de la page</a></div>
        <div id="ajout">

        </div>



    </section>
    <script>
        const bouton = document.getElementById('ok');
        ok.onclick = function() {}

        function togglePopup(nom, id) {
            let popup = document.querySelector("#popup-overlay");
            popup.classList.toggle("open");
            laisse_com.textContent = "Commenter la " + nom;
            const form = document.querySelector('form');
            const input = document.getElementById('id_final');

            input.value = id;
            form.appendChild(input);
        }

        function afficher_id(localisation, id) {

            document.getElementById(localisation).value = id;

        }

        function changerBg(element) {
            let path = element.querySelector("path");
            let currentColor = path.getAttribute("fill");
            let newcolor = currentColor == "blue" ? "red" : "blue";
            path.setAttribute("fill", newcolor);
        }


        const articles = <?php echo json_encode($motos)  ?>;
        // console.log(articles);
        // const la_moto = document.getElementById('moto');

        const motoItems = document.querySelectorAll('.moto-item');
        // console.log(motoItems);

        articles.forEach((moto, index) => {
            //recuperer les champs adéquats de chaque moto
            const motoItem = motoItems[index];
            const lien = document.getElementById('lien-' + index);
            const image_moto = document.getElementById('image-' + index);
            const nom_moto = document.getElementById('nom-' + index);
            const prix_moto = document.getElementById('prix-' + index);
            const like_moto = document.getElementById('like-' + index);
            const commentaire_moto = document.getElementById('commentaire-' + index);
            const laisse_com = document.getElementById('laisse_com');
            const popup = document.getElementById('popup-' + index);
            document.getElementById('id_final').value = moto.id_moto;
            const like_cache = document.getElementById("like_cache-" + index);




            afficher_id("like_cache-" + index, moto.id_moto);


            document.addEventListener("DOMContentLoaded", function() {
                let button = document.getElementById("like_boutton-" + index);
                let savedColor = localStorage.getItem("bgColor" + index);

                if (savedColor) {
                    document.button.style.background = savedColor;
                }
                document.getElementById("like_boutton-" + index).addEventListener("click", function(event) {
                    event.preventDefault();
                    let button = document.getElementById("like_boutton-" + index);

                    let currentColor = window.getComputedStyle(button).backgroundColor;
                    let newcolor = currentColor == "white" ? "green" : "white";
                    button.style.background = newcolor;
                    localStorage.setItem("bgColor" + index, newcolor);
                })
            })


            popup.onclick = () => togglePopup(moto.nom_moto, moto.id_moto);


            image_moto.src = moto.image_moto;
            lien.href = "page_moto.php?id_moto=" + moto.id_moto;
            nom_moto.innerHTML = moto.nom_moto;
            prix_moto.innerHTML = moto.prix_moto + " £";

            laisse_com.innerHTML = "commenter la " + moto.nom_moto;

            //gerer le nombre de like et de commentaire
            if (moto.nb_like_moto == 0) {
                like_moto.innerHTML = "Pas de like";
            } else if (moto.nb_like_moto == 1) {
                like_moto.innerHTML = moto.nb_like_moto + " like";
            } else {
                like_moto.innerHTML = moto.nb_like_moto + " likes";
            }

            if (moto.nb_comment_moto == 0) {
                commentaire_moto.innerHTML = "Pas de commentaire";
            } else if (moto.nb_comment_moto == 1) {
                commentaire_moto.innerHTML = moto.nb_comment_moto + " commentaire";
            } else {
                commentaire_moto.innerHTML = moto.nb_comment_moto + " commentaires";
            }
        });
    </script>
</body>

</html>