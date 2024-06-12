<?php
// Incluimos el archivo de conexión a la base de datos
include("../../bd.php");

// Si se ha enviado el parámetro del ID a través de la URL
if(isset($_GET['txtID'])){  
    // Obtenemos el ID del ciudadano a partir de la URL
    $txtID = $_GET['txtID'];

    // Preparamos y ejecutamos la consulta para obtener los datos del ciudadano con ese ID
    $sentencia = $conexion->prepare("SELECT * FROM libreria_ciudadano WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    // Extraemos los datos del ciudadano y los guardamos en variables
    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
    $nombre = $registro["nombre"];
    $apellido = $registro["apellido"];
    $cedu = $registro["cedu"];
    $N_tlf = $registro["N_tlf"];
    $foto = $registro["foto"];
    $acotaciones = $registro["acotaciones"];
    $idcalle = $registro["idcalle"];

    // Preparamos y ejecutamos la consulta para obtener el nombre de la calle
    $sentencia = $conexion->prepare("SELECT nombreCalle FROM libreria_calle WHERE id = :id");
    $sentencia->bindParam(":id", $idcalle);
    $sentencia->execute();
    $calle = $sentencia->fetch(PDO::FETCH_ASSOC)['nombreCalle'];
}
?>

<?php include("../../templates/header.php"); ?>
<div class="bg-gradient-to-br from-purple-200 to-blue-200 py-8">
    <div class="container mx-auto px-4 mt-8">
        <div class="card">
            <div class="card-header">
                <h2 class="text-2xl font-semibold text-gray-800">Información del ciudadano</h2>
            </div>
            <div class="card-body">
                <table class="min-w-full bg-white">
                    <tbody>
                        <tr>
                            <td class="border px-4 py-2 font-semibold">Nombre:</td>
                            <td class="border px-4 py-2"><?php echo $nombre; ?></td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2 font-semibold">Apellido:</td>
                            <td class="border px-4 py-2"><?php echo $apellido; ?></td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2 font-semibold">Cédula:</td>
                            <td class="border px-4 py-2"><?php echo $cedu; ?></td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2 font-semibold">Teléfono:</td>
                            <td class="border px-4 py-2"><?php echo $N_tlf; ?></td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2 font-semibold">Calle:</td>
                            <td class="border px-4 py-2"><?php echo $calle; ?></td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2 font-semibold">Foto:</td>
                            <td class="border px-4 py-2">
                                <?php if (!empty($foto)): ?>
                                    <img width="100" src="../../libreria/<?php echo $foto; ?>" class="img-fluid rounded" alt="Foto" />
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="border px-4 py-2 font-semibold">Acotaciones (PDF):</td>
                            <td class="border px-4 py-2">
                                <a href="../../libreria/<?php echo $acotaciones; ?>" download class="btn btn-primary">Descargar Acotaciones</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Botón para volver al índice -->
                <div class="mt-4">
                    <a name="" id="" class="btn btn-primary" href="index.php" role="button">Volver</a>
                </div>
            </div>
            <div class="card-footer text-muted"></div>
        </div>
    </div>
</div>

<?php include("../../templates/fooder.php"); ?>
