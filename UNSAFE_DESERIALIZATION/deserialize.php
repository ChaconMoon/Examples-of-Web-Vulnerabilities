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

/*Define the Exploit Class */
class Exploit {
    public $cmd;
    
    /* Execute the command in the cmd param when the object is destoyed */
    public function __destruct() {
        system($this->cmd);
    }
}

if (!isset($_GET['data'])) {
    die("Falta el parámetro data");
}

/* Show a Text if the User has isAdmin in true*/
$data = unserialize($_GET['data']);
if (is_object($data) && isset($data->isAdmin)) {
    if ($data->isAdmin) {
        echo "¡Acceso de administrador concedido!";
    }
    exit;
}

if (is_object($data)) {
    // This example intentionally exploits __destruct() when the object is destroyed.
    // No extra output is required here; the command runs as part of the request lifecycle.
}
?>