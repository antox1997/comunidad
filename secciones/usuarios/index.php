<?php
include("../../bd.php");

// Verificar si se recibió un ID válido a través de GET para eliminar un registro
if(isset($_GET['txtID'])) {  
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";

    // Eliminar el usuario
    $sentencia = $conexion->prepare("DELETE FROM libreria_usuarios WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $mensaje = "Registro eliminado";
    header("Location: index.php?mensaje=" . $mensaje);
}

// Consultar todos los usuarios
$sentencia = $conexion->prepare("SELECT * FROM libreria_usuarios");
$sentencia->execute();
$lista_libreria_usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../templates/header.php"); ?>

<div class="bg-gradient-to-br from-purple-200 to-blue-200 py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Usuarios</h2>
            <?php if ($_SESSION['id_cargo'] == 1): ?>
                <a href="crear.php" class="inline-block px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:shadow-outline-green">Crear usuario</a>
            <?php endif; ?>
        </div>
        <div class="border-t border-gray-200 bg-white shadow overflow-hidden sm:rounded-lg">
            <table class="w-full text-md bg-white shadow-md rounded mb-4">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="text-left p-3 px-5">ID</th>
                        <th class="text-left p-3 px-5">Nombre del usuario</th>
                        <th class="text-left p-3 px-5">Contraseña</th>
                        <th class="text-left p-3 px-5">Correo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_libreria_usuarios as $registro): ?>
                    <tr class="border-b hover:bg-orange-100 bg-gray-100">
                        <td class="p-3 px-5"><?php echo $registro['id']; ?></td>
                        <td class="p-3 px-5"><?php echo $registro['usuario']; ?></td>
                        <td class="p-3 px-5">***</td>
                        <td class="p-3 px-5"><?php echo $registro['correo']; ?></td>
                        <td class="p-3 px-5 flex justify-end">
                            <div class="inline-block space-x-2">
                                <?php if ($_SESSION['id_cargo'] == 1): ?>
                                    <a href="editar.php?txtID=<?php echo $registro['id']; ?>" class="inline-block px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:shadow-outline-indigo">Editar</a>
                                    <a href="javascript:borrar(<?php echo $registro['id']; ?>);" class="inline-block px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:shadow-outline-red">Eliminar</a>
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
</script>
