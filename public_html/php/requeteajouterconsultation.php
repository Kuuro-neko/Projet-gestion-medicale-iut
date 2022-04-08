<?php
    require 'config.php';
    require 'connexiondb.php';

    $dateheure = strtotime($_POST['date']) + $_POST['debutmin'] * 60 + $_POST['debutheure'] * 3600;
    if(date("D",$dateheure) == 'Sun') {
       header("Location: ../consultations.php?edit=errorDimanche");
    }
    $duree = $_POST['dureemin'] * 60 + $_POST['dureeheure'] * 3600;




    // Verif dat eet heure nouveau rdv
    $req = $linkpdo->prepare('SELECT dateheure, duree FROM rendezvous WHERE id_medecin = :id_medecin');
    $req->execute(array('id_medecin'=>$_POST['medecin']));
    $creneauValide = true;
    while($data = $req->fetch()) {
      var_dump($dateheure);
      var_dump($data['dateheure']);
      if($data['dateheure'] + 0 < $dateheure && $data['dateheure'] + $data['duree'] > $dateheure) {
        header("Location: ../ajoutconsultation.php?date=".$dateheure."&duree=".$duree."&id_patient=".$_POST['id_patient']);
        $creneauValide = false;
      }
      if($data['dateheure'] + 0 < $dateheure + $duree && $data['dateheure'] + $data['duree'] > $dateheure + $duree ) {
        header("Location: ../ajoutconsultation.php?date=".$dateheure."&duree=".$duree."&id_patient=".$_POST['id_patient']);
        $creneauValide = false;
      }
      if($data['dateheure'] + 0 > $dateheure && $data['dateheure'] + $data['duree'] < $dateheure + $duree ) {
        header("Location: ../ajoutconsultation.php?date=".$dateheure."&duree=".$duree."&id_patient=".$_POST['id_patient']);
        $creneauValide = false;
      }
    }

/*
    $reqVerif = $linkpdo->prepare("SELECT * FROM rendezvous WHERE NOT(:datedebut >= (dateheure + duree) AND :datefin <= dateheure) AND id_medecin = :id_medecin");
    $reqVerif->execute(array('datedebut'=>$dateheure, 'datefin'=>($dateheure + $duree), 'id_medecin'=>$_POST['medecin']));
    if($data = $reqVerif->fetch()) {
      header("Location: ../consultations.php?edit=errorHeure");
    }
*/
    if($creneauValide) {
      $reqEdit = $linkpdo->prepare("INSERT INTO rendezvous (dateheure, duree, id_medecin, id_patient) VALUES (:dateheure, :duree, :id_medecin, :id_patient)");
  
      if($reqEdit->execute(array('id_medecin'=>$_POST['medecin'], 'id_patient'=>$_POST['id_patient'], 'dateheure'=>$dateheure,'duree'=>$duree))) {
        header("Location: ../consultations.php?edit=success");
      } else {
        header("Location: ../consultations.php?edit=error");
      }
    }
?>