<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" href="new_mdp.css">
</head>

<body>
    <section>
        <form class="formulaire" action="" method="post">
            <h1>Récupérer votre mot de passe</h1>
            <br>
            <h2>Identifiant</h2>
            <br>
            <input type="text" name="login" placeholder="Entrer votre login">
            <br>
            <input class="options" type="submit" name="submit_request" value="Vérifier profil utilisateur">


            <?php

            // Effectuer une connexion à la base de données (à adapter selon votre configuration)
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $dbname = "livreor";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Vérifier la connexion à la base de données
            if ($conn->connect_error) {
                die("Échec de la connexion à la base de données : " . $conn->connect_error);
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['submit_request'])) {
                    // Récupérer les données du formulaire
            
                    $login = $_POST['login'] ?? '';

                    // Exécuter la requête pour vérifier si l'utilisateur existe
                    $sql = "SELECT * FROM utilisateurs WHERE login='$login'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // L'utilisateur existe dans la base de données
                        echo '<br>';
                        echo "<h2>Nouveau mot de passe</h2>";
                        echo '<br>';
                        // Afficher les champs pour le nouveau mot de passe
                        echo '<form class="formulaire" action="" method="post">';
                        echo '<input type="hidden" name="login" value="' . $login . '">';
                        echo '<input type="password" name="new_password" id="new_password" placeholder="Nouveau mot de passe" required>';
                        echo '<br>';
                        echo '<input type="password" name="confirm_password" id="confirm_password" placeholder="Confirmer le nouveau mot de passe" required>';
                        echo '<br>';
                        echo '<button class="eye" type="button" onclick="togglePassword()" id="toggle-password"><img
                        src="./images/eye-open.svg" alt="eye" height="30" /></button>';
                        echo '<br>';
                        echo '<input class="options" type="submit" name="submit_reset" value="Réinitialiser le mot de passe">';
                        echo '</form>';
                    } else {
                        // L'utilisateur n'existe pas dans la base de données
                        echo "Utilisateur non trouvé dans la base de données";
                    }
                } elseif (isset($_POST['submit_reset'])) {
                    // Récupérer les données du formulaire de saisie du nouveau mot de passe
            
                    $login = $_POST['login'] ?? '';
                    $newPassword = $_POST['new_password'];
                    $confirmPassword = $_POST['confirm_password'];

                    // Vérifier que les mots de passe correspondent
                    if ($newPassword === $confirmPassword) {
                        // Exécuter la requête pour mettre à jour le mot de passe
                        $sql = "UPDATE utilisateurs SET password='$newPassword' WHERE login='$login'";
                        if ($conn->query($sql) === TRUE) {
                            echo "Le mot de passe a été mis à jour avec succès.";
                            header('Location: index.php');
                            exit();
                        } else {
                            echo "Erreur lors de la mise à jour du mot de passe : " . $conn->error;
                        }
                    } else {
                        echo "Les mots de passe ne correspondent pas. Veuillez réessayer.";
                    }
                }
            }

            // Fermer la connexion à la base de données
            $conn->close();
            ?>

        </form>
    </section>
</body>
<script>
    function togglePassword() {
        const newPasswordInput = document.getElementById("new_password");
        const confirmPasswordInput = document.getElementById("confirm_password");
        const togglePasswordButton = document.getElementById("toggle-password");
        const img = togglePasswordButton.querySelector("img");

        if (newPasswordInput.type === "password" && confirmPasswordInput.type === "password") {
            newPasswordInput.type = "text";
            confirmPasswordInput.type = "text";
            img.src = "./images/eye-closed.svg";
        } else {
            newPasswordInput.type = "password";
            confirmPasswordInput.type = "password";
            img.src = "./images/eye-open.svg";
        }
    }
</script>


</html>