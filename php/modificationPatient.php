<?php
    require 'config.php';
    require 'connexiondb.php';

    if($_POST['medecin'] === "NULL") {
		$med = null;
	} else {
		$med = $_POST['medecin'];
	}
    
    $reqEdit = $linkpdo->prepare("UPDATE patient
    SET civilite = :civilite, nom = :nom, prenom = :prenom,
    date_naissance = :date_naissance, lieu_naissance = :lieu_naissance, id_medecin = :id_medecin,
    num_ss = :num_ss, adresse = :adresse, code_postal = :code_postal, ville = :ville WHERE id_patient = :id_patient");

    if($reqEdit->execute(array('civilite'=>$_POST['civilite'], 'nom'=>$_POST['nom'], 'prenom'=>$_POST['prenom'],
    'date_naissance'=>strtotime($_POST['date_naissance']), 'lieu_naissance'=>$_POST['lieu_naissance'],
    'id_medecin'=>$med, 'num_ss'=>$_POST['num_ss'],
    'adresse'=>$_POST['adresse'], 'code_postal'=>$_POST['code_postal'], 'ville'=>$_POST['ville'], 'id_patient'=>$_POST['id_patient']))) {
       header("Location: ../public_html/patients.php?edit=success");
    } else {
       header("Location: ../public_html/patients.php?edit=error");
    }
?>