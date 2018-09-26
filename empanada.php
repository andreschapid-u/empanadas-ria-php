<?php
date_default_timezone_set("America/Bogota");

class Empanada{
    public $fecha;
    public $cantidad;
    public $imagen = "./empanada.jpg";

     function __construct($cantidad = 0) {
         $this->cantidad = $cantidad;
        //  $this->fecha = date("Y-m-d H:i:s");
         // $this->fecha = getdate();
        $this->fecha = (new DateTime())->format("Y-m-d H:i:s");
    }
} 
$nombreArchivo = "empanadas.json";

// verificamos si el archivo "empanadas.json" existe
if( !file_exists($nombreArchivo) ){
    // Creamos la estructura para el nuevo archivo
    $nuevo = new stdClass();
    $nuevo->empanadas=[];
    $nuevo->fechaModificacion="";
    $nuevo->total=0;

    // Abrimos el archivo, como no existe se creara!
    // $nuevoArchivo = fopen($nombreArchivo, "x") or die("No se puede abrir el archivo!");
    // fwrite($nuevoArchivo, json_encode($nuevo));
    // fclose($nuevoArchivo);
    file_put_contents($nombreArchivo, json_encode($nuevo));
}

if(isset($_GET["cantidad"])){
    $nuevaEmpanada = new Empanada(intval($_GET["cantidad"]));
    //Obtengo ifo del archivo json
    $archivo = json_decode(file_get_contents($nombreArchivo));

    $archivo->fechaModificacion = $nuevaEmpanada->fecha;
    array_push($archivo->empanadas, $nuevaEmpanada);
    $archivo->total =0;
    foreach ($archivo->empanadas as $empanada) {
        $archivo->total += $empanada->cantidad;
        # code...
    }
    
    // $archivoEmpanadas = fopen($nombreArchivo, "w") or die("No se puede abrir el archivo!");
    // fwrite($archivoEmpanadas, json_encode($archivo));
    // fclose($archivoEmpanadas);
    // file_put_contents($nombreArchivo, json_encode($archivo), FILE_APPEND);
    file_put_contents($nombreArchivo, json_encode($archivo));
}

header('Content-type: application/json; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
echo  file_get_contents($nombreArchivo);
exit();

