<?php
include("../../bd.php");

$mensaje = "";

// Verificar si se recibió un ID válido a través de GET
if (isset($_GET['txtID'])) {
    $txtID = $_GET['txtID'];

    // Consultar la información de la calle correspondiente al ID proporcionado
    $sentencia = $conexion->prepare("SELECT * FROM libreria_calle WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    // Obtener los datos de la calle
    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
    if ($registro) {
        $nombreCalle = $registro["nombreCalle"];
    } else {
        // Si no se encuentra el ID proporcionado, redirigir a la página principal con un mensaje de error
        header("Location: index.php?mensaje=ID no encontrado");
        exit();
    }
}

// Verificar si se recibió un formulario POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del formulario
    $txtID = isset($_POST['txtID']) ? $_POST['txtID'] : "";
    $nombreCalle = isset($_POST["nombreCalle"]) ? $_POST["nombreCalle"] : "";

    // Actualizar la información de la calle en la base de datos
    $sentencia = $conexion->prepare("UPDATE libreria_calle SET nombreCalle=:nombreCalle WHERE id=:id");
    $sentencia->bindParam(":nombreCalle", $nombreCalle);
    $sentencia->bindParam(":id", $txtID);

    if ($sentencia->execute()) {
        // Si la actualización fue exitosa, redirigir a la página principal con un mensaje de éxito
        $mensaje = "Registro actualizado";
        header("Location: index.php?mensaje=" . $mensaje);
        exit();
    } else {
        // Si hubo un error durante la actualización, mostrar un mensaje de error
        $mensaje = "Error al actualizar el registro";
    }
}
?>

<?php include("../../templates/header.php"); ?>
<div class="bg-gradient-to-br from-purple-200 to-blue-200 py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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
                <label for="txtID" class="block text-gray-700 text-sm font-bold mb-2">ID:</label>
                <input type="text" value="<?php echo $txtID; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID" />
            </div>

            <div class="mb-4">
                <label for="nombreCalle" class="block text-gray-700 text-sm font-bold mb-2">Nombre de la calle:</label>
                <input type="text" value="<?php echo $nombreCalle; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="nombreCalle" id="nombreCalle" aria-describedby="helpId" placeholder="Nombre de la calle" />
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Actualizar</button>
                <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" href="index.php" role="button">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php include("../../templates/fooder.php"); ?>

