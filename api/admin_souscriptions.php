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

// Vérification de la session admin
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode([
        "success" => false,
        "message" => "Accès non autorisé"
    ]);
    http_response_code(401);
    exit();
}

// Include database connection
include_once '../config/Database.php';

$database = new Database();
$db = $database->getConnection();

try {
    $action = $_POST['action'] ?? $_GET['action'] ?? '';

    if ($action === 'get_all') {
        // Récupération de toutes les souscriptions avec pagination
        $page = intval($_GET['page'] ?? 1);
        $limit = intval($_GET['limit'] ?? 20);
        $offset = ($page - 1) * $limit;

        $status_filter = $_GET['status'] ?? '';
        $search = $_GET['search'] ?? '';

        // Construction de la requête
        $where_conditions = [];
        $params = [];

        if ($status_filter) {
            switch ($status_filter) {
                case 'complete':
                    $where_conditions[] = "p.statut = 'valide'";
                    break;
                case 'en_cours':
                    $where_conditions[] = "p.statut = 'en_attente'";
                    break;
                case 'sans_paiement':
                    $where_conditions[] = "(p.statut IS NULL OR p.statut = '')";
                    break;
            }
        }

        if ($search) {
            $where_conditions[] = "(o.intitule LIKE :search OR o.localite LIKE :search OR
                                   JSON_EXTRACT(o.identification, '$.nom_complet') LIKE :search OR
                                   JSON_EXTRACT(o.identification, '$.raison_sociale') LIKE :search OR
                                   JSON_EXTRACT(o.identification, '$.telephone') LIKE :search)";
            $params[':search'] = "%$search%";
        }

        $where_clause = $where_conditions ? "WHERE " . implode(" AND ", $where_conditions) : "";

        // Compter le total
        $count_stmt = $db->prepare("
            SELECT COUNT(DISTINCT o.id) as total
            FROM operations o
            LEFT JOIN paiements p ON o.id = p.operation_id
            $where_clause
        ");

        foreach ($params as $key => $value) {
            $count_stmt->bindValue($key, $value);
        }
        $count_stmt->execute();
        $total = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Récupérer les souscriptions
        $stmt = $db->prepare("
            SELECT o.*,
                   p.statut as paiement_statut,
                   CASE
                       WHEN p.statut = 'valide' THEN 'complete'
                       WHEN p.statut = 'en_attente' THEN 'en_cours'
                       WHEN p.statut IS NULL OR p.statut = '' THEN 'sans_paiement'
                       ELSE 'autre'
                   END as status_group,
                   parc.zone, parc.section, parc.lot, parc.parcelle, parc.surface, parc.prix, parc.acompte, parc.reste_a_payer,
                   JSON_EXTRACT(o.identification, '$.nom_complet') as nom_complet,
                   JSON_EXTRACT(o.identification, '$.raison_sociale') as raison_sociale,
                   JSON_EXTRACT(o.identification, '$.telephone') as telephone,
                   JSON_EXTRACT(o.identification, '$.typePersonne') as type_personne
            FROM operations o
            LEFT JOIN paiements p ON o.id = p.operation_id
            LEFT JOIN parcelles parc ON o.id = parc.operation_id
            $where_clause
            GROUP BY o.id
            ORDER BY o.date_creation DESC
            LIMIT :limit OFFSET :offset
        ");

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $souscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            "success" => true,
            "souscriptions" => $souscriptions,
            "total" => $total,
            "page" => $page,
            "limit" => $limit,
            "total_pages" => ceil($total / $limit)
        ]);

    } elseif ($action === 'get_details') {
        $id = $_GET['id'] ?? '';

        if (!$id) {
            echo json_encode([
                "success" => false,
                "message" => "ID de l'opération requis"
            ]);
            exit;
        }

        // Récupérer les informations de l'opération
        $stmt = $db->prepare("
            SELECT o.*,
                   JSON_EXTRACT(o.identification, '$.nom_complet') as nom_complet,
                   JSON_EXTRACT(o.identification, '$.raison_sociale') as raison_sociale,
                   JSON_EXTRACT(o.identification, '$.telephone') as telephone,
                   JSON_EXTRACT(o.identification, '$.email') as email,
                   JSON_EXTRACT(o.identification, '$.pays') as pays,
                   JSON_EXTRACT(o.identification, '$.document') as document,
                   JSON_EXTRACT(o.identification, '$.numero_piece') as numero_piece,
                   JSON_EXTRACT(o.identification, '$.rccm') as rccm,
                   JSON_EXTRACT(o.identification, '$.typePersonne') as type_personne
            FROM operations o
            WHERE o.id = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $operation = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$operation) {
            echo json_encode([
                "success" => false,
                "message" => "Opération non trouvée"
            ]);
            exit;
        }

        // Récupérer la parcelle associée
        $stmt = $db->prepare("SELECT * FROM parcelles WHERE operation_id = :operation_id");
        $stmt->bindParam(':operation_id', $id);
        $stmt->execute();
        $parcelle = $stmt->fetch(PDO::FETCH_ASSOC);

        // Récupérer les paiements associés
        $stmt = $db->prepare("SELECT * FROM paiements WHERE operation_id = :operation_id ORDER BY date_transaction DESC");
        $stmt->bindParam(':operation_id', $id);
        $stmt->execute();
        $paiements = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = $operation;
        if ($parcelle) {
            $result['parcelle'] = $parcelle;
        }
        if ($paiements) {
            $result['paiements'] = $paiements;
        }

        echo json_encode([
            "success" => true,
            "souscription" => $result
        ]);

    } elseif ($action === 'get_stats') {
        // Statistiques détaillées des souscriptions
        $stats = [];

        // Souscriptions par statut
        $stmt = $db->query("
            SELECT
                CASE
                    WHEN p.statut = 'valide' THEN 'complete'
                    WHEN p.statut = 'en_attente' THEN 'en_cours'
                    WHEN p.statut IS NULL OR p.statut = '' THEN 'sans_paiement'
                    ELSE 'autre'
                END as status_group,
                COUNT(DISTINCT o.id) as count
            FROM operations o
            LEFT JOIN paiements p ON o.id = p.operation_id
            GROUP BY status_group
        ");
        $stats['by_status'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Évolution mensuelle des souscriptions
        $stmt = $db->query("
            SELECT DATE_FORMAT(date_creation, '%Y-%m') as month,
                   COUNT(*) as count
            FROM operations
            GROUP BY DATE_FORMAT(date_creation, '%Y-%m')
            ORDER BY month DESC
            LIMIT 12
        ");
        $stats['monthly'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Top localités
        $stmt = $db->query("
            SELECT localite, COUNT(*) as count
            FROM operations
            GROUP BY localite
            ORDER BY count DESC
            LIMIT 10
        ");
        $stats['top_localites'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Montant total des souscriptions
        $stmt = $db->query("SELECT SUM(montant_souscription) as total FROM operations");
        $stats['total_montant'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        echo json_encode([
            "success" => true,
            "stats" => $stats
        ]);

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