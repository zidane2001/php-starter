<?php
class TypeParcelle {
    private $conn;
    private $table_name = "type_parcelle";

    public $id;
    public $nom;
    public $description;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer tous les types de parcelles (uniques)
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>
