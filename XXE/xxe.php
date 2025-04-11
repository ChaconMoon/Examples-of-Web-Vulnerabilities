<?php

# Crear un objeto DOMDocument
$dom = new DOMDocument();

# Habilitar cargas de contenido externas (solo para pruebas)
$dom = loadXML(file_get_contents('php://input'), LIBXML_NOENT | LIBXML_DTDLOAD);

# Convertir el XML a un objeto SimpleXMLElement (opcional)
$parsed = socket_import_dom($dom);

# Mostrar el resultado
echo $parsed;
?>