<?php
    require 'config.php';
    require 'connexiondb.php';


    $reqEdit = $linkpdo->prepare("INSERT INTO rendezvous (dateheure, duree");

    if($reqEdit->execute(array('civilite'=>$_POST['civilite'], 'nom'=>$_POST['nom'], 'prenom'=>$_POST['prenom'],'id_medecin'=>$_POST['id_medecin']))) {
       header("Location: ../consultations.php?edit=success");
    } else {
       header("Location: ../consultations.php?edit=error");
    }
?>