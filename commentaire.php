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
            echo "Commentaire ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout du commentaire : " . $stmt->error;
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
<html>

<head>
    <title>Ajouter un commentaire</title>
    <link rel="stylesheet" href="commentaire.css">
</head>

<body>
    <nav class="navbar">

        <ul class="navlinks">
            <?php

            if (isset($_SESSION['login'])) {
                // Utilisateur connecté
                echo 'Bonjour, ' . $_SESSION['login'];
                echo '<li class="projet"><a href="index.php">Accueil</a></li>';
                echo '<li class="projet"><a href="livre-or.php">Livre Or </a></li>';
                echo '<li class="projet"><a href="commentaire.php">Commentaire</a></li>';
                echo '<li class="projet"><a href="profil.php">Profil</a></li>';
                echo '<li><a href="logout.php">Déconnexion</a></li>';

            } else {
                // Aucun utilisateur connecté
                echo '<li class="projet"><a href="livre-or.php">livre Or </a></li>';
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
        <form class="formulaire" action="commentaire.php" method="post">
            <h1>Ajouter un commentaire</h1>

            <label for="commentaire">Laissez l'empreinte de votre amour</label>
            <br>
            <textarea name="commentaire" id="commentaire" cols="30" rows="10" placeholder="Entrez votre commentaire"
                required></textarea>
            <br>
            <input type="submit" name="valider" value="Valider">
        </form>
    </section>
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