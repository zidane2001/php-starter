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

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode([
        "success" => false,
        "message" => "Accès non autorisé",
        "authenticated" => false
    ]);
    http_response_code(401);
    exit();
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action === 'check') {
    // Vérifier le statut de connexion
    echo json_encode([
        "success" => true,
        "authenticated" => true,
        "user" => [
            "username" => $_SESSION['admin_username'] ?? 'Admin',
            "login_time" => $_SESSION['admin_login_time'] ?? null
        ]
    ]);

} elseif ($action === 'logout') {
    // Déconnexion
    $_SESSION = array();
    session_destroy();

    echo json_encode([
        "success" => true,
        "message" => "Déconnexion réussie"
    ]);

} else {
    echo json_encode([
        "success" => false,
        "message" => "Action non valide"
    ]);
}
?>