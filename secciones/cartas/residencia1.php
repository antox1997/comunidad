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
    $consulta = $conexion->prepare("SELECT lc.*, c.nombreCalle AS nombre_calle FROM libreria_ciudadano lc JOIN libreria_calle c ON lc.idcalle = c.id WHERE lc.cedu = :cedula");

    $consulta->bindParam(":cedula", $cedula);
    $consulta->execute();

    // Verificamos si se encontraron resultados
    if($consulta->rowCount() > 0) {
        // Obtenemos los datos del ciudadano
        $datos_ciudadano = $consulta->fetch(PDO::FETCH_ASSOC);

        // Creamos una nueva instancia de Dompdf
        $dompdf = new Dompdf();

        // Establecemos la configuración regional a español
        setlocale(LC_TIME, 'es_ES.UTF-8');

        // Obtenemos la fecha actual
        $fecha_actual = strftime("%d de %B del año %Y", strtotime("now"));
        $meses_espanol = array(
            'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
        );
        
        $fecha_actual = date('d') . ' de ' . $meses_espanol[(date('n') - 1)] . ' del año ' . date('Y');
        

        // Generamos el contenido HTML de la constancia
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
        
        


        <h2>CARTA DE RESIDENCIA</h2>
        <p>El Consejo Comunal de Otto Padrón, identificado según registro N° 03-08-01-001-0089 de la urbanización Otto Padrón de la ciudad de Barcelona, hace constar por medio de la presente que:</p>
        <p><strong>El (la) ciudadano (a):</strong> {$datos_ciudadano['nombre']} {$datos_ciudadano['apellido']}</p>
        <p><strong>Venezolano (a), mayor de edad, portador de la cédula de identidad N°:</strong> V-{$datos_ciudadano['cedu']}</p>
        <p><strong>Tiene su residencia fija en la parroquia El Carmen, Municipio Simón Bolívar del Estado Anzoátegui, Calle/Avenida:</strong> {$datos_ciudadano['nombre_calle']}</p>
        <p>Desde hace aproximadamente 1 año, mostrando una conducta de sana convivencia, de respeto a sus vecinos y a las leyes de la República Bolivariana de Venezuela.</p>

        <p>Constancia que se expide a petición de parte interesada, en la ciudad de Barcelona a los {$fecha_actual}.</p>
        <p>Certifica su validez por un lapso de seis (06) meses.</p>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
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
