<?php 
include("../../bd.php"); 

if($_POST) {
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
    $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : "";
    $cedu = isset($_POST["cedu"]) ? $_POST["cedu"] : "";
    $N_tlf = isset($_POST["N_tlf"]) ? $_POST["N_tlf"] : "";
    
    $foto = isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "";
    $acotaciones = isset($_FILES["acotaciones"]['name']) ? $_FILES["acotaciones"]['name'] : "";

    $idcalle = isset($_POST["idcalle"]) ? $_POST["idcalle"] : "";

    $fecha_ = new DateTime();
    
    $nombreArchivo_foto = ($foto != '') ? $fecha_->getTimestamp() . "_" . $_FILES["foto"]['name'] : "";
    $tmp_foto = $_FILES["foto"]['tmp_name'];
    if($tmp_foto != '') {   
        move_uploaded_file($tmp_foto, "./" . $nombreArchivo_foto);
    } 
    $fecha_ = new DateTime();

    
    $nombreArchivo_acotaciones = ($acotaciones != '') ? $fecha_->getTimestamp() . "_" . $_FILES["acotaciones"]['name'] : "";
    $tmp_acotaciones = $_FILES["acotaciones"]['tmp_name'];
    if ($tmp_acotaciones != '') {
        move_uploaded_file($tmp_acotaciones, "./". $nombreArchivo_acotaciones);
    }

    $sentencia = $conexion->prepare("INSERT INTO 
    `libreria_ciudadano` (`id`, `nombre`, `apellido`, `cedu`, `N_tlf`, `foto`, `acotaciones`, `idcalle`) 
    VALUES (NULL, :nombre, :apellido, :cedu, :N_tlf, :foto, :acotaciones, :idcalle)");

    $sentencia->bindParam(":nombre", $nombre);
    $sentencia->bindParam(":apellido", $apellido);
    $sentencia->bindParam(":cedu", $cedu);
    $sentencia->bindParam(":N_tlf", $N_tlf);
    $sentencia->bindParam(":foto", $nombreArchivo_foto);
    $sentencia->bindParam(":acotaciones", $nombreArchivo_acotaciones);
    $sentencia->bindParam(":idcalle", $idcalle);

    $sentencia->execute();

    $mensaje = "Registro agregado";
    header("Location: index.php?mensaje=".$mensaje);
}

$sentencia = $conexion->prepare("SELECT * FROM libreria_calle");
$sentencia->execute();
$lista_libreria_calle = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../templates/header.php"); ?>
<style>
    .preview-image {
        max-width: 200px; /* ajusta el tamaño máximo según tus necesidades */
        max-height: 200px; /* ajusta el tamaño máximo según tus necesidades */
    }
</style>
<br/>
<div class="container mx-auto px-4">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="text-2xl font-bold mb-4">Datos del ciudadano</div>
        <form action="" method="post" enctype="multipart/form-data">

            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="nombre" id="nombre" placeholder="Nombre" />
            </div>

            <div class="mb-4">
                <label for="apellido" class="block text-gray-700 text-sm font-bold mb-2">Apellido:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="apellido" id="apellido" placeholder="Apellido" />
            </div>

            <div class="mb-4">
                <label for="cedu" class="block text-gray-700 text-sm font-bold mb-2">Cédula:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="cedu" id="cedu" placeholder="Cédula" />
            </div>

            <div class="mb-4">
                <label for="N_tlf" class="block text-gray-700 text-sm font-bold mb-2">Número de Teléfono:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="N_tlf" id="N_tlf" placeholder="Número de Teléfono" />
            </div>

            <div class="mb-4">
                <label for="foto" class="block text-gray-700 text-sm font-bold mb-2">Foto:</label>
                <input type="file" onchange="previewImage(this, 'preview-foto');" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="foto" id="foto" placeholder="Foto" />
                <img id="preview-foto" class="preview-image" src="#" alt="Preview" style="display: none;" />
            </div>

            <div class="mb-4">
                <label for="acotaciones" class="block text-gray-700 text-sm font-bold mb-2">Acotaciones (PDF):</label>
                <input type="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="acotaciones" id="acotaciones" placeholder="Acotaciones" />
            </div>
            
            <div class="mb-4">
                <label for="idcalle" class="block text-gray-700 text-sm font-bold mb-2">Calle:</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="idcalle" id="idcalle">
                    <?php foreach ($lista_libreria_calle as $registro): ?>
                        <option value="<?php echo $registro['id']; ?>"><?php echo $registro['nombreCalle']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Agregar registro</button>
            <a name="" id="" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" href="index.php" role="button">Cancelar</a>

        </form>
    </div>
</div>

<?php include("../../templates/fooder.php"); ?>

<script>
    function previewImage(input, imgId) {
        var imgElement = document.getElementById(imgId);
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                imgElement.style.display = 'block';
                imgElement.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
