# Ejemplo de una vulnerabilidad de Inyección de SQL

Esta vulnerabilidad consiste en tratar de obtener información de la base de datos gracias a la sintaxis de una consulta SQL

Si no tienes la base de datos de ejemplos:

### Start Database
Inicia MySQL
```
sudo systemctl start mysql
```

Logeate en MySQL
```
sudo mysql -u root -p
```

Crea la siguiente base de datos.
```
CREATE DATABASE seguridad_db;

USE seguridad_db;

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(50) NOT NULL,
password VARCHAR(100) NOT NULL
);

INSERT INTO users (username, password) VALUES ('admin', 'admin123'), ('usuario', 'pass123');
SET PASSWORD FOR 'root'@'localhost' = PASSWORD('root');

EXIT;
```

### Codigo vulnerable

http://localhost/Examples-of-Web-Vulnerabilities/SQL_INJECTION/login.php

Esta pagina web contiene un formulario que simula iniciar sesión en un sitio web:

```
<form method="post">
    <input type="text" name="username" placeholder="Usuario">
    <input type="password" name="password" placeholder="Contraseña">
    <button type="submit">Iniciar Sesion</button>
</form>
```

Y este es el codigo PHP que procesa esa petición:

```
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    echo = "Consulta ejecutada:" . $query . "<br>";

    $result = $conn->query($query)

    if ($result) {
        if ($result->num_rows > 0) {
            echo "Inicio de sesión exitoso";

            while ($row = $result->fetch_assoc()) {
                echo "ID: " $row['id'] . "Usuario: " . $row['username'] . "Contraseña: " . row['password'] . "<br>";
            }
        } else {
            echo "Usuario o contraseña incorrecta";
        }
    } else {
        echo "Error en la consulta: " . $conn->error;
    }
```

![alt text](./images/normal_login.png)

No obstante si enviamos una expresion SQL que siempre sea verdadera obtendremos como resultado todo el listado de usuarios de la base de datos.


 ```
 ' OR '1'='1' #
 ```
 
 ![alt text](./images/injection_login.png)

### Codigo securizado

http://localhost/Examples-of-Web-Vulnerabilities/SQL_INJECTION/login_securized.php

```
/* Get the statements from the posts*/
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    /* Crate de SQL Query*/
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
```

Si cambios la consulta SQL para que sea leida como un objeto statsment podremos insertar los parametros sin peligro a que nos inyecten una consulta que muestre todo el listado.

![alt text](./images/failed_injection_login.png)

