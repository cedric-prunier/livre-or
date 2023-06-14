<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["connected"]) || $_SESSION["connected"] !== true) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion.php");
    exit();
}

// Traitement du formulaire d'ajout de commentaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération du commentaire depuis le formulaire
    $commentaire = $_POST["commentaire"];

    // Vérifier si l'ID de l'utilisateur est défini dans la session
    if (isset($_SESSION["id_utilisateur"])) {
        $id_utilisateur = $_SESSION["id_utilisateur"];

        // Connexion à la base de données (à adapter avec vos propres informations)
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "livreor";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérification de la connexion
        if ($conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $conn->connect_error);
        }

        // Préparation de la requête d'insertion du commentaire dans la table "commentaires"
        $sql = "INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $commentaire, $id_utilisateur);

        if ($stmt->execute()) {
            $message = "Commentaire ajouté avec succès.";
        } else {
            $message = "Erreur lors de l'ajout du commentaire : " . $stmt->error;
        }

        // Fermeture de la connexion à la base de données
        $stmt->close();
        $conn->close();
    } else {
        echo "Erreur : ID de l'utilisateur non défini.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Commentaire</title>
    <link rel="stylesheet" href="commentaire.css" />
    <link rel="shortcut icon" href="./images/shortcut_icon.png" />
</head>

<body>
    <nav class="navbar">

        <ul class="navlinks">
            <?php


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
    <form class="formulaire" action="commentaire.php" method="post">
        <h1>Ajouter un commentaire</h1>
        <h2>Laisser l'empreinte de votre amour</h2>
        <?php if (isset($message)) { ?>
            <p>
                <?php echo $message; ?>
            </p>
        <?php } ?>
        <br>
        <textarea name="commentaire" id="commentaire" cols="30" rows="10"
            placeholder="Saisir votre commentaire"></textarea>
        <input type="submit" name="valider" id="valider">
    </form>


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