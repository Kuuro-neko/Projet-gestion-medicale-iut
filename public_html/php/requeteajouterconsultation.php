<?php
    require 'config.php';
    require 'connexiondb.php';

    $dateheure = strtotime($_POST['date']) + $_POST['debutmin'] * 60 + $_POST['debutheure'] * 3600;
    if(date("D",$dateheure) == 'Sun') {
       header("Location: ../consultations.php?edit=errorDimanche");
    }
    $duree = $_POST['dureemin'] * 60 + $_POST['dureeheure'] * 3600;


    if(isset($_POST['modifier'])) {
      $edit = "&update=true";
    } else {
      $edit = "";
    }

    // Verif dat eet heure nouveau rdv
    $req = $linkpdo->prepare('SELECT dateheure, duree FROM rendezvous WHERE id_medecin = :id_medecin');
    $req->execute(array('id_medecin'=>$_POST['medecin']));
    $creneauValide = true;
    while($data = $req->fetch()) {
      if($data['dateheure'] + 0 <= $dateheure && $data['dateheure'] + $data['duree'] > $dateheure) {
        header("Location: ../ajoutconsultation.php?date=".$dateheure."&duree=".$duree."&id_patient=".$_POST['id_patient']).$edit;
        $creneauValide = false;
      }
      if($data['dateheure'] + 0 < $dateheure + $duree && $data['dateheure'] + $data['duree'] >= $dateheure + $duree ) {
        header("Location: ../ajoutconsultation.php?date=".$dateheure."&duree=".$duree."&id_patient=".$_POST['id_patient']).$edit;
        $creneauValide = false;
      }
      if($data['dateheure'] + 0 >= $dateheure && $data['dateheure'] + $data['duree'] <= $dateheure + $duree ) {
        header("Location: ../ajoutconsultation.php?date=".$dateheure."&duree=".$duree."&id_patient=".$_POST['id_patient']).$edit;
        $creneauValide = false;
      }
    }

    if($creneauValide && isset($_POST['ajouter'])) {
      $reqEdit = $linkpdo->prepare("INSERT INTO rendezvous (dateheure, duree, id_medecin, id_patient) VALUES (:dateheure, :duree, :id_medecin, :id_patient)");
  
      if($reqEdit->execute(array('id_medecin'=>$_POST['medecin'], 'id_patient'=>$_POST['id_patient'], 'dateheure'=>$dateheure,'duree'=>$duree))) {
        header("Location: ../consultations.php?edit=success");
      } else {
        header("Location: ../consultations.php?edit=error");
      }
    }

    if($creneauValide && isset($_POST['modifier'])) {

    }
?>