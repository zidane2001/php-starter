<?php
// Allow CORS and preflight
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

// Include database connection
include_once '../config/Database.php';

$database = new Database();
$db = $database->getConnection();

try {
    $action = $_POST['action'] ?? '';

    if ($action === 'enregistrer_paiement') {
        $id = $_POST['id'] ?? 'P-AUTO-' . time();
        $operation_id = intval($_POST['operation_id'] ?? 0);
        $parcelle_id = intval($_POST['parcelle_id'] ?? 0);
        $methode = $_POST['methode'] ?? '';
        $telephone = $_POST['telephone'] ?? '';
        $numero_transaction = $_POST['numero_transaction'] ?? '';
        $date_transaction = $_POST['date_transaction'] ?? date('Y-m-d');
        $confirmation_code = $_POST['confirmation_code'] ?? '';
        $montant = floatval($_POST['montant'] ?? 0);
        $identification = $_POST['identification'] ?? '{}';

        if ($operation_id <= 0 || $parcelle_id <= 0) {
            echo json_encode([
                "success" => false,
                "message" => "Operation ID ou Parcelle ID invalide."
            ]);
            exit;
        }

        $stmt = $db->prepare("
            INSERT INTO paiements
            (id, operation_id, parcelle_id, methode, telephone, numero_transaction, date_transaction, confirmation_code, montant, identification)
            VALUES
            (:id, :operation_id, :parcelle_id, :methode, :telephone, :numero_transaction, :date_transaction, :confirmation_code, :montant, :identification)
        ");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':operation_id', $operation_id);
        $stmt->bindParam(':parcelle_id', $parcelle_id);
        $stmt->bindParam(':methode', $methode);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':numero_transaction', $numero_transaction);
        $stmt->bindParam(':date_transaction', $date_transaction);
        $stmt->bindParam(':confirmation_code', $confirmation_code);
        $stmt->bindParam(':montant', $montant);
        $stmt->bindParam(':identification', $identification);

        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "paiement_id" => $id,
                "souscription_id" => $operation_id,
                "message" => "Paiement enregistré avec succès."
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Erreur lors de l'enregistrement du paiement."
            ]);
        }

    } else {
        echo json_encode([
            "success" => false,
            "message" => "Action non spécifiée ou non valide."
        ]);
    }

} catch (\Throwable $e) {
    echo json_encode([
        "success" => false,
        "message" => "Erreur serveur: " . $e->getMessage()
    ]);
}
?>
