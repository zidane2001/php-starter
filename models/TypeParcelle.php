<?php
class TypeParcelle {
    private $conn;
    private $table_name = "type_parcelle";

    public $id;
    public $nom;
    public $description;
    public $operation_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readByOperation($operation_id) {
        if (empty($operation_id)) {
            return null;
        }
        $query = "SELECT * FROM " . $this->table_name . " WHERE operation_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $operation_id);
        $stmt->execute();
        return $stmt;
    }
}
?>