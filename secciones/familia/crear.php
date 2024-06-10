<?php
include("../../bd.php");

// Obtener la lista de ciudadanos ordenada por nombre
$sentencia = $conexion->prepare("SELECT id, nombre, apellido FROM libreria_ciudadano ORDER BY nombre ASC");
$sentencia->execute();
$lista_ciudadanos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../templates/header.php"); ?>
<div class="container">
    <h2>Añadir Familia</h2>
    <form method="POST" action="añadir_familia.php">
        <div class="form-group">
            <label for="Nfamilia">Nombre de la Familia:</label>
            <input type="text" class="form-control" id="Nfamilia" name="Nfamilia" required>
        </div>
        <div id="miembros">
            <h3>Miembros de la Familia</h3>
            <!-- Campo de búsqueda -->
            <input type="text" class="form-control mb-2" id="searchCiudadano" placeholder="Buscar por nombre">
            <!-- Lista de ciudadanos -->
            <?php foreach ($lista_ciudadanos as $ciudadano): ?>
            <div class="form-check">
                <input class="form-check-input miembro" type="checkbox" name="miembros[]" value="<?php echo $ciudadano['id']; ?>">
                <label class="form-check-label" for="miembro_<?php echo $ciudadano['id']; ?>">
                    <?php echo $ciudadano['nombre'] . ' ' . $ciudadano['apellido']; ?>
                </label>
            </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-success">Guardar Familia</button>
    </form>
</div>

<?php include("../../templates/fooder.php"); ?>

<script>
    // Función para filtrar los ciudadanos por nombre
    document.getElementById('searchCiudadano').addEventListener('input', function() {
        var searchValue = this.value.toLowerCase();
        var miembros = document.querySelectorAll('.miembro');
        
        miembros.forEach(function(miembro) {
            var nombreCompleto = miembro.nextElementSibling.textContent.toLowerCase();
            if (nombreCompleto.indexOf(searchValue) !== -1) {
                miembro.parentNode.style.display = 'block';
            } else {
                miembro.parentNode.style.display = 'none';
            }
        });
    });
</script>
