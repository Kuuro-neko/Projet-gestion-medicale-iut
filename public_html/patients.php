<?php
session_start();
require 'php/config.php';
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
	<link rel="stylesheet" type="text/css" href="css/common.css">
	<link rel="stylesheet" type="text/css" href="css/patients.css">
	<link rel="stylesheet" type="text/css" href="css/footer.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">

	<link rel="icon" href="images/logo.png" />
	<title>Projet Gestion médicale</title>
</head>

<body>
	<?php
		include "php/header.php";
	?>
	<h1>Gestion des patients</h1>
	<?php
	// S'il y a un patient à ajouter
	if(isset($_POST['ajouter'])) {
	require 'php/connexiondb.php';

	 // Préparation de la requête
	 $req = $linkpdo->prepare("INSERT INTO patient(civilite, nom, prenom, adresse, code_postal, ville, date_naissance, lieu_naissance, num_ss, id_medecin)
	 VALUES(:vcivilite, :vnom, :vprenom, :vadresse, :vcode_postal, :vville, :vdate_naissance, :vlieu_naissance, :vnum_ss, :vid_medecin)");
	
	if($_POST['medecin'] === "NULL") {
		$med = null;
	} else {
		$med = $_POST['medecin'];
	}
	 // Exécution de la requête
	 if($req->execute(array('vcivilite' => $_POST["civilite"], 'vnom' => $_POST['nom'], 'vprenom' => $_POST['prenom'], 'vadresse' => $_POST['adresse'], 'vcode_postal' => $_POST['code_postal'],
	  'vville' => $_POST['ville'], 'vdate_naissance' => strtotime($_POST['date_naissance']), 'vlieu_naissance' => $_POST['lieu_naissance'], 'vnum_ss' => $_POST['num_ss'], 'vid_medecin' => $med ))){
							 echo "<p class=\"success\">Patient ajouté avec succès !</p>";
						 } else {
							 echo "<p class=\"error\">Erreur, données saisies non valides</p>";
						 }

	}
	?>

	<?php	
	// Si patient supprimé
	if(!empty($_GET['id_patient'])) {
		require 'php/connexiondb.php';

		$req = $linkpdo->prepare("DELETE from patient WHERE id_patient = :id_suppr");

		if($req->execute(array('id_suppr'=>$_GET['id_patient']))) {
			echo "<p class=\"success\">Patient supprimé avec succès !</p>";
		} else {
			echo "<p class=\"error\">Erreur lors de la suppression</p>";
		}
	}
	?>
	<?php	
		// Si patient modifié
		if(!empty($_GET['edit'])) {
			if($_GET['edit'] === "success") {
				echo "<p class=\"success\">Patient modifié avec succès !</p>";
			} else {
				echo "<p class=\"error\">Erreur lors de la modification</p>";
			}
		}
	?>


	<div class="formContainer">
		<fieldset id="rechercher">
			<legend>Rechercher un patient</legend>
		<!-- Formulaire de recherche -->
			<form class="forms" method="post">
				<input type="text" name="searchField" required>
				<input type="submit" name="search" value="Rechercher">
			</form>
		</fieldset>

		<!-- Formulaire d'ajout -->
		<fieldset id="ajouter" tabindex="0">
		<legend>Ajouter un patient</legend>
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
					Date de naissance <input type="date" name="date_naissance" required pattern="\d{4}-\d{2}-\d{2}"></input>
					Lieu de naissance <input type="text" name="lieu_naissance" required></input>
					Médecin traitant<select name="medecin" required>
						<option value="">Médecin traitant</option>
						<option value="NULL">Aucun médecin traitant</option>
						<?php
						// Génération des options
							// Connexion à la BD
							require 'php/connexiondb.php';
							//Préparation de la requête
							$requ = $linkpdo->prepare("SELECT nom, prenom, id_medecin FROM medecin");
							// Execution de la requête
							$requ->execute();
							while($data2 = $requ->fetch()) {
								echo "<option value=\"".$data2['id_medecin']."\">".$data2['nom']." ".$data2['prenom']."</option>";
							}
						?>
					</select>
					N° de sécurité sociale <input type="text" name="num_ss" required minlength="15" maxlength="15"></input>
					Adresse <input type="text" name="adresse" required></input>
					Code postal <input type="text" name="code_postal" required></input>
					Ville <input type="text" name="ville" required></input>
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
			include 'php/recherchePatient.php';
			echo "</div>";
		}
		include "php/footer.php";
	?>
</body>
</html>