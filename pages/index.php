<?php
session_start();
require '../php/config.php';
$msgErreur = "";
// Rediriger vers l'accueil authentifié si l'utilisateur est déjà connecté
if(!empty($_SESSION['signedin'])) {
	header("Location: accueil.php");
}
// Si formulaire de connection rempli
if(!empty($_POST['login']) && !empty($_POST['mdp']) && empty($_SESSION['signedin'])) {
    //Essayer de se connecter avec les valeurs
   if($_POST['login'] === $loginSite && $_POST['mdp'] === $mdpSite) {
	   $_SESSION['signedin'] = true;
	   header("Location: accueil.php");
   } else {
	   $msgErreur = "Login ou mdp erroné";
   }
} elseif (isset($_POST['signin'])) {
	$msgErreur = "Veuillez renseigner les 2 champs";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<meta name="description" content="Projet Gestion médicale">
	<meta name="keywords" content="HTML, CSS, Gestion médicale, IUT Toulouse">
	<meta name="author" content="Gonzalez Oropeza Gilles">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../images/logo.png" />
	<link rel="stylesheet" type="text/css" href="../css/common.css">
	<link rel="stylesheet" type="text/css" href="../css/index.css">
	<link rel="stylesheet" type="text/css" href="../css/footer.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<title>Projet Gestion médicale</title>
</head>

<body>
	<form action="index.php" class="connexion" method="post">
   		<fieldset>
			<legend class="title">Connexion</legend>
			<input type="text" name="login" placeholder="Nom d'utilisateur"></input>
			<input type="password" name ="mdp" placeholder="Mot de passe"></input>
			<?php
			if ($msgErreur != "") {
				echo "<p class=\"error\">".$msgErreur."</p>";
			}
			?>
			<input type="submit" name="signin" value="Se connecter"></input>
		</fieldset>
	</form>
	<?php
		include "../php/footer.php";
	?>
</body>
</html>