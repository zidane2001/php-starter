<?php
// Allow CORS and preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
    header("Access-Control-Max-Age: 86400");
    http_response_code(200);
    exit();
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include Database and Parcelle model
include_once '../config/Database.php';
include_once '../models/Parcelle.php';

// Connect to database
$database = new Database();
$db = $database->getConnection();
$parcelle = new Parcelle($db);

// Get action
$action = $_GET['action'] ?? '';

try {

    switch ($action) {

        case 'get_parcelles_by_type':
            $type_id = isset($_GET['type_id']) ? intval($_GET['type_id']) : null;
            $stmt = $parcelle->readByType($type_id);
            $num = $stmt->rowCount();

            $parcelles_arr = ["success" => true, "parcelles" => []];

            if ($num > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $parcelle_item = [
                        "id"            => $id,
                        "section"       => $section,
                        "lot"           => $lot,
                        "parcelle"      => $parcelle,
                        "surface"       => isset($surface) ? (float)$surface : 0,
                        "cout_unitaire" => isset($cout_unitaire) ? (float)$cout_unitaire : 0,
                        "prix"          => isset($prix) ? (float)$prix : 0,
                        "zone_nom"      => $zone_nom ?? ""
                    ];
                    $parcelles_arr["parcelles"][] = $parcelle_item;
                }
            }

            echo json_encode($parcelles_arr, JSON_UNESCAPED_UNICODE);
            break;

        case 'verifier_timer_parcelle':
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $session_id = $_GET['session_id'] ?? '';

            if ($id <= 0) {
                echo json_encode(["success" => false, "message" => "ID de parcelle invalide."]);
                exit;
            }

            if (!method_exists($parcelle, 'verifierTimer')) {
                echo json_encode(["success" => false, "message" => "Méthode verifierTimer non définie."]);
                exit;
            }

            // Call verifierTimer and ensure it returns structured array
            $result = $parcelle->verifierTimer($id, $session_id);

            // Example of expected result: ['time_expired' => false, 'remaining_time' => 900, 'other_session' => false]
            if (is_array($result)) {
                echo json_encode(array_merge(["success" => true], $result), JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(["success" => false, "message" => "La vérification a échoué."], JSON_UNESCAPED_UNICODE);
            }

            break;

        default:
            echo json_encode(["success" => false, "message" => "Action non spécifiée ou non valide."], JSON_UNESCAPED_UNICODE);
            break;
    }

} catch (\Throwable $e) {
    echo json_encode(["success" => false, "message" => "Erreur serveur: " . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
?>
