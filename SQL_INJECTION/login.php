<!--
Script written by Carlos Chacón Molina

Script securited for a SQL Injection
-->
<?php
/* Create a MYSQL Connection*/
$conn = new mysqli("localhost", "root", "root", "seguridad_db");

/* Finish the execution if the connection fail*/
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
/*Processing the post recuests */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /* Get the statements from the posts*/
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    /* Crate de SQL Query*/
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? AND
    password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    /* Check if the user is in the database */
    $result = $stmt->get_result();
        if ($result->num_rows > 0) {
        echo "Inicio de sesión exitoso<br>";
        /* Show the Query Result */
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row['id'] . " - Usuario: " . $row['username'] . " - Contraseña: "
            . $row['password'] . "<br>";
        }
        } else {
            /* If the user not exists show this text */
        echo "Usuario o contraseña incorrectos";
        }
    $stmt->close();
}
$conn->close();
?>

<!--
Form to do a query in in the MySQLite Database.
-->
<form method="post">
    <input type="text" name="username" placeholder="Usuario">
    <input type="password" name="password" placeholder="Contraseña">
    <button type="submit">Iniciar Sesión</button>
</form>