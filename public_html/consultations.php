<?php
session_start();
require 'php/config.php';
$thisPage = "consultations";

// Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
if(empty($_SESSION['signedin'])) {
	header("Location: index.php");
}
// Déconnexion de l'utilisateur
if(isset($_GET["disconnect"])) {
	session_destroy();
	header("Location: index.php");
}
if(empty($_GET['week'])) {
	$week = intval(date("W", time()));
} else {
	$week = $_GET['week'];
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
	<link rel="stylesheet" type="text/css" href="css/consultations.css">
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link rel="icon" href="images/logo.png" />
	<title>Projet Gestion médicale</title>
</head>

<body>
	<?php
		include "php/header.php";
	?>
	<h1>Consultations</h1>
	<p>En développement ! :)</p>
	<div class="ajouterHorsCalendrier">
		ajouter consultation hors calendrier
	</div>
	<div class="semaines">
		<button class="semainrePrec" onclick="location.href='consultations.php?week=<?php echo $week - 1; ?>'" type="button">⇦ Semaine <?php echo $week - 1; ?></button>
		<div id="centreSemaines">
			<p id="dispSemaine">Semaine <?php echo $week; ?></p>
			<?php if(!empty($_GET['week'])) {
				if($_GET['week'] !==  intval(date("W", time()))) {
			?> <button class="retourSemaineActuelle" onclick="location.href='consultations.php'" type="button">Retour semaine <?php echo intval(date("W", time())); ?></button> <?php
				}
			} ?>
		</div>
		<button class="semaineSuiv" onclick="location.href='consultations.php?week=<?php echo $week + 1; ?>'" type="button">Semaine <?php echo $week + 1; ?> ⇨</button>
	</div>
	<div class="consultations">
		<div class="jour">
			<p class="nomJour">Lundi</p>

		</div>
		<div class="jour">
			<p class="nomJour">Mardi</p>

		</div>
		<div class="jour">
			<p class="nomJour">Mercredi</p>

		</div>
		<div class="jour">
			<p class="nomJour">Jeudi</p>

		</div>
		<div class="jour">
			<p class="nomJour">Vendredi</p>

		</div>
		<div class="jour">
			<p class="nomJour">Samedi</p>

		</div>
	</div>
	<table>
	<?php
		include "php/footer.php";
	?>
</body>
</html>