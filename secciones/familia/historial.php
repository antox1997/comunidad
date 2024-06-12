<?php
include("../../bd.php");

if(isset($_GET['familia_id'])){
    $familia_id = $_GET['familia_id'];

    // Obtener el nombre de la familia
    $sentencia_familia = $conexion->prepare("SELECT Nfamilia FROM familia WHERE id = :familia_id");
    $sentencia_familia->bindParam(":familia_id", $familia_id);
    $sentencia_familia->execute();
    $familia = $sentencia_familia->fetch(PDO::FETCH_ASSOC);

    // Obtener historial de la familia
    $sentencia_historial = $conexion->prepare("SELECT * FROM historial_familia WHERE familia_id = :familia_id ORDER BY fecha DESC");
    $sentencia_historial->bindParam(":familia_id", $familia_id);
    $sentencia_historial->execute();
    $historial = $sentencia_historial->fetchAll(PDO::FETCH_ASSOC);

} else {
    // Redireccionar si no se proporciona el ID de la familia
    header('Location: index.php');
    exit();
}
?>

<?php include("../../templates/header.php"); ?>
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-4">Historial : <strong class="text-purple-600"><?php echo htmlspecialchars($familia['Nfamilia'], ENT_QUOTES, 'UTF-8'); ?></strong></h2>
    
    <!-- Mostrar historial en una tabla -->
    <div class="mb-8">
        <table class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Inicial</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Beneficios</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($historial as $registro): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $registro['descripcion']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $registro['fecha']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php 
                        // Obtener beneficios para este historial
                        $sentencia_beneficios = $conexion->prepare("SELECT * FROM beneficios_familia WHERE historial_id = :historial_id");
                        $sentencia_beneficios->bindParam(":historial_id", $registro['id']);
                        $sentencia_beneficios->execute();
                        $beneficios = $sentencia_beneficios->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <ul>
                            <?php foreach ($beneficios as $beneficio): ?>
                            <li><?php echo $beneficio['beneficio']; ?> (<?php echo $beneficio['fecha']; ?>)</li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Botón para añadir nuevo historial -->
    <div class="mb-4">
        <a href="añadir_historia.php?familia_id=<?php echo $familia_id; ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Añadir Historia</a>
    </div>

    <a href="ver_miembros.php?familia_id=<?php echo $familia_id; ?>" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Volver a los miembros de la familia</a>
</div>
<?php include("../../templates/fooder.php"); ?>
