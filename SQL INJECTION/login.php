<?php
$conn = new mysqli("localhost", "root", "root", "seguridad_db");
if ($conn->connect_error) {
die("Error de conexión: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$username = trim($_POST["username"]);
$password = trim($_POST["password"]);
$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? AND
password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
echo "Inicio de sesión exitoso<br>";
// Mostrar datos extraídos de la consulta
while ($row = $result->fetch_assoc()) {
echo "ID: " . $row['id'] . " - Usuario: " . $row['username'] . " - Contraseña: "
. $row['password'] . "<br>";
}
} else {
echo "Usuario o contraseña incorrectos";
}
$stmt->close();
}
$conn->close();
?>
<form method="post">
<input type="text" name="username" placeholder="Usuario">
<input type="password" name="password" placeholder="Contraseña">
<button type="submit">Iniciar Sesión</button>
</form>