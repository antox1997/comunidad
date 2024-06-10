<?php 
include("../../bd.php"); 

if($_POST)  {
    // Capturar los datos del formulario
    $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $correo = isset($_POST["correo"]) ? $_POST["correo"] : "";

    // Capturar el puesto del cargo desde el formulario
    $puesto_cargo = isset($_POST["cargo"]) ? $_POST["cargo"] : "";

    // Preparar la sentencia SQL para insertar los datos en la tabla
    $sentencia = $conexion->prepare("INSERT INTO libreria_usuarios (usuario, password, correo, id_cargo) VALUES (:usuario, :password, :correo, :id_cargo)");

    // Asignar el ID del cargo según el puesto seleccionado
    $id_cargo = ($puesto_cargo == 1) ? 1 : 2;

    // Ligamos los parámetros
    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password", $password);
    $sentencia->bindParam(":correo", $correo);
    $sentencia->bindParam(":id_cargo", $id_cargo);

    // Ejecutamos la sentencia
    if($sentencia->execute()) {
        $mensaje = "Registro agregado";
        header("Location: index.php?mensaje=".$mensaje);
        exit(); // Detener la ejecución después de la redirección
    } else {
        $mensaje = "Error al agregar el registro";
        header("Location: index.php?error=".$mensaje);
        exit(); // Detener la ejecución después de la redirección
    }
}
?>

<?php include("../../templates/header.php"); ?>

<br/>

<div class="container mx-auto px-4">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold mb-4">Datos del usuario</h2>
        </div>

        <form action="" method="post" enctype="multipart/form-data"> 
            <div class="mb-4">
                <label for="usuario" class="block text-gray-700 text-sm font-bold mb-2">Nombre del usuario:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="usuario" id="usuario" placeholder="Nombre del usuario"/>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña:</label>
                <input type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="password" id="password" placeholder="Escriba su contraseña"/>
            </div>
            <div class="mb-4">
                <label for="correo" class="block text-gray-700 text-sm font-bold mb-2">Correo:</label>
                <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="correo" id="correo" placeholder="Escriba su correo"/>
            </div>
            <div class="mb-4">
                <label for="cargo" class="block text-gray-700 text-sm font-bold mb-2">Cargo:</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="cargo" id="cargo">
                    <option value="1">Administrador</option>
                    <option value="2">Público</option>
                </select>
            </div>
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Agregar</button>
            <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>

<?php include("../../templates/fooder.php"); ?>
