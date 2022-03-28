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
	require '../php/connexiondb.php';

	if(!empty($_GET['id_medecin'])) {
		$req = $linkpdo->prepare("SELECT patient.nom pnom, patient.prenom pprenom, patient.civilite pcivilite, date_naissance,
		lieu_naissance, num_ss, adresse, code_postal, ville, medecin.nom mnom, medecin.prenom mprenom, id_patient, patient.id_medecin id_medtraitant
		FROM patient, medecin WHERE patient.id_patient = :id_patient AND patient.id_medecin = medecin.id_medecin");
	} else {
		$req = $linkpdo->prepare("SELECT patient.nom pnom, patient.prenom pprenom, patient.civilite pcivilite, date_naissance,
		lieu_naissance, num_ss, adresse, code_postal, ville, id_patient
		FROM patient WHERE patient.id_patient = :id_patient");
	}

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
			Modifier le patient
		</legend>
		<form method="post">
			<div class="textinputs">
				Nom<input type="text" name="nom" value="<?php echo $data['pnom']; ?>" required></input>
				Prénom<input type="text" name="prenom" value="<?php echo $data['pprenom']; ?>" required></input>
				Civilité<input type="text" name="civilite" value="<?php echo $data['pcivilite']; ?>" required></input>
				Date de naissance<input type="date" name="date_naissance" value="<?php echo date('Y-d-m', $data['date_naissance']); ?>" required></input>
				Lieu de naissance<input type="text" name="lieu_naissance" value="<?php echo $data['lieu_naissance']; ?>" required></input>
				<select name="medecin">
				<?php
					if(!empty($_GET['id_medecin'])) { ?>
						<option value="<?php echo $_GET['id_medecin']; ?>">
							<?php
								echo $data['mnom']." ".$data['mprenom'];
							?>
						</option>
					<?php } ?>
						<option value="NULL">Aucun médecin traitant</option>
						<?php
						// Génération des options
							// Connexion à la BD
							require '../php/connexiondb.php';
							//Préparation de la requête
							$requ = $linkpdo->prepare("SELECT nom, prenom, id_medecin FROM medecin where id_medecin <> :idmed");
							// Execution de la requête
							$requ->execute(array('idmed'=>$_GET['id_medecin']));
							while($data2 = $requ->fetch()) {
								echo "<option value=\"".$data2['id_medecin']."\">".$data2['nom']." ".$data2['prenom']."</option>";
							}
						?>
				</select>
				N° de sécurité sociale<input type="text" name="num_ss" value="<?php echo $data['num_ss']; ?>" required></input>
				Adresse<input type="text" name="adresse" value="<?php echo $data['adresse']; ?>" required></input>
				Code postal<input type="text" name="code_postal" value="<?php echo $data['code_postal']; ?>" required></input>
				Ville<input type="text" name="ville" value="<?php echo $data['ville']; ?>" required></input>
			</div>
			<div class="submitinputs">
				<input class="edit" type="submit" name="modifier" value="Modifier"></input> 
				<input class="cancel" type="submit" name="annuler" value="Annuler"></input> 
			</div>
			<?php echo "<input type=\"hidden\" value=\"".$data['id_patient']."\" name=\"id_patient\"></input>"; ?>
		</form>
	</fieldset>
	

	<?php
		include "../php/footer.php";
	?>
</body>
</html>