<?php
session_start();
setlocale(LC_TIME, 'fr_FR.utf8','fra');
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

// Si consultation à supprimer
if(isset($_POST['delete'])) {
	require "php/connexiondb.php";
	$delete = $linkpdo->prepare('DELETE FROM rendezvous WHERE id_medecin = :id_medecin AND dateheure = :dateheure');
	$delete->execute(array('id_medecin'=>$_POST['id_medecin'], 'dateheure'=>$_POST['dateheure']));
}

// Si l'utilisateur veut aller à une semaine rapidement
if(isset($_POST['goto'])) {
	header("Location:consultations.php?week=".intval(date("W", strtotime($_POST['gotodate'])))."&year=".intval(date("Y", strtotime($_POST['gotodate']))));
}

// Retourne le nombre de semaines (int) d'une année (int)
function getWeeksInYear($year) {
    $date = new DateTime;
    $date->setISODate($year, 53);
    return ($date->format("W") === "53" ? 53 : 52);
}

// Retourne un tableau contenant les 7 jours d'une semaine d'une année
function daysInWeek($yearNum, $weekNum)
{
    $result = array();
    $datetime = new DateTime();
    $datetime->setISODate($yearNum, $weekNum, 1);
    $interval = new DateInterval('P1D');
    $week = new DatePeriod($datetime, $interval, 6);
	
	
    foreach($week as $day){
        $result[] = $day->getTimestamp();
    }
    return $result;
}

// Affecter les valeurs à l'année et semaine affichée sur la page
if(empty($_GET['year'])) {
	$_SESSION['year'] = intval(date("Y", time()));
} else {
	$_SESSION['year'] = $_GET['year'];
}
if(empty($_GET['week'])) {
	$_SESSION['week'] = intval(date("W", time()));
} else {
	$_SESSION['week'] = $_GET['week'];
}

// Variables pour la semaine suivante
if ($_SESSION['week'] + 1 > getWeeksInYear($_SESSION['year'])) {
	$nextYear = $_SESSION['year'] + 1;
	$nextWeek = 1;
} else {
	$nextYear = $_SESSION['year'];
	$nextWeek = $_SESSION['week'] + 1;
}

// Variables pour la semaine précédente
if ($_SESSION['week'] - 1 < 1) {
	$prevYear = $_SESSION['year'] - 1;
	$prevWeek = getWeeksInYear($_SESSION['year'] - 1);
} else {
	$prevYear = $_SESSION['year'];
	$prevWeek = $_SESSION['week'] - 1;
}

// Creer un tableau contenant le timestamp de début et de fin des 7 jours de la semaine courante pour l'affichage des consultations dans le calendrier
$currentWeek = daysInWeek($_SESSION['year'], $_SESSION['week']);

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
	<?php
	// après ajout d'une consultation
	if(!empty($_GET['edit'])) {
		if($_GET['edit'] === "success") {
			echo "<p class=\"success\">Consultation créée avec succès !</p>";
		} elseif($_GET['edit'] === "errorDimanche") {
			echo "<p class=\"error\">Erreur, le cabinet est fermé le dimanche</p>";
		} else {
			echo "<p class=\"error\">Erreur lors de la modification</p>";
		}
	}
	?>
	<div class="ajouterHorsCalendrier">
		<button class="bouton" onclick="location.href='ajoutconsultation.php'" type="button">Créer une nouvelle consultation</button>
	</div>
	<!-- Navigation dans le calendrier -->
	<div class="semaines">
		<button class="semainePrec" onclick="location.href='consultations.php?week=<?php echo $prevWeek.'&year='.$prevYear; ?>'" type="button">⇦ Semaine <?php echo $prevWeek; ?></button>
		<div id="centreSemaines">
			<p id="dispSemaine">Année <?php echo $_SESSION['year']; ?> Semaine <?php echo $_SESSION['week']; ?></p>

			<form method="post">
				<input type="date" name="gotodate"></input>
				<input class="bouton" type="submit" name="goto" value="Aller à la semaine sélectionnée"></input>
				<?php
				if($_SESSION['week'] !=  intval(date("W", time()))) {
			?> <a id="reset" href='consultations.php'>&nbsp;Retour semaine courante</a> <?php
				} ?>
			</form>
		</div>
		<button class="semaineSuiv" onclick="location.href='consultations.php?week=<?php echo $nextWeek.'&year='.$nextYear; ?>'" type="button">Semaine <?php echo $nextWeek; ?> ⇨</button>
	</div>
	<?php require "php/connexiondb.php"; 
		$req = $linkpdo->prepare('SELECT patient.nom as pnom, substr(patient.prenom,1,1) as pprenom, medecin.nom as mnom, substr(medecin.prenom,1,1) as mprenom, dateheure, duree,
		 rendezvous.id_medecin as rdv_id_med, rendezvous.id_patient as rdv_id_pat FROM patient, medecin, rendezvous
		WHERE rendezvous.id_medecin = medecin.id_medecin AND rendezvous.id_patient = patient.id_patient AND dateheure > :debutintervalle AND dateheure < :finintervalle ORDER BY dateheure');
	
	?>
	<!-- Calendrier -->
	<div class="consultations">
		<?php
		for($i = 0; $i < 6; $i++) {
			$position = "";
			if($i == 0) {
				$position = " jourGauche";
			} elseif ($i == 5) {
				$position = " jourDroite";
			}
			echo "<div class=\"jour".$position."\"><p class=\"nomJour\">".ucfirst(strftime("%A %e %B", $currentWeek[$i]))."</p>";
			
			// les DateTime se positionnent sur un jour à midi, on fait +/- 43200 (12 heures en secondes)
			$debutintervalle = $currentWeek[$i] - 43200;
			$finintervalle = $currentWeek[$i] + 43200;

			$req->execute(array('debutintervalle'=>$debutintervalle,'finintervalle'=>$finintervalle));
			while($data = $req->fetch()) {
				?>
				<div class="consultation">
					<p class="heure">Heure : <?php echo date("H:i", $data['dateheure']); ?></p>
					<p class="duree">Durée : <?php echo date("H:i", $data['duree']); ?></p>
					<p class="patient">Patient : <?php echo $data['pnom']." ".$data['pprenom']."."; ?></p>
					<p class="medecin">Médecin : <?php echo $data['mnom']." ".$data['mprenom']."."; ?></p>
					<div class="btConsultation">
						<form action="ajoutconsultation.php" method="get">
							<input class="edit" type="submit" name="edit" value="Modifier"></input>
							<input type="hidden" name="date" value="<?php echo $data['dateheure']; ?>">
							<input type="hidden" name="duree" value="<?php echo $data['duree']; ?>">
							<input type="hidden" name="id_patient" value="<?php echo $data['rdv_id_pat']; ?>">
							<input type="hidden" name="update" value="true">
						</form>
						<form method="post" onsubmit="return confirm('Voulez-vous vraiment supprimer cette consultation ?');">
							<input class="delete" type="submit" name="delete" value="Supprimer"></input>
							<input type="hidden" name="dateheure" value="<?php echo $data['dateheure']; ?>">
							<input type="hidden" name="id_medecin" value="<?php echo $data['rdv_id_med']; ?>">
						</form>
					</div>
				</div>
				<?php
			}
			echo "</div>";
		}
		?>
	</div>

	<?php
		include "php/footer.php";
	?>
</body>
</html>