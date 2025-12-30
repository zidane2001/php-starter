<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');


// Autoriser uniquement les requêtes POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Méthode non autorisée'
    ]);
    exit;
}

// Activer le JSON en sortie
header('Content-Type: application/json');

// Inclure la classe Database
require_once __DIR__ . "/config/Database.php";

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Récupérer les données JSON envoyées par fetch
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        throw new Exception("Données JSON invalides");
    }

    // Mapper les champs JS vers les champs DB
    $type_personne      = $data['typePersonne'] ?? null;
    $nom_complet        = $data['nom_complet'] ?? null;
    $telephone          = $data['telephone'] ?? null;
    $date_naissance     = $data['date_naissance'] ?? null;
    $lieu_naissance     = $data['lieu_naissance'] ?? null;
    $profession         = $data['profession'] ?? null;
    $genre              = $data['genre'] ?? null;
    $document           = $data['document'] ?? null;
    $numero_piece       = $data['numero_piece'] ?? null;
    $date_etablissement = $data['date_etablissement'] ?? null;
    $date_expiration    = $data['date_expiration'] ?? null;
    $lieu_etablissement = $data['lieu_etablissement'] ?? null;
    $pays               = $data['pays'] ?? null;
    $region             = $data['region'] ?? null;
    $ville              = $data['ville'] ?? null;
    $adresse            = $data['adresse'] ?? null;

    // Vérification des champs obligatoires
    if (!$type_personne || !$nom_complet || !$telephone) {
        throw new Exception("Champs obligatoires manquants");
    }

    // Préparer la requête SQL
    $stmt = $conn->prepare("
        INSERT INTO identifications (
            type_personne, nom_complet, telephone, date_naissance, lieu_naissance, profession, genre,
            document, numero_piece, date_etablissement, date_expiration, lieu_etablissement,
            pays, region, ville, adresse
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    // Exécuter la requête avec les valeurs
    $stmt->execute([
        $type_personne, $nom_complet, $telephone, $date_naissance, $lieu_naissance,
        $profession, $genre, $document, $numero_piece, $date_etablissement,
        $date_expiration, $lieu_etablissement, $pays, $region, $ville, $adresse
    ]);



if (!$type_personne || !$document) {
    echo json_encode(['success' => false, 'message' => 'Champs obligatoires manquants']);
    exit;
}

    echo json_encode([
        'success' => true,
        'message' => 'Données enregistrées avec succès'
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => "Erreur base de données : " . $e->getMessage()
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => "Erreur : " . $e->getMessage()
    ]);
}

