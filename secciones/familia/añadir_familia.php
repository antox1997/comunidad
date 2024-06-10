<?php
include("../../bd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se proporciona un ID de familia para determinar si se está creando una nueva familia o editando una existente
    $familia_id = $_POST['familia_id'] ?? null;

    // Obtener los datos del formulario
    $Nfamilia = $_POST['Nfamilia'];
    $miembros = $_POST['miembros'];

    if ($familia_id) {
        // Actualizar la familia existente
        $sentencia = $conexion->prepare("UPDATE familia SET Nfamilia = :Nfamilia WHERE id = :familia_id");
        $sentencia->bindParam(':Nfamilia', $Nfamilia);
        $sentencia->bindParam(':familia_id', $familia_id);
        $sentencia->execute();

        // Eliminar los miembros existentes de la familia
        $sentencia_eliminar_miembros = $conexion->prepare("DELETE FROM miembros_familia WHERE familia_id = :familia_id");
        $sentencia_eliminar_miembros->bindParam(':familia_id', $familia_id);
        $sentencia_eliminar_miembros->execute();
    } else {
        // Insertar la nueva familia
        $sentencia = $conexion->prepare("INSERT INTO familia (Nfamilia) VALUES (:Nfamilia)");
        $sentencia->bindParam(':Nfamilia', $Nfamilia);
        $sentencia->execute();
        $familia_id = $conexion->lastInsertId();
    }

    // Insertar los miembros de la familia
    foreach ($miembros as $ciudadano_id) {
        $sentencia = $conexion->prepare("INSERT INTO miembros_familia (familia_id, ciudadano_id) VALUES (:familia_id, :ciudadano_id)");
        $sentencia->bindParam(':familia_id', $familia_id);
        $sentencia->bindParam(':ciudadano_id', $ciudadano_id);
        $sentencia->execute();
    }

    // Redireccionar al índice de la familia con el mensaje de éxito
    header('Location: index.php?mensaje=guardado');
    exit();
} else {
    // Si el método de solicitud no es POST, redireccionar a la página de inicio
    header('Location: index.php');
    exit();
}
?>
