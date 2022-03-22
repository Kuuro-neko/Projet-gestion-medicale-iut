<?php
    // Connexion à la BD
    require '../php/connexiondb.php';

    // Séparation des critères de recherche
    $motsRecherche = explode(" ", $_POST["searchField"]);

    //Préparation de la requête
    $req = $linkpdo->prepare("SELECT patient.nom pnom, patient.prenom pprenom, patient.civilite pcivilite, date_naissance,
    lieu_naissance, num_ss, adresse, code_postal, ville, medecin.nom mnom, medecin.prenom mprenom, id_patient
    FROM patient, medecin WHERE patient.id_medecin = medecin.id_medecin AND
    (patient.nom LIKE :search OR patient.prenom LIKE :search OR adresse LIKE :search OR code_postal
    LIKE :search OR ville LIKE :search OR num_ss LIKE :search OR lieu_naissance LIKE :search)");
    ?>
    <table id="resultatsRecherche">
        <tr id="tete"><th>Civilité</th><th>Nom</th><th>Prénom</th><th>Date de naissance</th><th>Lieu de naissance</th><th>n° sécurité sociale</th><th>Médecin traitant</th><th>Adresse</th><th>Code postal</th><th>Ville</th><td></td><td></td></tr>
    <?php
    // Tableau pour supprimer les résultats en double
    $id_patients_deja_trouves = array();
    // Parcours de la requête
    $i = 0;
    foreach($motsRecherche as $mot) {
        $req->execute(array('search'=>'%'.$mot.'%'));
        while($data = $req->fetch()) {
            if (!in_array($data['id_patient'], $id_patients_deja_trouves)) {
                $parite = ($i % 2 == 0) ? "pair" : "impair";
                $i++;
                echo "<tr class=\"".$parite."\">
                <td>".$data['pcivilite']."</td>
                <td>".$data['pnom']."</td>
                <td>".$data['pprenom']."</td>
                <td>".date('m/d/Y', $data['date_naissance'])."</td>
                <td>".$data['lieu_naissance']."</td>
                <td>".$data['num_ss']."</td>
                <td>".$data['mnom']." ".$data['mprenom']."</td>
                <td>".$data['adresse']."</td>
                <td>".$data['code_postal']."</td>
                <td>".$data['ville']."</td>
                <td class=\"editcell\"><a href=\"profilpatient.php?id_patient=".$data['id_patient']."\">Modifier</a></td>
                <td class=\"delcell\"><a href=\"patients.php?id_patient=".$data['id_patient']."\">Supprimer</a></td></tr>";
                array_push($id_patients_deja_trouves, $data['id_patient']);
            }
        }
    }
?>
</table>
