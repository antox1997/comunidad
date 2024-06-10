<?php 
include("../../bd.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si se recibió un valor para "nombreCalle"
    if (isset($_POST["nombreCalle"])) {
        $nombreCalle = $_POST["nombreCalle"];

        // Preparar la inserción de los datos
        $sentencia = $conexion->prepare("INSERT INTO libreria_calle(nombreCalle) VALUES(:nombreCalle)");

        // Asignar los valores que vienen del formulario
        $sentencia->bindParam(":nombreCalle", $nombreCalle);

        // Ejecutar la sentencia SQL
        if ($sentencia->execute()) {
            $mensaje = "Registro agregado exitosamente";
            header("Location: index.php?mensaje=" . $mensaje);
            exit();
        } else {
            $mensaje = "Error al agregar el registro";
        }
    } else {
        $mensaje = "No se recibió el nombre de la calle";
    }
}
?>
<?php include("../../templates/header.php"); ?>

<br/>

<div class="container mx-auto px-4">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <?php if (!empty($mensaje)) { ?> 
            <div class="bg-blue-100 border-t-4 border-blue-500 rounded-b text-blue-900 px-4 py-3 mb-4" role="alert">
                <div class="flex">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-blue-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9 16a1 1 0 01-1-1v-4H5a1 1 0 110-2h3V5a1 1 0 112 0v5h3a1 1 0 010 2h-3v4a1 1 0 01-1 1z"/></svg></div>
                    <div>
                        <p class="font-bold"><?php echo $mensaje; ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>

        <form action="" method="post" enctype="multipart/form-data"> 
            <div class="mb-4">
                <label for="nombreCalle" class="block text-gray-700 text-sm font-bold mb-2">Nombre de la calle:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="nombreCalle" id="nombreCalle" placeholder="Nombre de la calle">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Agregar</button>
                <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" href="index.php" role="button">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include("../../templates/fooder.php"); ?>
