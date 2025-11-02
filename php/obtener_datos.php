<?php
require 'conexion.php';

$accion = isset($_GET['accion']) ? $_GET['accion'] : '';

header('Content-Type: application/json');

try {
    if ($accion === 'bodegas') {
        // Obtener bodegas
        $stmt = $pdo->query("SELECT id, nombre FROM bodega ORDER BY nombre");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

    } elseif ($accion === 'monedas') {
        // Obtener monedas
        $stmt = $pdo->query("SELECT id, codigo FROM moneda ORDER BY codigo ASC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

    } elseif ($accion === 'sucursales') {
        // Obtener sucursales de una bodega específica
        if (!isset($_GET['bodega_id'])) {
            echo json_encode(["error" => "No se recibió el ID de la bodega"]);
            exit;
        }
        $bodega_id = intval($_GET['bodega_id']);
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

    } else {
        echo json_encode(["error" => "Acción no válida"]);
    }

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
