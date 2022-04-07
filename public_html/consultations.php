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
		<button class="retourSemaineActuelle" onclick="location.href='ajoutconsultation.php'" type="button">Créer une nouvelle consultation</button>
	</div>
	<div class="semaines">
		<button class="semainrePrec" onclick="location.href='consultations.php?week=<?php echo $prevWeek.'&year='.$prevYear; ?>'" type="button">⇦ Semaine <?php echo $prevWeek; ?></button>
		<div id="centreSemaines">
			<p id="dispSemaine">Année <?php echo $_SESSION['year']; ?> Semaine <?php echo $_SESSION['week']; ?></p>
			<?php
				if($_SESSION['week'] !==  intval(date("W", time()))) {
			?> <button class="retourSemaineActuelle" onclick="location.href='consultations.php'" type="button">Retour semaine courante</button> <?php
				} ?>
		</div>
		<button class="semaineSuiv" onclick="location.href='consultations.php?week=<?php echo $nextWeek.'&year='.$nextYear; ?>'" type="button">Semaine <?php echo $nextWeek; ?> ⇨</button>
	</div>
	<?php require "php/connexiondb.php"; 
		$req = $linkpdo->prepare('SELECT patient.nom as pnom, substr(patient.prenom,1,1) as pprenom, medecin.nom as mnom, substr(medecin.prenom,1,1) as mprenom, dateheure, duree FROM patient, medecin, rendezvous
		WHERE rendezvous.id_medecin = medecin.id_medecin AND rendezvous.id_patient = patient.id_patient AND dateheure > :debutintervalle AND dateheure < :finintervalle ORDER BY dateheure');
	
	?>
	

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
			
			$debutintervalle = $currentWeek[$i];
			$finintervalle = $currentWeek[$i + 1];

			$req->execute(array('debutintervalle'=>$debutintervalle,'finintervalle'=>$finintervalle));
			while($data = $req->fetch()) {
				?>
				<div class="consultation">
					<p class="heure">Heure : <?php echo date("h:i", $data['dateheure']); ?></p>
					<p class="duree">Durée : <?php echo date("h:i", $data['duree']); ?></p>
					<p class="patient">Patient : <?php echo $data['pnom']." ".$data['pprenom']."."; ?></p>
					<p class="medecin">Médecin : <?php echo $data['mnom']." ".$data['mprenom']."."; ?></p>
					<div class="btConsultation">
						<button class="editConsultation" onclick="location.href='modifconsultation.php'" type="button">Modifier</button>
						<button class="deleteConsultation" onclick="location.href='consultation.php'" type="button">Modifier</button>
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