<!--
Script written by Carlos Chacón Molina

Script vulnerable to a Unsafe Deserialization Vulnerability
-->

<?php
/*Define the User Class */

class User {
    public $username;
    public $isAdmin = false;
}

if (!isset($_GET['data'])) {
    die("Falta el parámetro data");
}

/* Show a Text if the User has isAdmin in true*/
$data = unserialize($_GET['data']);
if (!is_object($data) || !isset($data->isAdmin)) {
    die("Datos no válidos");
}

if ($data->isAdmin) {
    echo "¡Acceso de administrador concedido!";
}
?>