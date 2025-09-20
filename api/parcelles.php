<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/Parcelle.php';

// Connexion à la base
$database = new Database();
$db = $database->getConnection();

// Vérification de l'action
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'get_parcelles_by_type') {
    
    $operation_id = isset($_GET['operation_id']) ? $_GET['operation_id'] : '';
    $type_parcelle_id = isset($_GET['type_parcelle_id']) ? $_GET['type_parcelle_id'] : '';

    if (!empty($operation_id) && !empty($type_parcelle_id)) {
        
        $parcelle = new Parcelle($db);
        $stmt = $parcelle->readByType($operation_id, $type_parcelle_id);
        $num = $stmt->rowCount();

        

        if ($num > 0) {
            $parcelles_arr = array();
            $parcelles_arr["success"] = true;
            $parcelles_arr["parcelles"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $parcelle_item = array(
                    "id"            => $id,
                    "section"       => $section,
                    "lot"           => $lot,
                    "parcelle"      => $parcelle,
                    "surface"       => isset($surface) ? (float)$surface : 0,
                    "cout_unitaire" => isset($cout_unitaire) ? (float)$cout_unitaire : 0,
                    "prix"          => isset($prix) ? (float)$prix : 0,
                    "zone_nom"      => $zone_nom ?? ""
                );

                $parcelles_arr["parcelles"][] = $parcelle_item;
            }

            echo json_encode($parcelles_arr, JSON_UNESCAPED_UNICODE);

        } else {
            echo json_encode(array(
                "success" => false,
                "message" => "Aucune parcelle trouvée pour ce type et cette opération."
            ), JSON_UNESCAPED_UNICODE);
        }

    } else {
        echo json_encode(array(
            "success" => false,
            "message" => "Paramètres manquants (operation_id et type_parcelle_id)."
        ), JSON_UNESCAPED_UNICODE);
    }

} else {
    echo json_encode(array(
        "success" => false,
        "message" => "Action non spécifiée ou non valide."
    ), JSON_UNESCAPED_UNICODE);
}
?>