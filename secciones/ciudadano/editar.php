<?php
include("../../bd.php");

if(isset($_GET['txtID'])){  
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] : "";

    $sentencia = $conexion->prepare("SELECT * FROM libreria_ciudadano WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    
    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
    $nombre = $registro["nombre"]; 
    $apellido = $registro["apellido"];
    $cedu = $registro["cedu"];
    $N_tlf = $registro["N_tlf"]; 
    $foto = $registro["foto"]; 
    $acotaciones = $registro["acotaciones"]; 
    $idcalle = $registro["idcalle"]; 

    $sentencia = $conexion->prepare("SELECT * FROM libreria_calle");
    $sentencia->execute();
    $lista_libreria_calle = $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

if($_POST) {
    $txtID = isset($_POST['txtID']) ? $_POST['txtID'] : "";
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
    $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : "";
    $cedu = isset($_POST["cedu"]) ? $_POST["cedu"] : "";
    $N_tlf = isset($_POST["N_tlf"]) ? $_POST["N_tlf"] : "";
    $idcalle = isset($_POST["idcalle"]) ? $_POST["idcalle"] : "";

    // Lógica para subir la foto
    $fecha = new DateTime();
    if(isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
        $nombreArchivo_foto = $fecha->getTimestamp() . "_" . $_FILES["foto"]['name'];
        $tmp_foto = $_FILES["foto"]['tmp_name'];
        move_uploaded_file($tmp_foto, "../../libreria/" . $nombreArchivo_foto);

        $sentencia = $conexion->prepare("SELECT foto FROM libreria_ciudadano WHERE id = :id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_ASSOC);

        if(isset($registro_recuperado["foto"]) && $registro_recuperado["foto"] != "") {
            if(file_exists("../../libreria/" . $registro_recuperado["foto"])) {
                unlink("../../libreria/" . $registro_recuperado["foto"]);
            }
        }

        $sentencia = $conexion->prepare("UPDATE libreria_ciudadano SET foto = :foto WHERE id = :id");
        $sentencia->bindParam(":foto", $nombreArchivo_foto);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }

    // Lógica para subir las acotaciones
    if(isset($_FILES["acotaciones"]) && $_FILES["acotaciones"]["error"] === UPLOAD_ERR_OK) {
        $nombreArchivo_acotaciones = $fecha->getTimestamp() . "_" . $_FILES["acotaciones"]['name'];
        $tmp_acotaciones = $_FILES["acotaciones"]['tmp_name'];
        move_uploaded_file($tmp_acotaciones, "../../libreria/" . $nombreArchivo_acotaciones);

        $sentencia = $conexion->prepare("SELECT acotaciones FROM libreria_ciudadano WHERE id = :id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_ASSOC);

        if(isset($registro_recuperado["acotaciones"]) && $registro_recuperado["acotaciones"] != "") {
            if(file_exists("../../libreria/" . $registro_recuperado["acotaciones"])) {
                unlink("../../libreria/" . $registro_recuperado["acotaciones"]);
            }
        }

        $sentencia = $conexion->prepare("UPDATE libreria_ciudadano SET acotaciones = :acotaciones WHERE id = :id");
        $sentencia->bindParam(":acotaciones", $nombreArchivo_acotaciones);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }

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
                    <input type="hidden" value="<?php echo $txtID; ?>" name="txtID" />

                    <div class="mb-4">
                        <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                        <input type="text" value="<?php echo $nombre; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="nombre" id="nombre" placeholder="Nombre" />
                    </div>

                    <div class="mb-4">
                        <label for="apellido" class="block text-gray-700 text-sm font-bold mb-2">Apellido:</label>
                        <input type="text" value="<?php echo $apellido; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="apellido" id="apellido" placeholder="Apellido" />
                    </div>

                    <div class="mb-4">
                        <label for="cedu" class="block text-gray-700 text-sm font-bold mb-2">Cédula:</label>
                        <input type="text" value="<?php echo $cedu; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="cedu" id="cedu" placeholder="Cédula" />
                    </div>

                    <div class="mb-4">
                        <label for="N_tlf" class="block text-gray-700 text-sm font-bold mb-2">Número de Teléfono:</label>
                        <input type="text" value="<?php echo $N_tlf; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="N_tlf" id="N_tlf" placeholder="Número de Teléfono" />
                    </div>

                    <div class="mb-4">
                        <label for="foto" class="block text-gray-700 text-sm font-bold mb-2">Foto:</label>
                        <br/>
                        <img width="100" src="../../libreria/<?php echo isset($foto) ? $foto : ''; ?>" class="img-fluid" alt="Foto" />
                        <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="foto" id="foto" placeholder="Foto" />
                    </div>

                    <div class="mb-4">
                        <label for="acotaciones" class="block text-gray-700 text-sm font-bold mb-2">Acotaciones (PDF):</label>
                        <br/>
                        <a href="../../libreria/<?php echo $acotaciones; ?>" target="_blank"><?php echo $acotaciones; ?></a>
                        <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="acotaciones" id="acotaciones" placeholder="Acotaciones" />
                    </div>

                    <div class="mb-4">
                        <label for="idcalle" class="block text-gray-700 text-sm font-bold mb-2">Calle:</label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="idcalle" id="idcalle">
                            <?php foreach ($lista_libreria_calle as $registro): ?>
                                <option <?php echo ($idcalle==$registro['id'])?"selected":"";?> value="<?php echo $registro['id']; ?>">
                                    <?php echo $registro['nombreCalle']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Actualizar registro</button>
                    <a name="" id="" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" href="index.php" role="button">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("../../templates/fooder.php"); ?>
