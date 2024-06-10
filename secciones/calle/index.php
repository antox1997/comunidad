<?php
include("../../bd.php");

// Verificar si se recibió un ID válido a través de GET para eliminar un registro
if(isset($_GET['txtID'])) {  
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";

    // Eliminar la calle
    $sentencia = $conexion->prepare("DELETE FROM libreria_calle WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $mensaje = "Registro eliminado";
    header("Location: index.php?mensaje=" . $mensaje);
}

// Consultar todas las calles
$sentencia = $conexion->prepare("SELECT * FROM libreria_calle");
$sentencia->execute();
$lista_libreria_calles = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../templates/header.php"); ?>


<div class="bg-gradient-to-br from-purple-200 to-blue-200 py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Calles</h2>
            <?php if ($_SESSION['id_cargo'] == 1): ?>
                <a href="crear.php" class="inline-block px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:shadow-outline-green">Crear calle</a>
            <?php endif; ?>
        </div>
        <!-- Agregar buscador -->
        <div class="mb-4 flex items-center justify-end">
            <input type="text" id="searchInput" placeholder="Buscar calle..." class="block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
        <!-- Fin del buscador -->
        <div class="border-t border-gray-200 bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre de la calle</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="searchTable">
                    <?php foreach ($lista_libreria_calles as $calle): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $calle['id']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo $calle['nombreCalle']; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="inline-block space-x-2">
                                    <?php if ($_SESSION['id_cargo'] == 1): ?>
                                        <a href="editar.php?txtID=<?php echo $calle['id']; ?>" class="inline-block px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:shadow-outline-indigo">Editar</a>
                                        <a href="javascript:borrar(<?php echo $calle['id']; ?>);" class="inline-block px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:shadow-outline-red">Eliminar</a>
                                    <?php else: ?>
                                        <button class="inline-block px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-indigo-600 border border-transparent rounded-md shadow-sm" onclick="showPermissionDenied()">Editar</button>
                                        <button class="inline-block px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md shadow-sm" onclick="showPermissionDenied()">Eliminar</button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("../../templates/fooder.php"); ?>

<script>
    function showPermissionDenied() {
        Swal.fire({
            icon: 'error',
            title: 'Acción no permitida',
            text: 'No tienes permiso para realizar esta acción. Por favor, contacta a un administrador.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Entendido'
        });
    }

    // Función para filtrar la tabla según el texto de búsqueda
    document.getElementById('searchInput').addEventListener('input', function() {
        var searchText = this.value.toLowerCase();
        var rows = document.querySelectorAll('#searchTable tr');

        rows.forEach(function(row) {
            var cells = row.querySelectorAll('td');
            var found = false;
            cells.forEach(function(cell) {
                var cellText = cell.textContent.toLowerCase();
                if (cellText.indexOf(searchText) !== -1) {
                    found = true;
                }
            });
            if (found) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
