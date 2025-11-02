<?php
require 'conexion.php';

try {
    $stmt = $pdo->query("SELECT id, nombre FROM bodega ORDER BY nombre");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>