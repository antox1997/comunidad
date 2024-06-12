<?php
include("../../bd.php");

if (isset($_GET['familia_id'])) {
    $familia_id = $_GET['familia_id'];

    // Obtener el nombre de la familia
    $sentencia_familia = $conexion->prepare("SELECT Nfamilia FROM familia WHERE id = :familia_id");
    $sentencia_familia->bindParam(":familia_id", $familia_id);
    $sentencia_familia->execute();
    $familia = $sentencia_familia->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $descripcion = $_POST['descripcion'];
        $fecha_historial = $_POST['fecha_historial'];
        $beneficios = $_POST['beneficios'];  // Este será un array de beneficios

        // Insertar historial
        $sentencia_historial = $conexion->prepare("INSERT INTO historial_familia (familia_id, descripcion, fecha) VALUES (:familia_id, :descripcion, :fecha)");
        $sentencia_historial->bindParam(':familia_id', $familia_id);
        $sentencia_historial->bindParam(':descripcion', $descripcion);
        $sentencia_historial->bindParam(':fecha', $fecha_historial);
        $sentencia_historial->execute();

        $historial_id = $conexion->lastInsertId();

        // Insertar beneficios
        $sentencia_beneficio = $conexion->prepare("INSERT INTO beneficios_familia (historial_id, beneficio, fecha) VALUES (:historial_id, :beneficio, :fecha)");
        foreach ($beneficios as $beneficio) {
            $sentencia_beneficio->bindParam(':historial_id', $historial_id);
            $sentencia_beneficio->bindParam(':beneficio', $beneficio['nombre']);
            $sentencia_beneficio->bindParam(':fecha', $beneficio['fecha']);
            $sentencia_beneficio->execute();
        }
        
        // Redirigir para evitar reenvío de formularios
        header("Location: ver_miembros.php?familia_id=$familia_id");
        exit();
    }
} else {
    // Redireccionar si no se proporciona el ID de la familia
    header('Location: index.php');
    exit();
}
?>

<?php include("../../templates/header.php"); ?>
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-4"> Añadir evento: <strong class="text-purple-600"><?php echo htmlspecialchars($familia['Nfamilia'], ENT_QUOTES, 'UTF-8'); ?></strong></h2>
    
    <form method="POST" action="">
        <div class="mb-4">
            <label for="descripcion" class="block text-gray-700">Descripción</label>
            <textarea id="descripcion" name="descripcion" class="mt-1 block w-full" rows="4" required></textarea>
        </div>
        <div class="mb-4">
            <label for="fecha_historial" class="block text-gray-700">Fecha</label>
            <input type="date" id="fecha_historial" name="fecha_historial" class="mt-1 block w-full" required>
        </div>
        <div id="beneficiosContainer" class="mb-4">
            <h4 class="text-lg font-bold mb-2">Beneficios</h4>
            <div class="beneficio mb-2">
                <input type="text" name="beneficios[0][nombre]" placeholder="Nombre del beneficio" class="mt-1 block w-full mb-2">
                <input type="date" name="beneficios[0][fecha]" placeholder="Fecha" class="mt-1 block w-full">
            </div>
        </div>
        <button type="button" onclick="addBeneficio()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">Añadir otro beneficio</button>
        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
    </form>
</div>
<<?php include("../../templates/fooder.php"); ?>

<script>
    function addBeneficio() {
        const container = document.getElementById('beneficiosContainer');
        const beneficioCount = container.querySelectorAll('.beneficio').length;
        const beneficioDiv = document.createElement('div');
        beneficioDiv.className = 'beneficio mb-2';
        beneficioDiv.innerHTML = `
            <input type="text" name="beneficios[${beneficioCount}][nombre]" placeholder="Nombre del beneficio" class="mt-1 block w-full mb-2">
            <input type="date" name="beneficios[${beneficioCount}][fecha]" placeholder="Fecha" class="mt-1 block w-full">
        `;
        container.appendChild(beneficioDiv);
    }
</script>
