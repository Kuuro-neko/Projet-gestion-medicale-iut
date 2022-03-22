<?php
session_start();
require '../php/config.php';
include '../php/fonctions.php';
$thisPage = "patients";

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
	<link rel="stylesheet" type="text/css" href="../css/patients.css">
	<link rel="stylesheet" type="text/css" href="../css/footer.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">

	<link rel="icon" href="../images/logo.png" />
	<title>Projet Gestion médicale</title>
</head>

<body>
	<?php
		include "../php/header.php";
	?>
	<h1>Gestion des patients</h1>

	<?php	
	// Si patient supprimé
	if(!empty($_GET['id_patient'])) {
		require '../php/connexiondb.php';

		$req = $linkpdo->prepare("DELETE from patient WHERE id_patient = :id_suppr");

		if($req->execute(array('id_suppr'=>$_GET['id_patient']))) {
			echo "<p class=\"success\">Patient supprimé avec succès !</p>";
		} else {
			echo "<p class=\"error\">Erreur lors de la suppression</p>";
		}
	}
	?>


	<div class="formContainer">
		<fieldset id="rechercher">
			<legend>Rechercher un patient</legend>
		<!-- Formulaire de recherche -->
			<form class="forms" method="post">
				<input type="text" name="searchField">
				<?php
					if(isset($_POST['search']) && empty($_POST['searchField'])) {
						echo "<p class=\"error\">Veuillez saisir au moins un mot-clé</p>";
					}
				?>
				<input type="submit" name="search" value="Rechercher">
			</form>
		</fieldset>
		<!-- Lien vers le formulaire d'ajout -->
		<fieldset id="ajouter" tabindex="0">
		<legend>Ajouter un patient</legend>
			<p id="invite">Cliquez pour ouvrir le formulaire d'ajout</p>
   		 	<form id="formAjouter">
				<div class="textinputs">
					<select type="text" name="">
						<option value="default">Civilité</option>
						<option value="Monsieur">Monsieur</option>
						<option value="Madame">Madame</option>
					</select>
					Nom <input type="text" name=""></input>
					Prénom <input type="text" name=""></input>
					Date de naissance <input type="text" name=""></input>
					Lieu de naissance <input type="text" name=""></input>
					<select type="text" name="">
							<option value="default">Médecin traitant</option>
							<option value="default">Aucun médecin traitant</option>
							<option value="aaa">Med 1</option>
							<option value="bbb">Med 2</option>
					</select>
					N° de sécurité sociale <input type="text" name=""></input>
					Adresse <input type="text" name=""></input>
					Code postal <input type="text" name=""></input>
					Ville <input type="text" name=""></input>
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
			include '../php/recherchePatient.php';
			echo "</div>";
		}
		include "../php/footer.php";
	?>
</body>
</html>