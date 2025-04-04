<?php
require_once 'connexion.php';
try {
    $conn = Connexion::getConnexion();
    $sql = "
            SELECT gc.NomGrandClient, a.nomAppli, SUM(lf.prix) AS TotalFacture
            FROM ligne_facturation lf
            JOIN produit p ON lf.produitID = p.produitID
            JOIN famille f ON p.familleID = f.familleID
            JOIN clients c ON lf.CentreActiviteID = c.CentreActiviteID
            JOIN grandclients gc ON c.GrandClientID = gc.GrandClientID
            JOIN application a ON lf.IRT = a.IRT
            WHERE gc.NomGrandClient = 'Client2'
            GROUP BY gc.NomGrandClient, a.nomAppli
            ORDER BY TotalFacture DESC
            LIMIT 10;
        ";
    $sth = $conn->prepare($sql);

    $sth->execute();

    // Créer un tableau pour stocker les résultats
    $data = array();

    // Récupérer les résultats ligne par ligne
    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        // Ajouter chaque ligne dans le tableau $data
        $data[] = array(
            'NomGrandClient' => $row['NomGrandClient'],
            'nomAppli' => $row['nomAppli'],
            'TotalFacture' => $row['TotalFacture']
        );
    }

    // Renvoyer les résultats sous forme de JSON
    echo json_encode($data);

} catch (Exception $e) {
    $error = $e->getMessage();
    echo json_encode(["error" => $error]);
}
