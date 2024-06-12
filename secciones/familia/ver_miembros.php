<?php
include("../../bd.php");

if (isset($_GET['familia_id'])) {
    $familia_id = $_GET['familia_id'];

    // Obtener el nombre de la familia
    $sentencia_familia = $conexion->prepare("SELECT Nfamilia FROM familia WHERE id = :familia_id");
    $sentencia_familia->bindParam(":familia_id", $familia_id);
    $sentencia_familia->execute();
    $familia = $sentencia_familia->fetch(PDO::FETCH_ASSOC);

    // Obtener los miembros de la familia
    $sentencia_miembros = $conexion->prepare("SELECT libreria_ciudadano.nombre, libreria_ciudadano.apellido, libreria_ciudadano.cedu
                                              FROM miembros_familia 
                                              INNER JOIN libreria_ciudadano ON miembros_familia.ciudadano_id = libreria_ciudadano.id 
                                              WHERE miembros_familia.familia_id = :familia_id");
    $sentencia_miembros->bindParam(":familia_id", $familia_id);
    $sentencia_miembros->execute();
    $miembros = $sentencia_miembros->fetchAll(PDO::FETCH_ASSOC);

} else {
    // Redireccionar si no se proporciona el ID de la familia
    header('Location: index.php');
    exit();
}
?>

<?php include("../../templates/header.php"); ?>
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-4">Miembros de la Familia: <strong class="text-purple-600"><?php echo $familia['Nfamilia']; ?></strong></h2>
    <?php if (count($miembros) > 0): ?>
    <div class="overflow-x-auto bg-white shadow-md rounded-lg mb-8">
        <table class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apellido</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cédula</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($miembros as $miembro): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $miembro['nombre']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $miembro['apellido']; ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $miembro['cedu']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="historial.php?familia_id=<?php echo $familia_id; ?>" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Ver Historial</a>
    <?php else: ?>
    <p class="mt-4 text-gray-600">No hay miembros registrados en esta familia.</p>
    <?php endif; ?>
    <a href="index.php" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Volver a la lista de familias</a>
</div>
<?php include("../../templates/fooder.php"); ?>
