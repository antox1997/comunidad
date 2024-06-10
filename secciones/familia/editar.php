<?php
include("../../bd.php");

// Obtener la lista de ciudadanos ordenada por nombre
$sentencia = $conexion->prepare("SELECT id, nombre, apellido FROM libreria_ciudadano ORDER BY nombre ASC");
$sentencia->execute();
$lista_ciudadanos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// Obtener los datos de la familia a editar
if (isset($_GET['familia_id'])) {
    $familia_id = $_GET['familia_id'];

    $sentencia_familia = $conexion->prepare("SELECT Nfamilia FROM familia WHERE id = :familia_id");
    $sentencia_familia->bindParam(":familia_id", $familia_id);
    $sentencia_familia->execute();
    $familia = $sentencia_familia->fetch(PDO::FETCH_ASSOC);

    // Obtener los miembros de la familia
    $sentencia_miembros = $conexion->prepare("SELECT ciudadano_id FROM miembros_familia WHERE familia_id = :familia_id");
    $sentencia_miembros->bindParam(":familia_id", $familia_id);
    $sentencia_miembros->execute();
    $miembros_familia = $sentencia_miembros->fetchAll(PDO::FETCH_COLUMN);
} else {
    header('Location: ../../familia/index.php');
    exit();
}
?>

<?php include("../../templates/header.php"); ?>
<div class="container">
    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'guardado'): ?>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Guardado!',
                    text: 'Los cambios se han guardado exitosamente.',
                });
            });
        </script>
    <?php endif; ?>
    
    <form method="POST" action="añadir_familia.php">
        <input type="hidden" name="familia_id" value="<?php echo $familia_id; ?>">
        <div class="form-group">
            <label for="Nfamilia">Nombre de la Familia:</label>
            <input type="text" class="form-control" id="Nfamilia" name="Nfamilia" value="<?php echo $familia['Nfamilia']; ?>" required>
        </div>
        <div id="miembros">
            <h3>Miembros de la Familia</h3>
            <input type="text" class="form-control mb-2" id="searchCiudadano" placeholder="Buscar por nombre">
            <?php foreach ($lista_ciudadanos as $ciudadano): ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="miembros[]" value="<?php echo $ciudadano['id']; ?>" id="ciudadano<?php echo $ciudadano['id']; ?>" <?php echo in_array($ciudadano['id'], $miembros_familia) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="ciudadano<?php echo $ciudadano['id']; ?>">
                    <?php echo $ciudadano['nombre'] . " " . $ciudadano['apellido']; ?>
                </label>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
<?php include("../../templates/fooder.php"); ?>

<script>
    document.getElementById('searchCiudadano').addEventListener('input', function() {
        var searchValue = this.value.toLowerCase();
        var ciudadanos = document.querySelectorAll('#miembros .form-check');
        
        ciudadanos.forEach(function(ciudadano) {
            var nombreCiudadano = ciudadano.querySelector('label').textContent.toLowerCase();
            if (nombreCiudadano.indexOf(searchValue) !== -1) {
                ciudadano.style.display = 'block';
            } else {
                ciudadano.style.display = 'none';
            }
        });
    });
</script>
