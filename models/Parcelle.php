<?php
class Parcelle {
    private $conn;
    private $table_name = "parcelles";

    public $id;
    public $section;
    public $lot;
    public $parcelle;
    public $surface;
    public $cout_unitaire;
    public $prix;
    public $type_parcelle_id;
    public $zone_id;
    public $statut;
    public $zone_nom;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lire toutes les parcelles disponibles ou par type
    public function readByType($type_parcelle_id = null) {
        $query = "
            SELECT 
                p.id, p.section, p.lot, p.parcelle, p.surface, 
                p.cout_unitaire, p.prix, p.statut, p.type_parcelle_id, 
                p.zone_id, z.nom AS zone_nom
            FROM parcelles p
            LEFT JOIN zones z ON p.zone_id = z.id
            WHERE p.statut = 'disponible'
        ";

        if ($type_parcelle_id !== null) {
            $query .= " AND p.type_parcelle_id = :type_parcelle_id";
        }

        $stmt = $this->conn->prepare($query);

        if ($type_parcelle_id !== null) {
            $stmt->bindParam(":type_parcelle_id", $type_parcelle_id, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt;
    }

    // Mettre à jour le statut
    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table_name . " 
                  SET statut = :statut 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":statut", $status, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Vérifier le timer de la parcelle
    public function verifierTimer($id, $session_id = null) {
        $query = "SELECT id, parcelle, statut, 
                         TIMESTAMPDIFF(SECOND, NOW(), date_expiration) AS remaining_time
                  FROM " . $this->table_name . "
                  WHERE id = :id
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return [
                "id" => $row['id'],
                "parcelle" => $row['parcelle'],
                "statut" => $row['statut'],
                "remaining_time" => max(0, (int)$row['remaining_time'])
            ];
        }
        return false;
    }
}
?>
