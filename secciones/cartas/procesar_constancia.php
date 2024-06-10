<?php

// Incluimos el archivo de conexión a la base de datos
include("../../bd.php");

// Incluimos el autoload de Dompdf
require_once __DIR__ . '/dompdf/autoload.inc.php';

// Utilizamos la clase Dompdf
use Dompdf\Dompdf;

// Verificamos si se ha enviado el formulario
if(isset($_POST['cedula'])) {
    // Obtenemos la cédula del formulario
    $cedula = $_POST['cedula'];

    // Preparamos la consulta para obtener los datos del ciudadano por cédula
    $consulta = $conexion->prepare("SELECT * FROM libreria_ciudadano WHERE cedu = :cedula");
    $consulta->bindParam(":cedula", $cedula);
    $consulta->execute();

    // Verificamos si se encontraron resultados
    if($consulta->rowCount() > 0) {
        // Obtenemos los datos del ciudadano
        $datos_ciudadano = $consulta->fetch(PDO::FETCH_ASSOC);

        // Creamos una nueva instancia de Dompdf
        $dompdf = new Dompdf();

        // Generamos el contenido HTML de la constancia
        $fecha_actual = date("d") . " de " . date("F") . " del año " . date("Y");
        $meses_espanol = array(
            'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
        );
        
        $fecha_actual = date('d') . ' de ' . $meses_espanol[(date('n') - 1)] . ' del año ' . date('Y');
        

        $html = "
        <style>
            h1, h2 {
                text-align: center;
            }
            h1 {
                font-size: 20px;
            }
            h2 {
                font-size: 18px;
            }
            .carta-header {
                margin-bottom: 20px;
            }
        </style>
        <div class='carta-header'>
            <h1>República Bolivariana de Venezuela</h1>
            <h1>Ministerio del Poder Popular para las Comunas</h1>
            <h1>Consejo Comunal Otto Padrón RIF: C-29995247-8</h1>
            <h2>Dirección: Urb. Otto Padrón Fabricio Ojeda</h2>
            <h2>Barcelona - Edo. Anzoátegui</h2>
        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <h1>CONSTANCIA DE BUENA CONDUCTA</h1>
        <p>CONSIDERANDO:</p>
        <p>Que el (a) ciudadano (a) {$datos_ciudadano['nombre']} {$datos_ciudadano['apellido']}, venezolano (a), mayor de edad, titular de la cedula de identidad Nº {$datos_ciudadano['cedu']}, domiciliado (a) en el Consejo Comunal Otto padron, Municipio Simon Bolivar, Parroquia El carmen, Estado Anzoategui.</p>
        <p>QUE: El Consejo Comunal Otto padron, da fe de la conducta intachable del ciudadano (a) {$datos_ciudadano['nombre']} {$datos_ciudadano['apellido']}, quien ha demostrado ser una persona colaboradora y de solvencia moral dentro de nuestra comunidad.</p>
        <p>POR TANTO:</p>
        <p>El Consejo Comunal Otto padron,<br>
        CONSTATAMOS:</p>
        <p>PRIMERO: Que el (a) ciudadano (a) {$datos_ciudadano['nombre']} {$datos_ciudadano['apellido']}, mayor de edad, titular de la cedula de identidad Nº {$datos_ciudadano['cedu']}, posee una conducta intachable en nuestra comunidad.</p>
        <p>SEGUNDO: Que el (a) ciudadano (a) {$datos_ciudadano['nombre']} {$datos_ciudadano['apellido']}, ha demostrado ser una persona colaboradora y de solvencia moral dentro de nuestra comunidad.</p>
        <p>DECRETAMOS:</p>
        <p>Expidir en el día de la fecha la presente constancia de buena conducta a favor del (a) ciudadano (a) {$datos_ciudadano['nombre']} {$datos_ciudadano['apellido']}, mayor de edad, titular de la cedula de identidad Nº {$datos_ciudadano['cedu']}.</p>
        <p>Dado en la sede del Consejo Otto padron, a los dias {$fecha_actual}.</p>
        <br>
        
        
        <p style=\"text-align: center; margin-top: 50px;\">__________________________<br>
        Consejo Comunal Otto padron<br>
       
        ";
        

        // Cargamos el contenido HTML en dompdf
        $dompdf->loadHtml($html);

        // Renderizamos el PDF
        $dompdf->render();
        
        // Descargamos el PDF
        $dompdf->stream("constancia_".$datos_ciudadano['cedu'].".pdf", array("Attachment" => true));
    } else {
        echo "No se encontraron registros para la cédula proporcionada.";
        echo '<br><a href="generar_constancia.php">Volver al formulario</a>';
    }
    

    
}

?>
