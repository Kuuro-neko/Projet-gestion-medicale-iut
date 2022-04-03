<?php
session_start();
require '../php/config.php';
include '../php/fonctions.php';
$thisPage = "medecins";

// Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
if(empty($_SESSION['signedin'])) {
	header("Location: index.php");
}
// Déconnexion de l'utilisateur
if(isset($_GET["disconnect"])) {
	session_destroy();
	header("Location: index.php");
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
	<link rel="stylesheet" type="text/css" href="../css/common.css">
	<link rel="stylesheet" type="text/css" href="../css/medecins.css">
	<link rel="stylesheet" type="text/css" href="../css/footer.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">

	<link rel="icon" href="../images/logo.png" />
	<title>Projet Gestion médicale</title>
</head>

<body>
	<?php
		include "../php/header.php";
	?>
	<h1>Gestion des medecins</h1>
	<?php
	// S'il y a un medecin à ajouter
	if(isset($_POST['ajouter'])) {
		require '../php/connexiondb.php';

		// Préparation de la requête
		$req = $linkpdo->prepare("INSERT INTO medecin(civilite, nom, prenom)
		VALUES(:vcivilite, :vnom, :vprenom)");

		// Exécution de la requête
		if($req->execute(array('vcivilite' => $_POST["civilite"], 'vnom' => $_POST['nom'], 'vprenom' => $_POST['prenom']))){
			echo "<p class=\"success\">Médecin ajouté avec succès !</p>";
		} else {
			echo "<p class=\"error\">Erreur, données saisies non valides</p>";
		}
	}
	?>

	<?php	
	// Si medecin supprimé
	if(!empty($_GET['id_medecin'])) {
		require '../php/connexiondb.php';

		$req = $linkpdo->prepare("DELETE from medecin WHERE id_medecin = :id_suppr");

		if($req->execute(array('id_suppr'=>$_GET['id_medecin']))) {
			echo "<p class=\"success\">Médecin supprimé avec succès !</p>";
		} else {
			echo "<p class=\"error\">Erreur lors de la suppression</p>";
		}
	}
	?>
	<?php	
		// Si médecin modifié
		if(!empty($_GET['edit'])) {
			if($_GET['edit'] === "success") {
				echo "<p class=\"success\">Médecin modifié avec succès !</p>";
			} else {
				echo "<p class=\"error\">Erreur lors de la modification</p>";
			}
		}
	?>


	<div class="formContainer">
		<fieldset id="rechercher">
			<legend>Rechercher un médecin</legend>
		<!-- Formulaire de recherche -->
			<form class="forms" method="post">
				<input type="text" name="searchField" required>
				<input type="submit" name="search" value="Rechercher">
			</form>
		</fieldset>

		<!-- Formulaire d'ajout -->
		<fieldset id="ajouter" tabindex="0">
		<legend>Ajouter un médecin</legend>
			<p id="invite">Cliquez pour ouvrir le formulaire d'ajout</p>
   		 	<form id="formAjouter" method="post">
				<div class="textinputs">
					Civilité<select name="civilite" required>
						<option value="">Civilité</option>
						<option value="Monsieur">Monsieur</option>
						<option value="Madame">Madame</option>
					</select>
					Nom <input type="text" name="nom" required></input>
					Prénom <input type="text" name="prenom" required></input>
				</div>
				<div class="addbutton">
					<input type="submit" name="ajouter" value="Ajouter"></input>
				</div>
			</form>
		</fieldset>
	</div>
	<?php
		if((isset($_POST['search']) && !empty($_POST['searchField'])) || !empty($_GET['save_search'])) {
			echo "<div id=\"resultatsContainer\">";
			include '../php/rechercheMedecin.php';
			echo "</div>";
		}
		include "../php/footer.php";
	?>
</body>
</html>