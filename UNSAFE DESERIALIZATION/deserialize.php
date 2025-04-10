<?php
class User {
    public $username;
    public $isAdmin = false;
}
$data = unserialize($_GET['data']);
if ($data->$isAdmin) {
    echo "¡Acceso de administrador concedido!"
}
?>