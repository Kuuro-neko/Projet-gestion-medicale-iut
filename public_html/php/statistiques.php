<?php
    require 'connexiondb.php';

    $date_25y = strtotime("-25 year", time());
    $date_50y = strtotime("-50 year", time());

    $req_inf25 = $linkpdo->prepare('SELECT count(*) as nb from patient WHERE civilite = :civilite AND date_naissance > :date_25y');
    $req_inf50_sup25 = $linkpdo->prepare('SELECT count(*) as nb from patient WHERE civilite = :civilite AND date_naissance < :date_25y AND date_naissance > :date_50y');
    $req_sup50 = $linkpdo->prepare('SELECT count(*) as nb from patient WHERE civilite = :civilite AND date_naissance < :date_50y');

    $req_inf25->execute(array('civilite'=>'Monsieur','date_25y'=>$date_25y));
    $data_inf25_M = $req_inf25->fetch();
    $req_inf25->execute(array('civilite'=>'Madame','date_25y'=>$date_25y));
    $data_inf25_F = $req_inf25->fetch();

    $req_inf50_sup25->execute(array('civilite'=>'Monsieur','date_25y'=>$date_25y,'date_50y'=>$date_50y));
    $data_inf50_sup25_M = $req_inf50_sup25->fetch();
    $req_inf50_sup25->execute(array('civilite'=>'Madame','date_25y'=>$date_25y,'date_50y'=>$date_50y));
    $data_inf50_sup25_F = $req_inf50_sup25->fetch();

    $req_sup50->execute(array('civilite'=>'Monsieur','date_50y'=>$date_50y));
    $data_sup_50_M = $req_sup50->fetch();
    $req_sup50->execute(array('civilite'=>'Madame','date_50y'=>$date_50y));
    $data_sup_50_F = $req_sup50->fetch();
?>
<h2>Répartition des patients selon leur sexe et leur âge</h2>
<table>
    <tr>
        <th>Tranche d'âge</th><th>Nb Hommes</th><th>Nb Femmes</th>
    </tr>
    <tr class="pair">
        <td>Moins de 25 ans</td><?php echo "<td>".$data_inf25_M['nb']."</td><td>".$data_inf25_F['nb']."</td>"; ?>
    </tr>
    <tr class="impair">
        <td>Entre 25 et 50 ans</td><?php echo "<td>".$data_inf50_sup25_M['nb']."</td><td>".$data_inf50_sup25_F['nb']."</td>"; ?>
    </tr>
    <tr class="pair">
        <td>Plus de 50 ans</td><?php echo "<td>".$data_sup_50_M['nb']."</td><td>".$data_sup_50_F['nb']."</td>"; ?>
    </tr>
</table>

<h2>Heures de rdv par médecin</h2>
<table>
    <tr>
        <th>Nom médecin</th><th>Durée totale des consultations</th>
    </tr>
    <?php
        $req = $linkpdo->prepare('SELECT sum(duree) as duree, nom, prenom FROM rendezvous, medecin WHERE rendezvous.id_medecin = medecin.id_medecin GROUP BY rendezvous.id_medecin');
        $req->execute();
        $i = 0;
        while($data = $req->fetch()) {
            if($i % 2 == 0) {
                $parite = "pair";
            } else {
                $parite = "impair";
            }
            echo "<tr class=".$parite."><td>".$data['nom']." ".$data['prenom']."</td><td>".($data['duree']/3600)." Heures</td></tr>";
            $i++;
        }
    ?>
</table>