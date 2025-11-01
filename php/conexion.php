<?php
header('Content-Type: application/json; charset=utf-8');

try {
    // Conexión PostgreSQL
    $pdo = new PDO("pgsql:host=localhost;dbname=inventario", "postgres", "pablito123");

    // Configurar modo de errores y codificación
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'utf8'");
    
} catch (PDOException $e) {
    // Si falla la conexión, se devuelve un JSON con el error
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()]);
    exit;
}
?>
