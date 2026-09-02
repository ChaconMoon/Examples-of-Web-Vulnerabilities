# Example of SQL Injection Vulnerability

This vulnerability consists of attempting to extract information from the database using SQL query syntax manipulation.

> [!NOTE]
> To test this vulnerability, you must have the Docker container running with the database, as we will connect to it.

### Vulnerable Code

http://localhost:8080/SQL_INJECTION/login.php

This webpage contains a form that simulates logging into a website.

The login credentials are as follows:
- username: admin
- password: admin123

```
<form method="post">
    <input type="text" name="username" placeholder="Usuario">
    <input type="password" name="password" placeholder="Contraseña">
    <button type="submit">Iniciar Sesion</button>
</form>
```

And this is the PHP code that processes the request:

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

However, if we send an SQL expression that always evaluates to true, we will obtain the entire list of users from the database:

```
 ' OR '1'='1' #
```

![alt text](./images/injection_login.png)

With this request, we bypass the username and password check, forcing the query to return all results because "1" equals "1" is always true.

Typically, login systems authenticate the first matching user record (which should be unique). However, since the entire table is returned, the user with the first ID is retrieved (which in most cases is the administrator, being the first account created).

### Secure Code

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

If we update the SQL query to use prepared statements, parameters can be safely bound without risking SQL query injection. Parameters are treated strictly as data literals. We can log in with valid credentials, but SQL injection attempts will fail because no user literally named `' OR '1'='1' #` exists.

![alt text](./images/failed_injection_login.png)
