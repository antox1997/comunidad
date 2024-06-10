<?php
include("../../bd.php");

if(isset($_GET['txtID'])){  
    $txtID = isset($_GET['txtID']) ? $_GET['txtID'] :"";

    $sentencia = $conexion->prepare("SELECT * FROM libreria_usuarios WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
    $usuario = $registro["usuario"]; 
    $password = $registro["password"]; 
    $correo = $registro["correo"]; 
    $id_cargo = $registro["id_cargo"]; // Obteniendo el ID del cargo
}
if($_POST)  {
    
    $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $correo = isset($_POST["correo"]) ? $_POST["correo"] : "";
    $id_cargo = isset($_POST["cargo"]) ? $_POST["cargo"] : ""; // Obteniendo el ID del cargo desde el formulario
  
    $sentencia = $conexion->prepare("UPDATE libreria_usuarios SET 
     usuario=:usuario,
     password=:password,
     correo=:correo,
     id_cargo=:id_cargo
     WHERE id=:id
    ");

    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password", $password);
    $sentencia->bindParam(":correo", $correo);
    $sentencia->bindParam(":id_cargo", $id_cargo);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $mensaje="Registro actualizado";
    header("Location: index.php?mensaje=".$mensaje);
}
?>

<?php include("../../templates/header.php"); ?>
<div class="bg-gradient-to-br from-purple-200 to-blue-200 py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


<br/>

<div class="container mx-auto px-4">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold mb-4">Datos del usuario</h2>
        </div>

        <form action="" method="post" enctype="multipart/form-data"> 
            <div class="mb-4">
                <label for="usuario" class="block text-gray-700 text-sm font-bold mb-2">Nombre del usuario:</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="usuario" id="usuario" value="<?php echo $usuario; ?>" placeholder="Nombre del usuario"/>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña:</label>
                <input type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="password" id="password" value="<?php echo $password; ?>" placeholder="Escriba su contraseña"/>
            </div>
            <div class="mb-4">
                <label for="correo" class="block text-gray-700 text-sm font-bold mb-2">Correo:</label>
                <input type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="correo" id="correo" value="<?php echo $correo; ?>" placeholder="Escriba su correo"/>
            </div>
            <div class="mb-4">
                <label for="cargo" class="block text-gray-700 text-sm font-bold mb-2">Cargo:</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="cargo" id="cargo">
                    <option value="1" <?php if ($id_cargo == 1) echo 'selected="selected"'; ?>>Administrador</option>
                    <option value="2" <?php if ($id_cargo == 2) echo 'selected="selected"'; ?>>Público</option>
                </select>
            </div>
            <input type="hidden" name="txtID" value="<?php echo $txtID; ?>"> <!-- Campo oculto para enviar el ID -->
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Guardar cambios</button>
            <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" href="index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>

<?php include("../../templates/fooder.php"); ?>
