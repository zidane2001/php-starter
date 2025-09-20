<?php
class Parcelle {
    private $conn;
    private $table_name = "parcelles";

    // Propriétés
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

    /**
     * Lire les parcelles par type et opération
     */
     public function readByType($operation_id, $type_parcelle_id) {
        $query = "
            SELECT 
                p.id, p.section, p.lot, p.parcelle, p.surface, 
                p.cout_unitaire, p.prix, p.statut, p.type_parcelle_id, 
                p.zone_id, z.nom AS zone_nom
            FROM parcelles p
            LEFT JOIN zones z ON p.zone_id = z.id
            WHERE p.type_parcelle_id = :type_parcelle_id
              AND p.statut = 'disponible'
              AND EXISTS (
                  SELECT 1 
                  FROM type_parcelle tp
                  WHERE tp.id = p.type_parcelle_id
                  AND tp.operation_id =:operation_id
              )
        ";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize and bind parameters
        $operation_id = htmlspecialchars(strip_tags($operation_id));
        $type_parcelle_id = htmlspecialchars(strip_tags($type_parcelle_id));
        
        $stmt->bindParam(":operation_id", $operation_id, PDO::PARAM_INT);
        $stmt->bindParam(":type_parcelle_id", $type_parcelle_id, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt;
    }

    /**
     * Mettre à jour le statut d'une parcelle
     */
    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table_name . " 
                  SET statut = :statut 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":statut", $status, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
?>
