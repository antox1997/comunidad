<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Constancia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .formulario {
            background-color: #fff;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .formulario h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .formulario label {
            display: block;
            margin-bottom: 10px;
        }
        .formulario input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .formulario button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .formulario button[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <?php include("../../templates/header.php"); ?>

    <!-- Formulario para solicitar constancia -->
    <div class="formulario">
        <h2>Solicitar Permiso de Inmuebles</h2>
        <form action="mueble1.php" method="post">
            <label for="cedula">Cédula:</label>
            <input type="text" id="cedula" name="cedula">
            <button type="submit">Solicitar Constancia</button>
        </form>
    </div>

    <!-- Resto del contenido... -->
</body>
</html>