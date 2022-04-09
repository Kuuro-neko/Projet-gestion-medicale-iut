<?php
    require 'config.php';
    require 'connexiondb.php';

    $reqEdit = $linkpdo->prepare("UPDATE medecin SET civilite = :civilite, nom = :nom, prenom = :prenom WHERE id_medecin = :id_medecin");

    if($reqEdit->execute(array('civilite'=>$_POST['civilite'], 'nom'=>$_POST['nom'], 'prenom'=>$_POST['prenom'],'id_medecin'=>$_POST['id_medecin']))) {
       header("Location: ../medecins.php?edit=success");
    } else {
       header("Location: ../medecins.php?edit=error");
    }
?>