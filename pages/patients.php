<?php
session_start();
include '../php/config.php';
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
	<meta charset="UTF-8">
	<meta name="description" content="Projet Gestion médicale">
	<meta name="keywords" content="HTML, CSS, Gestion médicale, IUT Toulouse">
	<meta name="author" content="Gonzalez Oropeza Gilles">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/common.css">
	<link rel="stylesheet" type="text/css" href="../css/patients.css">
	<link rel="stylesheet" type="text/css" href="../css/footer.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/index.css">
	<link rel="icon" href="../images/logo.png" />
	<title>Projet Gestion médicale</title>
</head>

<body>
	<?php
		include "../php/header.php";
	?>
	<h1>Gestion des patients</h1>
	<div class="formContainer">
		<fieldset>
		<!-- Formulaire de recherche -->
			<form class="forms" method="post">
				<input type="text" name="searchField">
				<input type="submit" name="search" value="Rechercher">
			</form>
		</fieldset>
		<!-- Lien vers le formulaire d'ajout -->
		<fieldset>
			<a class="forms">Ajouter patient</a>
		</fieldset>
	</div>
	<div class="searchResults">
		<div class="patient">
			<div class="infos">
				<div class="nom">

				</div>
				<div class="prenom">

				</div>
				<div class="civilite">

				</div>
				<div class="numss">

				</div>
				<div class="medtraitant">

				</div>
				<div class="daten">

				</div>
			</div>
			<div class="adresse">
				<div class="rue">

				</div>
				<div class="codepostal">

				</div>
				<div class="ville">
					
				</div>
			</div>
		</div>
	</div>
	<?php
		include "../php/footer.php";
	?>
</body>