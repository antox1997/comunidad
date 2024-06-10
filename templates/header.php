<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Establecer la URL base
$url_base = "http://localhost/comunidad/";

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    header("location:".$url_base."login.php");
    exit(); // Detener la ejecución del código después de redirigir
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Comunidad</title>
    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
    
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Estilos personalizados -->
    <style>
        /* Estilo del fondo */
        body {
            background-color: #f0f0f0; /* Color de fondo */
        }

        /* Estilo del menú */
        .navbar {
            background-color: #007bff; /* Color del menú */
        }

        .navbar-nav .nav-link {
            color: #ffffff !important; /* Color de los enlaces del menú */
        }

        .navbar-nav .nav-link:hover {
            color: #ffffff !important; /* Color de los enlaces del menú al pasar el mouse */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-gradient-to-r from-purple-400 via-pink-500 to-red-500">
    <div class="container">
        <a class="navbar-brand text-white" href="<?php echo $url_base; ?>">Inicio</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?php echo $url_base; ?>secciones/ciudadano">Ciudadanos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?php echo $url_base; ?>secciones/calle">Calles</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?php echo $url_base; ?>secciones/cartas/solicitar.php">Solicitudes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?php echo $url_base; ?>secciones/usuarios">Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?php echo $url_base; ?>secciones/familia/index.php">Familias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?php echo $url_base; ?>cerrar.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


</body>
</html>
