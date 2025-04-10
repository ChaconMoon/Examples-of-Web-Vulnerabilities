<?php
class User {
    public $username;
    public $isAdmin = false;
}

$json = $_GET['data'] ?? "{}" // Si no se pasa nada como paraemtro data lo interpetara como un fichero

$data = json_decode($json, true);


if (!is_array($data)) {
    die("Formato de datos no valido");
}

if (isset ($data ["isAdmin"]) & $data("isAdmin") === true) {
    echo "Acceso de administrador concedido";
} else {
    echo "Acceso normal";
}
?>