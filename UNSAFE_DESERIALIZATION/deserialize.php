<?php
class User {
    public $username = "hacker";
    public $isAdmin = true;
}
$data = unserialize($_GET['data']);
if ($data->$isAdmin) {
    echo "¡Acceso de administador concedido!"
}
echo urldecode(serialize(new User()))
?>