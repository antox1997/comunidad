<?php 
// Incluimos el archivo de conexión a la base de datos
include("../../bd.php");
?>
<?php include("../../templates/header.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Documentos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #333;
            color: white;
            padding: 10px;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 10px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }
        .documento {
            background-color: white;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .documento a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
        }
        .documento a:hover {
            text-decoration: underline;
        }
        .solicitar-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .solicitar-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="bg-gradient-to-br from-purple-200 to-blue-200 py-8">
        <div class="container mx-auto px-4 mt-8 flex flex-col gap-2">

            <!-- Documentos a solicitar -->
            <div class="documento space-y-4">
                <h2 class="font-medium text-lg">Constancia de Residencia</h2>
                <form action="residencia.php" method="post">
                    <button type="submit" class="inline-block px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-indigo-600 border border-transparent rounded-md shadow-sm">Solicitar constancia</button>
                </form>
            </div>

            <!-- Botón para solicitar constancia -->
            <div class="documento space-y-4">
                <h2 class="font-medium text-lg">Constancia de Buena Conducta</h2>
                <form action="generar_constancia.php" method="post">
                    <button type="submit" class="inline-block px-3 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-indigo-600 border border-transparent rounded-md shadow-sm">Solicitar constancia</button>
                </form>
            </div>

        </div>
    </div>

    <?php include("../../templates/fooder.php"); ?>
</body>
</html>
