<?php
session_start();
require '../php/config.php';
$thisPage = "profilpatient";

// Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
if(empty($_SESSION['signedin'])) {
	header("Location: index.php");
}
// Déconnexion de l'utilisateur
if(isset($_GET["disconnect"])) {
	session_destroy();
	header("Location: index.php");
}
// Si arrivée en cliquant depuis Modifier dans la liste des patients, préremplir le formulaire
if(!empty($_GET['id_patient'])) {
	$modificationPatient = true;
	require '../php/connexiondb.php';

	$req = $linkpdo->prepare("SELECT patient.nom pnom, patient.prenom pprenom, patient.civilite pcivilite, date_naissance,
    lieu_naissance, num_ss, adresse, code_postal, ville, medecin.nom mnom, medecin.prenom mprenom, id_patient
    FROM patient, medecin WHERE patient.id_medecin = medecin.id_medecin AND patient.id_patient = :id_patient");

	$req->execute(array('id_patient'=>$_GET['id_patient']));

	$data = $req->fetch();
}

// Si annuler, retour page patients
if(isset($_POST['annuler'])) {
	header("Location: patients.php");
}

// TO DO MODIFICATION DE PATIENT
/*
Si id_patient via methode get alors
	requete de modification
	redirection vers patient.php
Fin si
*/

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
	<link rel="stylesheet" type="text/css" href="../css/profilpatient.css">
	<link rel="stylesheet" type="text/css" href="../css/footer.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="icon" href="../images/logo.png" />
	<title>Projet Gestion médicale</title>
</head>

<body>
	<?php
		include "../php/header.php";
	?>
	<h1>Profil de patient</h1>

	<fieldset>
		<legend>
			<?php echo ($modificationPatient) ? "Modifier le patient" : "Ajouter un patient"; ?>
		</legend>
		<form method="post">
			<div class="textinputs">
				Nom<input type="text" name="nom" value="<?php echo ($modificationPatient) ? $data['pnom'] : ""; ?>"></input>
				Prénom<input type="text" name="prenom" value="<?php echo ($modificationPatient) ? $data['pprenom'] : ""; ?>"></input>
				Civilité<input type="text" name="civilite" value="<?php echo ($modificationPatient) ? $data['pcivilite'] : ""; ?>"></input>
				Date de naissance<input type="text" name="date_naissance" value="<?php echo ($modificationPatient) ? $data['date_naissance'] : ""; ?>"></input>
				Lieu de naissance<input type="text" name="lieu_naissance" value="<?php echo ($modificationPatient) ? $data['lieu_naissance'] : ""; ?>"></input>
				N° de sécurité sociale<input type="text" name="num_ss" value="<?php echo ($modificationPatient) ? $data['num_ss'] : ""; ?>"></input>
				Médecin traitant<input type="text" name="medecintraitant" value="<?php echo ($modificationPatient) ? $data['mnom']." ".$data['mprenom'] : ""; ?>"></input>
				Adresse<input type="text" name="adresse" value="<?php echo ($modificationPatient) ? $data['adresse'] : ""; ?>"></input>
				Code postal<input type="text" name="code_postal" value="<?php echo ($modificationPatient) ? $data['code_postal'] : ""; ?>"></input>
				Ville<input type="text" name="ville" value="<?php echo ($modificationPatient) ? $data['ville'] : ""; ?>"></input>
			</div>
			<div class="submitinputs">
				<?php if($modificationPatient) {?>
					<input class="edit" type="submit" name="modifier" value="Modifier"></input> 
				<?php } else { ?>
					<input class="add" type="submit" name="ajouter" value="Ajouter"></input> 
				<?php } ?>
				<input class="cancel" type="submit" name="annuler" value="Annuler"></input> 
			</div>
			<?php if($modificationPatient) { echo "<input type=\"hidden\" value=\"".$data['id_patient']."\" name=\"id_patient\"></input>"; } ?>
		</form>
	</fieldset>
	

	<?php
		include "../php/footer.php";
	?>
</body>
</html>