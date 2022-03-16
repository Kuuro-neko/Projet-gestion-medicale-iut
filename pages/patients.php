<?php
session_start();
include '../php/config.php';
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
				<?php
					if(isset($_POST['search']) && empty($_POST['searchField'])) {
						echo "<p class=\"error\">Veuillez saisir au moins un mot-clé</p>";
					}
				?>
				<input type="submit" name="search" value="Rechercher">
			</form>
		</fieldset>
		<!-- Lien vers le formulaire d'ajout -->
		<fieldset>
			<a class="forms">Ajouter patient</a>
		</fieldset>
	</div>

	<?php
		if(isset($_POST['search']) && !empty($_POST['searchField'])) {
			// Connexion au serveur MySQL
            try {
                $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
            }
            catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }

			$motsRecherche = explode(" ", $_POST["searchField"]);

			$req = $linkpdo->prepare("SELECT patient.nom pnom, patient.prenom pprenom, patient.civilite pcivilite, date_naissance,
			lieu_naissance, num_ss, adresse, code_postal, ville, medecin.nom mnom, medecin.prenom mprenom, id_patient
			FROM patient, medecin WHERE patient.id_medecin = medecin.id_medecin AND
			(patient.nom LIKE :search OR patient.prenom LIKE :search OR adresse LIKE :search OR code_postal
			LIKE :search OR ville LIKE :search OR num_ss LIKE :search OR lieu_naissance LIKE :search)");
		
		?>
		<table>
			<tr><th>Civilité</th><th>Nom</th><th>Prénom</th><th>Date de naissance</th><th>Lieu de naissance</th><th>n° sécurité sociale</th><th>Médecin traitant</th><th>Adresse</th><th>Code postal</th><th>Ville</th><th></th><th></th></tr>
		<?php
			foreach($motsRecherche as $mot) {
				$req->execute(array('search'=>'%'.$mot.'%'));

				while($data = $req->fetch()) {
					echo "<tr>
					<td>".$data['pcivilite']."</td>
					<td>".$data['pnom']."</td>
					<td>".$data['pprenom']."</td>
					<td>".date('m/d/Y', $data['date_naissance'])."</td>
					<td>".$data['lieu_naissance']."</td>
					<td>".$data['num_ss']."</td>
					<td>".$data['mnom']." ".$data['mprenom']."</td>
					<td>".$data['adresse']."</td>
					<td>".$data['code_postal']."</td>
					<td>".$data['ville']."</td>
					<td><a href=\"profilpatient.php?id_patient=".$data['id_patient']."\">Modifier</a></td>
					<td><a href=\"supprimerpatient.php?id_patient=".$data['id_patient']."\">Supprimer</a></td></tr>";
				}
			}
		}
	?>
	</table>	
		




	<?php
		include "../php/footer.php";
	?>
</body>