<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$db_host = getenv('DB_HOST') ?: 'db';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASSWORD') ?: 'root';
$db_name = getenv('DB_NAME') ?: 'seguridad_db';
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    echo "Consulta ejecutada:" . $query . "<br>";

    $result = $conn->query($query);

    if ($result) {
        if ($result->num_rows > 0) {
            echo "Inicio de sesión exitoso ";

            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row['id'] . " Usuario: " . $row['username'] . " Contraseña: " . $row['password'] . "<br>";
            }
        } else {
            echo "Usuario o contraseña incorrecta";
        }
    } else {
        echo "Error en la consulta: " . $conn->error;
    }
}
?>

<form method="post">
    <input type="text" name="username" placeholder="Usuario">
    <input type="password" name="password" placeholder="Contraseña">
    <button type="submit">Iniciar Sesion</button>
</form>