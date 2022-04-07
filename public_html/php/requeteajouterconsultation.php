<?php
    require 'config.php';
    require 'connexiondb.php';
    var_dump($_POST['date']);

    var_dump($_POST['debutheure']);
    var_dump($_POST['debutmin']);

    var_dump($_POST['dureeheure']);
    var_dump($_POST['dureemin']);

    var_dump($_POST['medecin']);

    var_dump($_POST['id_patient']);

    $dateheure = strtotime($_POST['date']) + $_POST['debutmin'] * 60 + $_POST['debutheure'] * 3600;
    $duree = $_POST['dureemin'] * 60 + $_POST['dureeheure'] * 3600;



    $reqEdit = $linkpdo->prepare("INSERT INTO rendezvous (dateheure, duree, id_medecin, id_patient) VALUES (:dateheure, :duree, :id_medecin, :id_patient)");

    if($reqEdit->execute(array('id_medecin'=>$_POST['medecin'], 'id_patient'=>$_POST['id_patient'], 'dateheure'=>$dateheure,'duree'=>$duree))) {
       //header("Location: ../consultations.php?edit=success");
    } else {
       //header("Location: ../consultations.php?edit=error");
    }
?>