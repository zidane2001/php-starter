<?php
// API pour la gestion des paiements côté administrateur
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

include_once '../config/Database.php';

$database = new Database();
$db = $database->getConnection();

$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'update_status':
            $id = $_POST['id'] ?? '';
            $status = $_POST['status'] ?? '';

            if (empty($id) || empty($status)) {
                echo json_encode(['success' => false, 'message' => 'ID et statut requis']);
                exit;
            }

            $stmt = $db->prepare("UPDATE paiements SET statut = ? WHERE id = ?");
            $stmt->execute([$status, $id]);

            echo json_encode(['success' => true, 'message' => 'Statut mis à jour']);
            break;

        case 'get_details':
            $id = $_POST['id'] ?? '';

            if (empty($id)) {
                echo json_encode(['success' => false, 'message' => 'ID requis']);
                exit;
            }

            $stmt = $db->prepare("SELECT * FROM paiements WHERE id = ?");
            $stmt->execute([$id]);
            $payment = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($payment) {
                echo json_encode(['success' => true, 'payment' => $payment]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Paiement non trouvé']);
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Action non valide']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur: ' . $e->getMessage()]);
}
?>