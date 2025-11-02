<?php
require 'conexion.php';

if (!isset($_GET['bodega_id'])) {
    echo json_encode(["error" => "No se recibió el ID de la bodega"]);
    exit;
}

$bodega_id = intval($_GET['bodega_id']);

try {
    $stmt = $pdo->prepare("
        SELECT s.id, s.nombre AS sucursal, b.nombre AS bodega
        FROM sucursales s
        JOIN bodega b ON s.id_bodega = b.id
        WHERE s.id_bodega = :id_bodega
        ORDER BY s.nombre
    ");
    $stmt->bindParam(':id_bodega', $bodega_id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>