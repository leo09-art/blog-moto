<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../style.js"></script>
</head>

<body>
<div class="flex justify-between sticky top-0 bg-rose-700 h-[100px] w-[98vw] rounded-xl z-10">
        <div>
            <div class="text-center flex gap-5">
                <!-- <h1 class="gradient-text">Texte arc-en-ciel</h1> -->

                <p class="text-2xl ml-5">Bienvenue</p>
                <p>
                <h1 class="text-3xl bg-gradient-to-r from-pink-500 via-purple-500 to-blue-500 bg-clip-text text-transparent"><?php echo $_COOKIE['nom']; ?></h1>
                </p>
            </div>
        </div>
        <div class=" flex justify-center justify-items-center ">
            <ul class="flex justify-center">
                <li><a href="index.php" class="p-3 m-6 ">
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
            <button name="fermer" class="rounded-full px-2 py-3 cursor-pointer border border-blue-500 hover:bg-blue-800 hover:text-white ">DECONNEXION</button>

        </div>
    </div>
    <p class="p-10 flex justify-end">La Passion des Deux Roues : Explorer le Monde à Moto

        Bienvenue sur SMC ADA, l'espace dédié à tous les amoureux de la moto, débutants ou experts ! Ici, nous partageons notre passion pour la liberté offerte par les deux roues, les dernières tendances en matière de motos et les récits palpitants des routes parcourues.

        À la Une cette Semaine Découvrez le charme intemporel des motos classiques ou explorez les avancées technologiques des dernières superbikes ! Plongez dans des comparatifs détaillés, des conseils mécaniques et des idées de balades pour réveiller l'aventurier en vous.

        Nos Catégories Populaires

        Essais & Comparatifs : Les meilleures motos pour chaque style de conduite.

        Maintenance : Trucs et astuces pour garder votre moto en parfait état.

        Aventures & Histoires : Partagez vos anecdotes de voyage à travers le monde.

        Les Dernières Tendances Moto Chaque année, de nouveaux modèles repensent notre manière de rouler. Les motos électriques gagnent du terrain avec des performances de plus en plus impressionnantes, tandis que les motos vintage retrouvent leur gloire d'antan. Nous explorons ces tendances et plus encore.

        Histoires de Motards à Travers le Monde Nos lecteurs partagent leurs récits mémorables de voyage à moto : les routes sinueuses des montagnes, les vastes plaines désertiques, ou encore les aventures urbaines. Ces histoires inspirantes célèbrent l'esprit de communauté qui unit tous les motards.

        Événements et Rencontres Restez informé des rassemblements de motards, des salons de la moto et des courses incontournables. Rejoignez-nous pour célébrer cette passion commune lors d'événements locaux et internationaux.</p>

</body>

</html>