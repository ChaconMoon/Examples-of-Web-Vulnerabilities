# Ejemplo de una vulnerabilidad de Inyección de SQL

Esta vulnerabilidad consiste en tratar de obtener información de la base de datos gracias a la sintaxis de una consulta SQL.

> [!NOTE]
> Para probar esta vulnerabilidad debes tener levantado el contenedor de Docker con la base de datos, ya que nos conectaremos a ella.

### Código vulnerable

http://localhost:8080/SQL_INJECTION/login.php

Esta página web contiene un formulario que simula iniciar sesión en un sitio web.

Las credenciales de inicio de sesión son las siguientes: 
- usuario: admin
- contraseña: admin123

```
<form method="post">
    <input type="text" name="username" placeholder="Usuario">
    <input type="password" name="password" placeholder="Contraseña">
    <button type="submit">Iniciar Sesion</button>
</form>
```

Y este es el código PHP que procesa esa petición:

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

No obstante, si enviamos una expresión SQL que siempre sea verdadera, obtendremos como resultado todo el listado de usuarios de la base de datos:

```
 ' OR '1'='1' #
```

![alt text](./images/injection_login.png)

Con esta petición lo que estamos haciendo es "ignorar" la petición de usuario y contraseña para que directamente busque todos los resultados, al indicar que nos muestre los registros donde "1" sea igual a "1" (condición que siempre se cumple).

Normalmente en los inicios de sesión se obtiene el primer usuario coincidente (que si el nombre de usuario es único debería ser el único). No obstante, como devolvemos toda la tabla, obtenemos el usuario con el primer ID, que en la mayoría de los casos es el administrador por ser el primer usuario creado.

### Código seguro

http://localhost:8080/SQL_INJECTION/login_securized.php

```
/* Get the statements from the posts*/
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    /* Crate de SQL Query*/
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
```

Si cambiamos la consulta SQL para que se ejecute mediante sentencias preparadas (*prepared statements*), podremos insertar los parámetros sin peligro a que inyecten una consulta que muestre todo el listado. Esto se debe a que los parámetros se tratan estrictamente como datos y no como código ejecutable. Podremos acceder con las credenciales reales, pero si intentamos una inyección SQL no nos lo permitirá porque no existe ningún usuario cuyo nombre sea `' OR '1'='1' #` sin contraseña.

![alt text](./images/failed_injection_login.png)
