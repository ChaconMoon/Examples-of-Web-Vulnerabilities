<?php
class User {
    public $username;
    public $isAdmin = false;
}
class Exploit {
    public $cmd;
    public function __destruct() {
        system($this-> cmd);
    }
}
$data = unserialize($_GET['data']);
if ($data->isAdmin) {
    echo "¡Acceso de administrador concedido!";
}
?>