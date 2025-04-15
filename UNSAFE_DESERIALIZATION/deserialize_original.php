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
/* Show a Text if the User has isAdmin in true*/

$data = unserialize($_GET['data']);
if ($data->isAdmin) {
    echo "¡Acceso de administrador concedido!";
}
?>