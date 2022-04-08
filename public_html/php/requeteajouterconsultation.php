<?php
    require 'config.php';
    require 'connexiondb.php';

    $dateheure = strtotime($_POST['date']) + $_POST['debutmin'] * 60 + $_POST['debutheure'] * 3600;
    if(date("D",$dateheure) == 'Sun') {
       header("Location: ../consultations.php?edit=errorDimanche");
    }
    $duree = $_POST['dureemin'] * 60 + $_POST['dureeheure'] * 3600;

    $reqVerif = $linkpdo->prepare("SELECT * FROM rendezvous
    WHERE NOT((:datedebut < dateheure OR :datedebut >= (dateheure + duree))
    AND (:datefin <= dateheure OR :datefin > (dateheure + duree))
    AND (:datedebut <= dateheure AND :datefin >= (dateheure + duree)))");
    $reqVerif->execute(array('datedebut'=>$dateheure, 'datefin'=>($dateheure + $duree)));
    if($data = $reqVerif->fetch()) {
      header("Location: ../consultations.php?edit=errorRDVInterference");
    }

    $reqEdit = $linkpdo->prepare("INSERT INTO rendezvous (dateheure, duree, id_medecin, id_patient) VALUES (:dateheure, :duree, :id_medecin, :id_patient)");

    if($reqEdit->execute(array('id_medecin'=>$_POST['medecin'], 'id_patient'=>$_POST['id_patient'], 'dateheure'=>$dateheure,'duree'=>$duree))) {
      header("Location: ../consultations.php?edit=success");
    } else {
      header("Location: ../consultations.php?edit=error");
    }
?>