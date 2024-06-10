<?php
// Incluimos el archivo de conexión a la base de datos
include("../../bd.php");

// Si se ha enviado el parámetro del ID a través de la URL
if(isset($_GET['txtID'])){  
    // Obtenemos el ID del ciudadano a partir de la URL
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] :"";

    // Preparamos y ejecutamos la consulta para obtener los datos del ciudadano con ese ID
    $setencia = $conexion->prepare("SELECT * FROM libreria_ciudadano WHERE id=:id");
    $setencia->bindParam(":id", $txtID);
    $setencia->execute();
    
    
    // Extraemos los datos del ciudadano y los guardamos en variables
    $registro = $setencia->fetch(PDO::FETCH_ASSOC);
    $nombre = $registro["nombre"]; 
    $apellido = $registro["apellido"];
    $cedu = $registro["cedu"];
    $N_tlf = $registro["N_tlf"]; 

    $foto = $registro["foto"]; 
    $acotaciones = $registro["acotaciones"]; 
    $idcalle = $registro["idcalle"]; 

    // Preparamos y ejecutamos la consulta para obtener el nombre de la calle
    $sentencia = $conexion->prepare("SELECT nombreCalle FROM libreria_calle WHERE id=:id");
    $sentencia->bindParam(":id", $idcalle);
    $sentencia->execute();
    $calle = $sentencia->fetch(PDO::FETCH_ASSOC)['nombreCalle'];
}
?>

<?php include("../../templates/header.php"); ?>
<div class="bg-gradient-to-br from-purple-200 to-blue-200 py-8">

<div class="container mx-auto px-4 mt-8">

<br/>
<div class="card">  
    <div class="card-header">
        Información del ciudadano
    </div>
    <div class="card-body">
        <!-- Mostramos los datos del ciudadano -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <p><?php echo $nombre; ?></p>
        </div>

        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido:</label>
            <p><?php echo $apellido; ?></p>
        </div>

        <div class="mb-3">
            <label for="cedu" class="form-label">Cédula:</label>
            <p><?php echo $cedu; ?></p>
        </div>

        <div class="mb-3">
            <label for="calle" class="form-label">Calle:</label>
            <p><?php echo $calle; ?></p>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto:</label>
            <br/>
            <!-- Mostramos la foto del ciudadano -->
            <img width="100" src="<?php echo $foto; ?>" class="img-fluid" alt="Foto" />
        </div>

        <div class="mb-3">
            <label for="acotaciones" class="form-label">Acotaciones (PDF):</label>
            <br/>
            <!-- Botón estilizado para descargar las acotaciones del ciudadano -->
            <a href="<?php echo $acotaciones; ?>" download class="btn btn-primary">Descargar Acotaciones</a>
        </div>

        <!-- Botón para volver al índice -->
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Volver</a>
    </div>
    <div class="card-footer text-muted"></div>
</div>

<?php include("../../templates/fooder.php"); ?>
