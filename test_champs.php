<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(['success'=>false,'message'=>'Pas de données reçues']);
    exit;
}

echo json_encode(['success'=>true,'message'=>'POST reçu','data'=>$data]);

