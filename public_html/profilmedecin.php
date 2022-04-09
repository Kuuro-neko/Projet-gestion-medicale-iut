<?php
session_start();
require 'php/config.php';
$thisPage = "profilmedecin";

// Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
if(empty($_SESSION['signedin'])) {
	header("Location: index.php");
}
// Déconnexion de l'utilisateur
if(isset($_GET["disconnect"])) {
	session_destroy();
	header("Location: index.php");
}
if(empty($_GET['id_medecin'])) {
	header("Location: medecins.php");
}

// Récupérer les variables pour préremplir le formulaire
require 'php/connexiondb.php';
$req = $linkpdo->prepare("SELECT civilite, nom, prenom, id_medecin FROM medecin WHERE id_medecin = :id_medecin");
$req->execute(array('id_medecin'=>$_GET['id_medecin']));
$data = $req->fetch();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<meta name="description" content="Projet Gestion médicale">
	<meta name="keywords" content="HTML, CSS, Gestion médicale, IUT Toulouse">
	<meta name="author" content="Gonzalez Oropeza Gilles">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<link rel="stylesheet" type="text/css" href="css/profilpatient.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="icon" href="images/logo.png" />
	<title>Projet Gestion médicale</title>
</head>

<body>
	<?php
		include "php/header.php";
	?>
	<h1>Profil de Médecin</h1>

	<fieldset>
		<legend>
			Modifier le médecin
		</legend>
		<form method="post" action="php/modificationMedecin.php">
			<div class="textinputs">
				Civilité
				<select name="civilite" required>
					<?php
						if($data['civilite'] === "Monsieur") {
							?>
					<option value="Monsieur">Monsieur</option>
					<option value="Madame">Madame</option>
							<?php
						} else {
							?>
					<option value="Madame">Madame</option>
					<option value="Monsieur">Monsieur</option>
							<?php
						} ?>
				</select>

				Nom
				<input type="text" name="nom" value="<?php echo $data['nom']; ?>" required></input>

				Prénom
				<input type="text" name="prenom" value="<?php echo $data['prenom']; ?>" required></input>
			</div>
			<div class="submitinputs">
				<input class="edit" type="submit" name="modifier" value="Modifier"></input> 
				<button class="cancel" onclick="location.href='medecins.php'" type="button">Annuler</button>
			</div>
			<input type="hidden" value="<?php echo $data['id_medecin']; ?>" name="id_medecin"></input>
		</form>
	</fieldset>
	<?php
		include "php/footer.php";
	?>
</body>
</html>