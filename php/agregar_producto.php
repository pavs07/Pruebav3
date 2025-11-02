<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $codigo = trim($_POST["codigo"]);
    $nombre = trim($_POST["nombre"]);
    $precio = $_POST["precio"];
    $descripcion = trim($_POST["descripcion"]);
    $moneda = $_POST["moneda"];
    $bodega_id = $_POST["bodega"];
    $materiales = isset($_POST["materiales"]) ? implode(", ", $_POST["materiales"]) : "";
    $sucursal_id = $_POST["sucursal"];

    try {
        $pdo = new PDO("pgsql:host=localhost;dbname=inventario", "postgres", "pablito123");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar si el código ya existe
        $check = $pdo->prepare("SELECT COUNT(*) FROM producto WHERE codigo = :codigo");
        $check->execute([':codigo' => $codigo]);
        if ($check->fetchColumn() > 0) {
            echo json_encode(["status" => "error", "mensaje" => "El código del producto ya está registrado."]);
            exit;
        }

        //Obtener los nombres de bodega y sucursal según sus IDs
        $stmtBodega = $pdo->prepare("SELECT nombre FROM bodega WHERE id = :id");
        $stmtBodega->execute([':id' => $bodega_id]);
        $nombreBodega = $stmtBodega->fetchColumn();
        $stmtSucursal = $pdo->prepare("SELECT nombre FROM sucursales WHERE id = :id");
        $stmtSucursal->execute([':id' => $sucursal_id]);
        $nombreSucursal = $stmtSucursal->fetchColumn();

        if (!$nombreBodega || !$nombreSucursal) {
            echo json_encode(["status" => "error", "mensaje" => "Error al obtener nombres de bodega o sucursal."]);
            exit;
        }

        //Insertar producto 
        $sql = "INSERT INTO producto 
                (codigo, nombre, precio, moneda, bodega, sucursal,  materiales ,descripcion)
                VALUES (:codigo, :nombre, :precio, :moneda, :bodega, :sucursal,  :materiales,:descripcion)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':codigo' => $codigo,
            ':nombre' => $nombre,
            ':precio' => $precio,
            ':moneda' => $moneda,
            ':bodega' => $nombreBodega,
            ':sucursal' => $nombreSucursal,
            ':materiales' => $materiales,
            ':descripcion' => $descripcion
        ]);

        echo json_encode(["status" => "ok", "mensaje" => "Producto agregado correctamente."]);

    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "mensaje" => "Error en la base de datos: " . $e->getMessage()]);
    }
}
?>
