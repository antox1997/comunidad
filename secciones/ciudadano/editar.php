<?php
// Incluimos el archivo de conexión a la base de datos
include("../../bd.php");

// Si se ha enviado el parámetro del ID a través de la URL
if(isset($_GET['txtID'])){  
    // Obtenemos el ID del ciudadano a partir de la URL
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] :"";

    // Preparamos y ejecutamos la consulta para obtener los datos del ciudadano con ese ID
    $sentencia = $conexion->prepare("SELECT * FROM libreria_ciudadano WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    
    // Extraemos los datos del ciudadano y los guardamos en variables
    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
    $nombre = $registro["nombre"]; 
    $apellido = $registro["apellido"];
    $cedu = $registro["cedu"];
    $N_tlf = $registro["N_tlf"]; 
    $foto = $registro["foto"]; 
    $acotaciones = $registro["acotaciones"]; 
    $idcalle = $registro["idcalle"]; 

    // Obtenemos la lista de calles para el select
    $sentencia = $conexion->prepare("SELECT * FROM libreria_calle");
    $sentencia->execute();
    $lista_libreria_calle = $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

// Si se ha enviado el formulario
if($_POST) {
    // Obtenemos los datos del formulario
    $txtID = isset($_POST['txtID']) ? $_POST['txtID'] : "";
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
    $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : "";
    $cedu = isset($_POST["cedu"]) ? $_POST["cedu"] : "";
    $N_tlf = isset($_POST["N_tlf"]) ? $_POST["N_tlf"] : "";
    $idcalle = isset($_POST["idcalle"]) ? $_POST["idcalle"] : "";

    // Lógica para subir la foto
    $foto = isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "";
    $fecha = new DateTime();
    $nombreArchivo_foto = $foto; // Variable para la foto por defecto

    if(isset($_FILES["foto"]["error"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
        // Generamos un nombre único para la foto
        $nombreArchivo_foto = $fecha->getTimestamp() . "_" . $_FILES["foto"]['name'];
        $tmp_foto = $_FILES["foto"]['tmp_name'];
        
        // Movemos la foto a la carpeta y actualizamos la base de datos
        if($tmp_foto != '') {
            move_uploaded_file($tmp_foto, "./" . $nombreArchivo_foto);

            // Lógica para eliminar foto anterior si existe
            $sentencia = $conexion->prepare("SELECT foto FROM libreria_ciudadano WHERE id = :id");
            $sentencia->bindParam(":id", $txtID);
            $sentencia->execute();
            $registro_recuperado = $sentencia->fetch(PDO::FETCH_ASSOC);

            if(isset($registro_recuperado["foto"]) && $registro_recuperado["foto"] != "") {
                if(file_exists("./".$registro_recuperado["foto"])) {
                    unlink("./".$registro_recuperado["foto"]);
                }   
            }

            // Actualizar la base de datos con la nueva foto
            $sentencia = $conexion->prepare("UPDATE libreria_ciudadano SET foto = :foto WHERE id = :id");
            $sentencia->bindParam(":foto", $nombreArchivo_foto);
            $sentencia->bindParam(":id", $txtID);
            $sentencia->execute();
        }
    }

    // Actualizar la base de datos con los nuevos datos del ciudadano
    $sentencia = $conexion->prepare("
        UPDATE libreria_ciudadano 
        SET nombre = :nombre, apellido = :apellido, cedu = :cedu, N_tlf = :N_tlf, idcalle = :idcalle
        WHERE id = :id");

    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":apellido", $apellido);
    $sentencia->bindParam(":cedu", $cedu);
    $sentencia->bindParam(":N_tlf", $N_tlf);
    $sentencia->bindParam(":idcalle", $idcalle);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    // Redireccionamos a la página de índice con un mensaje
    $mensaje = "Registro actualizado";
    header("Location: index.php?mensaje=".$mensaje);
}
?>

<?php include("../../templates/header.php"); ?>
<div class="bg-gradient-to-br from-purple-200 to-blue-200 py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

<br/>
<div class="container mx-auto px-4">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="text-2xl font-bold mb-4">Datos del ciudadano</div>
        <form action="" method="post" enctype="multipart/form-data">

            <!-- Campo oculto para almacenar el ID -->
            <input type="hidden" value="<?php echo $txtID; ?>" name="txtID" />

            <!-- Campo para el nombre -->
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                <input type="text" value="<?php echo $nombre; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="nombre" id="nombre" placeholder="Nombre" />
            </div>

            <!-- Campo para el apellido -->
            <div class="mb-4">
                <label for="apellido" class="block text-gray-700 text-sm font-bold mb-2">Apellido:</label>
                <input type="text" value="<?php echo $apellido; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="apellido" id="apellido" placeholder="Apellido" />
            </div>

            <!-- Campo para la cédula -->
            <div class="mb-4">
                <label for="cedu" class="block text-gray-700 text-sm font-bold mb-2">Cédula:</label>
                <input type="text" value="<?php echo $cedu; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="cedu" id="cedu" placeholder="Cédula" />
            </div>

            <!-- Campo para el número de teléfono -->
            <div class="mb-4">
                <label for="N_tlf" class="block text-gray-700 text-sm font-bold mb-2">Número de Teléfono:</label>
                <input type="text" value="<?php echo $N_tlf; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="N_tlf" id="N_tlf" placeholder="Número de Teléfono" />
            </div>

            <!-- Campo para la foto -->
            <div class="mb-4">
                <label for="foto" class="block text-gray-700 text-sm font-bold mb-2">Foto:</label>
                <br/>
                <!-- Mostramos la foto actual -->
                <img width="100" src="<?php echo isset($foto) ? $foto : ''; ?>" class="img-fluid" alt="Foto" />
                <!-- Input para subir una nueva foto -->
                <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="foto" id="foto" placeholder="Foto" />
            </div>

            <!-- Campo para las acotaciones (PDF) -->
            <div class="mb-4">
                <label for="acotaciones" class="block text-gray-700 text-sm font-bold mb-2">Acotaciones (PDF):</label>
                <br/>
                <!-- Mostramos un enlace a las acotaciones actuales -->
                <a href="<?php echo $acotaciones; ?>"><?php echo $acotaciones; ?></a>
                <!-- Input para subir un nuevo archivo de acotaciones -->
                <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="acotaciones" id="acotaciones" placeholder="Acotaciones" />
            </div>

            <!-- Campo para seleccionar la calle -->
            <div class="mb-4">
                <label for="idcalle" class="block text-gray-700 text-sm font-bold mb-2">Calle:</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="idcalle" id="idcalle">
                    <!-- Iteramos sobre la lista de calles -->
                    <?php foreach ($lista_libreria_calle as $registro): ?>
                        <!-- Marcamos como seleccionada la calle actual -->
                        <option <?php echo ($idcalle==$registro['id'])?"selected":"";?> value="<?php echo $registro['id']; ?>">
                            <?php echo $registro['nombreCalle']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
            </div>

            <!-- Botón para enviar el formulario -->
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Actualizar registro</button>
            <!-- Botón para cancelar y volver al índice -->
            <a name="" id="" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
</div>

<?php include("../../templates/fooder.php"); ?>
