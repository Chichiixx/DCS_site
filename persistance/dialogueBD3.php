<?php
require_once 'connexion.php';
try {
    $conn = Connexion::getConnexion();
    $sql = "
            SELECT produit.produitID,NOM_PRODUIT,mois,SUM(lf.volume) AS volume
            FROM ligne_facturation lf
            JOIN produit ON lf.produitID = produit.produitID
            WHERE lf.produitID IN (20, 13) AND mois BETWEEN '2021-01-01' AND '2022-04-01'
            GROUP BY NOM_PRODUIT,mois
            ORDER BY NOM_PRODUIT,mois ASC;
        ";
    $sth = $conn->prepare($sql);

    $sth->execute();

    // Créer un tableau pour stocker les résultats
    $data = array();

    // Récupérer les résultats ligne par ligne
    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        // Ajouter chaque ligne dans le tableau $data
        $data[] = array(
            'NOM_PRODUIT' => $row['NOM_PRODUIT'],
            'mois' => $row['mois'],
            'volume' => $row['volume']
        );
    }

    // Renvoyer les résultats sous forme de JSON
    echo json_encode($data);

} catch (Exception $e) {
    $error = $e->getMessage();
    echo json_encode(["error" => $error]);
}
