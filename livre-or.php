<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre-or</title>
    <link rel="stylesheet" href="livre-or.css">
</head>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or</title>
    <link rel="stylesheet" href="livre-or.css">
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
                echo '<li class="projet"><a href="livre-or.php">Livre d\'Or </a></li>';
                echo '<li class="projet"><a href="commentaire.php">Commentaire</a></li>';
                echo '<li class="projet"><a href="profil.php">Profil</a></li>';
                echo '<li><a href="logout.php">Déconnexion</a></li>';

            } else {
                // Aucun utilisateur connecté
                echo '<li class="projet"><a href="index.php">Accueil</a></li>';
                echo '<li class="projet"><a href="inscription.php">Inscription</a></li>';
                echo '<li class="projet"><a href="connexion.php">Connexion</a></li>';
            }
            ?>
        </ul>
        <div class="burger">
            <span></span>
        </div>
    </nav>
    <section>
        <article>
            <h1>Contenu du Livre d'Or</h1>
            <br>
            <?php


            // Connexion à la base de données (à adapter avec vos propres informations)
            $servername = "localhost";
            $username = "root";
            $dbpassword = "root";
            $dbname = "livreor";

            $conn = new mysqli($servername, $username, $dbpassword, $dbname);

            // Vérification de la connexion
            if ($conn->connect_error) {
                die("Erreur de connexion à la base de données : " . $conn->connect_error);
            }

            // Récupération des commentaires depuis la table "commentaires"
            $sql_commentaires = "SELECT c.commentaire, c.date, u.login 
                         FROM commentaires c 
                         INNER JOIN utilisateurs u ON c.id_utilisateur = u.id 
                         ORDER BY c.date DESC";
            $result_commentaires = $conn->query($sql_commentaires);

            // Vérification des commentaires
            if ($result_commentaires->num_rows > 0) {
                // Affichage des commentaires
                while ($row_commentaire = $result_commentaires->fetch_assoc()) {
                    $commentaire = $row_commentaire["commentaire"];
                    $date_poste = $row_commentaire["date"];
                    $utilisateur = $row_commentaire["login"];

                    echo "<div class='commentaire'>";
                    echo "<p>Posté le $date_poste par $utilisateur : </p>";
                    echo "<p> ' $commentaire '</p>";
                    echo "</div>";
                    echo "<br>";
                }
            } else {
                echo "Aucun commentaire trouvé.";
            }

            // Fermeture de la connexion à la base de données
            $conn->close();
            ?>
            <?php
            echo '<br>';
            if (isset($_SESSION["connected"]) && $_SESSION["connected"] === true): ?>
                <a id="lien" href="commentaire.php">Ajouter un commentaire</a>
            <?php endif; ?>
        </article>
    </section>
</body>
<script>
    const burger = document.querySelector(".burger");
    const navlinks = document.querySelector(".navlinks");
    const body = document.querySelector("body");

    burger.addEventListener("click", () => {
        navlinks.classList.toggle("mobile-menu");
        burger.classList.toggle("cross");
    });

    body.addEventListener("click", (event) => {
        if (!burger.contains(event.target) && !navlinks.contains(event.target)) {
            navlinks.classList.remove("mobile-menu");
            burger.classList.remove("cross");
        }
    });
</script>

</html>


</html>