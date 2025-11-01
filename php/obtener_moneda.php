<?php
require 'conexion.php';

try {
    $stmt = $pdo->query("SELECT id, codigo FROM moneda ORDER BY codigo ASC");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>