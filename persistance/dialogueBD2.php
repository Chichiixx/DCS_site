<?php
require_once 'connexion.php';
try {
    $conn = Connexion::getConnexion();
    $sql = "
            SELECT clients.NomClient, ligne_facturation.mois AS 'mois', SUM(ligne_facturation.prix) AS 'montant' FROM ligne_facturation
            JOIN centresactivite ON centresactivite.CentreActiviteID = ligne_facturation.CentreActiviteID
            JOIN clients ON clients.CentreActiviteID = centresactivite.CentreActiviteID
            WHERE clients.ClientID IN (1, 6, 11, 110, 5)
            GROUP BY clients.NomClient, ligne_facturation.mois;
        ";
    $sth = $conn->prepare($sql);

    $sth->execute();

    // Créer un tableau pour stocker les résultats
    $data = array();

    // Récupérer les résultats ligne par ligne
    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        // Ajouter chaque ligne dans le tableau $data
        $data[] = array(
            'NomClient' => $row['NomClient'],
            'mois' => $row['mois'],
            'montant' => $row['montant']
        );
    }

    // Renvoyer les résultats sous forme de JSON
    echo json_encode($data);

} catch (Exception $e) {
    $error = $e->getMessage();
    echo json_encode(["error" => $error]);
}
