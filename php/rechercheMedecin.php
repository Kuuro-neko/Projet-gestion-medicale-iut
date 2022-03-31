<?php
    // Connexion à la BD
    require '../php/connexiondb.php';

    // Séparation des critères de recherche
    $motsRecherche = explode(" ", $_POST["searchField"]);

    //Préparation de la requête
    $req = $linkpdo->prepare("SELECT civilite, prenom, nom, id_medecin FROM medecin WHERE civilite LIKE :search OR nom LIKE :search OR prenom LIKE :search");
    ?>
    <table id="resultatsRecherche">
        <tr id="tete"><th>Civilité</th><th>Nom</th><th>Prénom</th><td></td><td></td></tr>
    <?php
    // Tableau pour supprimer les résultats en double
    $id_medecins_deja_trouves = array();
    // Parcours de la requête
    $i = 0;
    foreach($motsRecherche as $mot) {
        $req->execute(array('search'=>'%'.$mot.'%'));
        while($data = $req->fetch()) {
            if (!in_array($data['id_medecin'], $id_medecins_deja_trouves)) {
                $parite = ($i % 2 == 0) ? "pair" : "impair";
                $i++;
                echo "<tr class=\"".$parite."\">
                <td>".$data['civilite']."</td>
                <td>".$data['nom']."</td>
                <td>".$data['prenom']."</td>
                <td class=\"editcell\"><a href=\"profilmedecin.php?id_medecin=".$data['id_medecin']."\">Modifier</a></td>
                <td class=\"delcell\"><a href=\"medecins.php?id_medecin=".$data['id_medecin']."\">Supprimer</a></td></tr>";
                array_push($id_medecins_deja_trouves, $data['id_medecin']);
            }
        }
    }
?>
</table>
