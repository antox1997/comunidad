<?php
include("../../bd.php");

if(isset($_GET['familia_id'])){
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
<div class="container">
    <h2></br>Miembros de la Familia: <strong><?php echo $familia['Nfamilia']; ?></strong></h2>
    <?php if(count($miembros) > 0): ?>
    </br> </br>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Cédula</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($miembros as $miembro): ?>
            <tr>
                <td><?php echo $miembro['nombre']; ?></td>
                <td><?php echo $miembro['apellido']; ?></td>
                <td><?php echo $miembro['cedu']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p>No hay miembros registrados en esta familia.</p>
    <?php endif; ?>
    <a href="index.php" class="btn btn-primary">Volver a la lista de familias</a>
</div>
<?php include("../../templates/fooder.php"); ?>
