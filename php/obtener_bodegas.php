<?php
require 'conexion.php';

try {
    $pdo = new PDO("pgsql:host=localhost;dbname=inventario", "postgres", "pablito123");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT id, nombre FROM bodega ORDER BY nombre");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
