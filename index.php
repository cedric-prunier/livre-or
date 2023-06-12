<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Accueil</title>
        <link rel="stylesheet" href="./index.css" />
        <link rel="shortcut icon" href="./images/shortcut_icon.png" />
</head>

<body>
        <nav class="navbar">

                <ul class="navlinks">
                        <?php
                        session_start();

                        if (isset($_SESSION['login'])) {
                                // Utilisateur connecté
                                echo 'Bonjour, ' . $_SESSION['login'];
                                echo '<li class="projet"><a href="index.php">Accueil</a></li>';
                                echo '<li class="projet"><a href="livre-or.php">livre Or </a></li>';
                                echo '<li class="projet"><a href="commentaire.php">Commentaire</a></li>';
                                echo '<li class="projet"><a href="profil.php">Profil</a></li>';
                                echo '<li><a href="logout.php">Déconnexion</a></li>';

                        } else {
                                // Aucun utilisateur connecté
                                echo '<li class="projet"><a href="livre-or.php">Livre d\'Or</a></li>';
                                echo '<li class="projet"><a href="inscription.php">Inscription</a></li>';
                                echo '<li class="projet"><a href="connexion.php">Connexion</a></li>';
                        }
                        ?>
                </ul>
                <div class="burger">
                        <span></span>
                </div>
        </nav>



        <header></header>

</body>

<script>
        const burger = document.querySelector(".burger");
        const navlinks = document.querySelector(".navlinks");
        burger.addEventListener("click", () => {
                navlinks.classList.toggle("mobile-menu");
        });
</script>
<script>
        const menuburger = document.querySelector(".burger");

        menuburger.addEventListener("click", () => {
                menuburger.classList.toggle("cross");
        });
</script>
<script>
        const body = document.querySelector("body");

        body.addEventListener("click", (e) => {
                if (e.target !== user && e.target !== login && !login.contains(e.target)) {
                        if (login.classList.contains("loginok")) {
                                login.classList.remove("loginok");
                        }
                }
        });
</script>


</html>