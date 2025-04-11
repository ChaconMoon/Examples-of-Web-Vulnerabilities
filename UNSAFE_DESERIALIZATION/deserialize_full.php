<?php
class User {
    public $username;
    public $isAdmin = false;
}

// Obtención y decodificación de los datos JSON
$json = $_GET['data'] ?? "{}"; 
$data = json_decode($json, true);

// Validar la decodificación de los datos
if (!is_array($data)) {
    die("Formato de datos no valido");
}

//Validación extricta de las claves insertadas

$validKeys = ['username', 'isAdmin'];

foreach ($data as $key => $value) {
    if (!in_array($key, $validKeys,true)) {
        die("Error: Clave invalida detectada ('$key').");
    }
}

if (!isset($data['username']) || !is_string($data['username'])) {
    die("Error: El nombre de usuario debe ser una cadena de texto");
}

if (!isset($data['isAdmin']) || !is_bool($data['isAdmin'])) {
    die("Error: isAdmin debe ser un booleano {true/false}.");
}


if ($data['isAdmin'] === true) {
    echo "Acceso de administrador concedido";
} else {
    echo "Acceso normal";
}
?>