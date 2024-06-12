<?php
include("../../bd.php");

// Verificar si se recibió un ID válido a través de GET para eliminar una familia
if (isset($_GET['familia_id'])) {
    $familia_id = $_GET['familia_id'];

    // Eliminar la familia
    $sentencia = $conexion->prepare("DELETE FROM familia WHERE id = :id");
    $sentencia->bindParam(":id", $familia_id);
    $sentencia->execute();
    $mensaje = "Familia eliminada";
    header("Location: index.php?mensaje=" . $mensaje); // Redireccionar al índice
    exit(); // Terminar la ejecución del script después de redirigir
}

// Consultar todas las familias
$sentencia = $conexion->prepare("SELECT id, Nfamilia FROM familia"); // Quitamos la columna fecha_clap
$sentencia->execute();
$lista_familias = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../templates/header.php"); ?>
<div class="container mx-auto px-4">
    <h2 class="text-2xl font-bold mb-4">Listado de Familias</h2>
    <!-- Campo de búsqueda -->
    <input type="text" class="border border-gray-300 rounded-md py-2 px-4 mb-4 w-full" id="searchFamilia" placeholder="Buscar por nombre de familia">
    <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block" href="crear.php">Añadir Familia</a>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded my-6">
            <thead>
                <tr>
                    <th class="px-4 py-2 bg-gray-200 border border-gray-400">ID</th>
                    <th class="px-4 py-2 bg-gray-200 border border-gray-400">Nombre de la Familia</th>
                    <th class="px-4 py-2 bg-gray-200 border border-gray-400">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lista_familias as $familia): ?>
                <tr>
                    <td class="px-4 py-2 border border-gray-400"><?php echo $familia['id']; ?></td>
                    <td class="px-4 py-2 border border-gray-400"><?php echo $familia['Nfamilia']; ?></td>
                    <td class="px-4 py-2 border border-gray-400">
                        <a class="btn btn-sm btn-info mr-2" href="ver_miembros.php?familia_id=<?php echo $familia['id']; ?>" role="button">Ver Miembros</a>
                        <a class="btn btn-sm btn-primary mr-2" href="editar.php?familia_id=<?php echo $familia['id']; ?>" role="button">Editar</a>
                        <a class="btn btn-sm btn-danger mr-2" href="index.php?familia_id=<?php echo $familia['id']; ?>&action=delete" role="button">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include("../../templates/fooder.php"); ?>

<script>
    // Función para filtrar las familias por nombre
    document.getElementById('searchFamilia').addEventListener('input', function() {
        var searchValue = this.value.toLowerCase();
        var familias = document.querySelectorAll('tbody tr');
        
        familias.forEach(function(familia) {
            var nombreFamilia = familia.querySelector('td:nth-child(2)').textContent.toLowerCase();
            if (nombreFamilia.indexOf(searchValue) !== -1) {
                familia.style.display = 'table-row';
            } else {
                familia.style.display = 'none';
            }
        });
    });
</script>
