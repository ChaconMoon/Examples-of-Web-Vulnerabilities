<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

# Crear un objeto DOMDocument
$dom = new DOMDocument();

# Habilitar cargas de contenido externas (no valora entidades externas)
$dom->loadXML(file_get_contents('php://input'), LIBXML_NOENT | LIBXML_DTDLOAD);

if (strpos(file_get_contents('php//input'), "<!ENTITY") !== false){
    die("No se permiten entidades externas");
}

# Convertir el XML a un objeto SimpleXMLElement (opcional)
$parsed = simplexml_import_dom($dom);

# Mostrar el resultado
echo $parsed;
?>
