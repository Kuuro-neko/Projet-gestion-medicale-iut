<?php
    // Connexion à la BD
    require '../php/connexiondb.php';

    //Préparation de la requête
    $req = $linkpdo->prepare("SELECT nom, prenom, id_medecin FROM medecin");

    // Execution de la requête
    $req->execute();
?>
<select name="medecin">
    <option value="">Médecin traitant</option>
    <option value="">Aucun médecin traitant</option>
    <?php 
    while($data = $req->fetch()) {
        echo "<option value=\"".$data['id_medecin']."\">".$data['nom']." ".$data['prenom']."</option>";
    }
    ?>
</select>

