<?php
session_start();
setlocale(LC_ALL, 'fr_FR.utf8','fra');
require 'php/config.php';
$thisPage = "ajoutconsultation";

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
	<link rel="stylesheet" type="text/css" href="css/ajoutconsultation.css">
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
	<h1>Ajouter une consultation</h1>
    <?php if(empty($_GET['id_patient'])) { ?>
        <!-- Selection du patient -->
        <fieldset>
            <legend class="title">Choisissez un patient</legend>
            <form method="get">
                <div class="textinputs">
                   <select name="id_patient" required>
                        <option value="">Choix du patient</option>
                        <?php
                            require "php/connexiondb.php";
                            $req = $linkpdo->prepare('SELECT nom, prenom, id_patient FROM patient ORDER BY nom');
                            $req->execute();
                            while($data = $req->fetch()) {
                                echo "<option value=\"".$data['id_patient']."\">".$data['nom']." ".$data['prenom']."</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="submitinputs">
                    <input type="submit" value="Valider"></input>
                    <button class="cancel" onclick="location.href='consultations.php'" type="button">Annuler</button>
                </div>
                <?php 
                if(!empty($_GET['date'])) {
                    echo "<input type=\"hidden\" name=\"date\" value=\"".$_GET['date']."\"></input>";
                }
                ?>
            </form>
        </fieldset>

    <?php } else { ?>

        <!-- Selection du créneau et du médecin -->
        <fieldset>
            <legend class="title">Choisissez le créneau</legend>
            <form method="post" action="php/requeteajouterconsultation.php">
                <div class="textinputs">
                <?php
                // Récupération des variables si passées par GET
                if(!empty($_GET['date'])) {
                    $dateValue = " value=\"".date('Y-m-d', date($_GET['date']))."\"";
                    $debutHeureValue = strftime('%H', $_GET['date']);
                    $debutMinValue = date('i', $_GET['date']);
                } else {
                    $dateValue ="";
                    $debutHeureValue = "7";
                    $debutMinValue = "0";
                }
                if(!empty($_GET['duree'])) {
                    $dureeHeureValue = strftime('%H', $_GET['duree']);
                    $dureeMinValue = date('i', $_GET['duree']);
                } else {
                    $dureeHeureValue = "0";
                    $dureeMinValue = "30";
                }
                ?>
                    Date <input type="date" name="date"<?php echo $dateValue;?> required></input>
                    <div class="heures">
                        <fieldset class="time">
                        <!-- Heure de début -->
                        <legend class="timelegend">Heure de début</legend>
                            Heures <input type="number" name="debutheure" value="<?php echo $debutHeureValue; ?>" min="7" max="23" required></input>
                            Minutes <input type="number" name="debutmin" value="<?php echo $debutMinValue; ?>" min="0" max="59" required></input>
                        </fieldset>
                        
                        <fieldset class="time">
                        <!-- Durée -->
                        <legend class="timelegend">Durée</legend>
                            Heures <input type="number" name="dureeheure" value="<?php echo $dureeHeureValue; ?>" min="0" max="10" required></input>
                            Minutes <input type="number" name="dureemin" value="<?php echo $dureeMinValue; ?>" min="0" max="59" required></input>
                        </fieldset>

                    </div>

                    Médecin
                    <select name="medecin">
                        <?php
                        require 'php/connexiondb.php';
                        $req = $linkpdo->prepare('SELECT nom, prenom, id_medecin FROM medecin WHERE medecin.id_medecin = (SELECT patient.id_medecin FROM patient WHERE id_patient = :id_patient)');
                        $req->execute(array('id_patient'=>$_GET['id_patient']));
                       
                        if($data = $req->fetch()) {
                            // Si le patient a un médecin traitent, le proposer 
                            echo "<option value=\"".$data['id_medecin']."\">".$data['nom']." ".$data['prenom']."</option>";
                            $requ = $linkpdo->prepare("SELECT nom, prenom, id_medecin FROM medecin where id_medecin <> :idmed ORDER BY nom");
                            $requ->execute(array('idmed'=>$data['id_medecin']));
                            while($data2 = $requ->fetch()) {
                                echo "<option value=\"".$data2['id_medecin']."\">".$data2['nom']." ".$data2['prenom']."</option>";
                            }
                        } else { ?>
                            <option value="NULL">Choix du médecin</option>
                            <?php
                            // Sinon, montrer tous les médecins
                            $requ = $linkpdo->prepare("SELECT nom, prenom, id_medecin FROM medecin ORDER BY nom");
                            $requ->execute();
                            while($data2 = $requ->fetch()) {
                                echo "<option value=\"".$data2['id_medecin']."\">".$data2['nom']." ".$data2['prenom']."</option>";
                            }
                       } ?>
                    </select>

                </div>
                <div class="submitinputs">
                    <input type="submit" name="ajouter" value="Ajouter"></input>
                    <button class="cancel" onclick="location.href='ajoutconsultation.php'" type="button">Annuler</button>
                </div>
                <input type="hidden" value="<?php echo $_GET['id_patient']; ?>" name="id_patient"></input>
            </form>
        </fieldset>
	<?php
    }
		include "php/footer.php";
	?>
</body>
</html>