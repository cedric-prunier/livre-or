<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["connected"]) || $_SESSION["connected"] !== true) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: connexion.php");
    exit();
}

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

// Récupération des informations de l'utilisateur depuis la base de données
$login = $_SESSION["login"];
$sql = "SELECT * FROM utilisateurs WHERE login = '$login'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $login = $row["login"];
    $password = $row["password"];
} else {
    echo "Erreur : impossible de récupérer les informations de l'utilisateur.";
    exit();
}

// Traitement du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des nouvelles valeurs du formulaire
    $nouveaulogin = $_POST["login"];
    $nouveaupassword = $_POST["password"];

    // Mise à jour des informations dans la base de données
    $sql = "UPDATE utilisateurs SET login = '$nouveaulogin', password = '$nouveaupassword' WHERE login = '$login'";

    if ($conn->query($sql) === TRUE) {
        echo "Informations mises à jour avec succès.";
        // Mettre à jour les valeurs dans la session
        $_SESSION["login"] = $nouveaulogin;
        $_SESSION["password"] = $nouveaupassword;


    } else {
        echo "Erreur lors de la mise à jour des informations : " . $conn->error;
    }

}

// Fermeture de la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Modifier le profil</title>
    <link rel="stylesheet" href="profil.css">
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
                echo '<li class="projet"><a href="inscription.php">Inscription</a></li>';
                echo '<li class="projet"><a href="connexion.php">Connexion</a></li>';
            }
            ?>
        </ul>
        <div class="burger">
            <span></span>
        </div>
    </nav>
    <section class="section">
        <form class="formulaire" action="profil.php" method="post">

            <h1>Modifier votre profil</h1>
            <br />
            <label for="login">Login</label>
            <br>
            <input type="text" id="login" name="login" value="<?php echo $login; ?>" required>
            <br />
            <label for="password">Mot de passe</label>
            <br>
            <input type="password" id="password" name="password" value="<?php echo $password; ?>" required>
            <button class="eye" type="button" onclick="togglePassword()" id="toggle-password"><img
                    src="./images/eye-open.svg" alt="" /></button>
            <br />
            <li class="options">
                <input type="submit" name="valider" value="Valider &#10004;" />
                <br />
            </li>

        </form>
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
<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const togglePasswordButton = document.getElementById("toggle-password");
        const img = togglePasswordButton.querySelector("img");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            img.src = "./images/eye-closed.svg";
        } else {
            passwordInput.type = "password";
            img.src = "./images/eye-open.svg";
        }
    }
</script>

</html>