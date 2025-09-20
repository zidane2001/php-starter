<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../models/Operation.php';
include_once '../models/TypeParcelle.php';

$database = new Database();
$db = $database->getConnection();

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'get_types_parcelles') {
    $operation_id = isset($_GET['id']) ? $_GET['id'] : '';
    
    if (!empty($operation_id)) {
        $typeParcelle = new TypeParcelle($db);
        $stmt = $typeParcelle->readByOperation($operation_id);
        $num = $stmt->rowCount();
        
        if ($num > 0) {
            $types_arr = array();
            $types_arr["types"] = array();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $type_item = array(
                    "id" => $id,
                    "nom" => $nom,
                    "description" => $description,
                    "operation_id" => $operation_id
                );
                array_push($types_arr["types"], $type_item);
            }
            
            $types_arr["success"] = true;
            echo json_encode($types_arr);
        } else {
            echo json_encode(array(
                "success" => false,
                "message" => "Aucun type de parcelle trouvé pour cette opération.".$operation_id
            ));
        }
    } else {
        echo json_encode(array(
            "success" => false,
            "message" => "ID d'opération manquant."
        ));
    }
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "Action non spécifiée ou non valide."
    ));
}
?>