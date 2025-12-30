<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Réponse rapide au pré-flight
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    header("Access-Control-Max-Age: 86400");
    http_response_code(200);
    exit();
}
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../models/Operation.php';
include_once '../models/TypeParcelle.php';

// Connexion à la base
$database = new Database();
$db = $database->getConnection();

// Action demandée
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'get_types_parcelles') {
    $typeParcelle = new TypeParcelle($db);
    $stmt = $typeParcelle->readAll();
    $num = $stmt->rowCount();
    
    if ($num > 0) {
        $types_arr = array();
        $types_arr["types"] = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $type_item = array(
                "id" => $id,
                "nom" => $nom,
                "description" => $description
            );
            array_push($types_arr["types"], $type_item);
        }
        
        $types_arr["success"] = true;
        echo json_encode($types_arr, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(array(
            "success" => false,
            "message" => "Aucun type de parcelle trouvé."
        ), JSON_UNESCAPED_UNICODE);
    }
} else {
    echo json_encode(array(
        "success" => false,
        "message" => "Action non spécifiée ou non valide."
    ), JSON_UNESCAPED_UNICODE);
}
?>
