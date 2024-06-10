<?php 

session_start();

$mensaje = "";

if($_POST) {
    include("./bd.php");

    $sentencia = $conexion->prepare("SELECT *, count(*) as n_usuarios FROM libreria_usuarios WHERE usuario=:usuario AND password=:password");

    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":password", $contraseña);

    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_ASSOC);
   
    if($registro["n_usuarios"] > 0){
        $_SESSION['usuario'] = $registro["usuario"];
        $_SESSION['logueado'] = true;
        $_SESSION['id_cargo'] = $registro["id_cargo"]; // Almacenar el id_cargo en la sesión
        header("Location: index.php");
        exit();
    } else {
        $mensaje = "Error: el usuario o contraseña son incorrectos";
    }
    
}

?> 

<!doctype html>
<div class="bg-gradient-to-br from-purple-200 to-blue-200 py-8">
<html lang="en">
    <head>
        <title>Login</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Tailwind CSS -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    </head>

    <body class="bg-gray-100">
        <header>
            <!-- place navbar here -->
        </header>
        <main class="container mx-auto flex justify-center items-center h-screen">
            <div class="w-full max-w-xs">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <?php if(!empty($mensaje)){ ?> 
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-4 rounded relative" role="alert">
                            <strong><?php echo $mensaje; ?></strong>
                        </div>
                    <?php } ?>
                    <form action="" method="post">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="usuario">Usuario:</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="usuario" type="text" name="usuario" placeholder="Escriba su usuario">
                        </div>
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="contraseña">Contraseña:</label>
                            <input class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="contraseña" type="password" name="contraseña" placeholder="Escriba su contraseña">
                        </div>
                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Entrar al sistema</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        <footer>
            <!-- place footer here -->
        </footer>
    </body>
</html>
