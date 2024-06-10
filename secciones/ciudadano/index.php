<?php 
include("../../bd.php");

if(isset($_GET['txtID'])){  
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";

    $sentencia = $conexion->prepare("SELECT foto, acotaciones FROM libreria_ciudadano WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro_recuperado = $sentencia->fetch(PDO::FETCH_ASSOC);

    if(isset($registro_recuperado["foto"]) && $registro_recuperado["foto"] != "") {
        if(file_exists("./".$registro_recuperado["foto"])) {
            unlink("./".$registro_recuperado["foto"]);
        }   
    }

    if(isset($registro_recuperado["acotaciones"]) && $registro_recuperado["acotaciones"] != "") {
        if(file_exists("./".$registro_recuperado["acotaciones"])) {
            unlink("./".$registro_recuperado["acotaciones"]);
        }   
    }

    $sentencia = $conexion->prepare("DELETE FROM libreria_ciudadano WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $mensaje="Registro eliminado";
    header("Location: index.php?mensaje=".$mensaje);
}

$sentencia = $conexion->prepare("SELECT libreria_ciudadano.id, libreria_ciudadano.nombre, libreria_ciudadano.apellido, libreria_ciudadano.cedu, libreria_calle.nombreCalle as calle, libreria_ciudadano.foto
    FROM libreria_ciudadano
    LEFT JOIN libreria_calle ON libreria_calle.id = libreria_ciudadano.idcalle");

$sentencia->execute();
$lista_libreria_ciudadano = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../templates/header.php"); ?>
<div class="bg-gradient-to-br from-purple-200 to-blue-200 py-8">
    <div class="container mx-auto">
        <div class="card">
            <div class="card-header">
                <a class="btn btn-primary" href="crear.php" role="button">
                    Agregar Registro
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive-sm">
                    <table class="table table-bordered table-striped bg-gray-100" id="tabla_id">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Cedula</th>
                                <th scope="col">Calle</th>
                                <th scope="col">Foto</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lista_libreria_ciudadano as $registro): ?>
                                <tr>
                                    <td><?php echo $registro['id']; ?></td>
                                    <td><?php echo $registro['nombre']; ?></td>
                                    <td><?php echo $registro['apellido']; ?></td>
                                    <td><?php echo $registro['cedu']; ?></td>
                                    <td><?php echo $registro['calle']; ?></td>
                                    <td>
                                        <?php if (!empty($registro['foto'])): ?>
                                            <img width="100" height="100" src="<?php echo $registro['foto']; ?>" class="img-fluid rounded" alt="Foto" />
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <?php if ($_SESSION['id_cargo'] != 1): ?>
                                                <button class="btn btn-sm btn-primary mr-2" onclick="showPermissionDenied()">Editar</button>
                                                <button class="btn btn-sm btn-danger mr-2" onclick="showPermissionDenied()">Eliminar</button>
                                                <button class="btn btn-sm btn-info" onclick="showPermissionDenied()">Info</button>
                                            <?php else: ?>
                                                <a class="btn btn-sm btn-primary mr-2" href="editar.php?txtID=<?php echo $registro['id']; ?>" role="button">Editar</a>
                                                <a class="btn btn-sm btn-danger mr-2" href="javascript:borrar(<?php echo $registro['id']; ?>);" role="button">Eliminar</a>
                                                <a class="btn btn-sm btn-info" href="info.php?txtID=<?php echo $registro['id']; ?>" role="button">Info</a>
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
    </div>
</div>
<?php include("../../templates/fooder.php"); ?>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showPermissionDenied() {
        Swal.fire({
            icon: 'error',
            title: 'Acción no permitida',
            text: 'No tienes permiso para realizar esta acción',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Entendido'
        });
    }
</script>
