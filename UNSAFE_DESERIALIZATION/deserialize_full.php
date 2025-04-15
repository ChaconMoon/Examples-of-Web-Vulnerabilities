<!--
Script written by Carlos Chacón Molina

Script securiced to a Unsafe Deserialization vulnerability in where you must log in with a JSON
-->

<?php

/*Define the User Class */

class User {
    public $username;
    public $isAdmin = false;
}

/* Get the data content or create a empty object if data not exists */
$json = $_GET['data'] ?? "{}";

/*Decode the JSON*/
$data = json_decode($json, true);

/* If the JSON decoded isn't a array finish the execution*/
if (!is_array($data)) {
    die("Formato de datos no valido");
}

/* JSON Content Validation*/

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

/* If in the JSON Array Exists the isAdmin param and is true shows a text for the Admin session */
if ($data['isAdmin'] === true) {
    echo "Acceso de administrador concedido";
} else {
    echo "Acceso normal";
}
?>