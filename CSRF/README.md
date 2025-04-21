# CSRF Vulnerability Example

A CSRF Vulnerability is an attack that uses your login cookie to send requests to a server in your name for example to change your email or password of your account.

### Vulnerable Website

http://localhost/Examples-of-Web-Vulnerabilities/CSRF/api/UnsafeIndex.php

```
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

        $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Tu email a sido cambiado a: " . $email;
        } else {
                echo "El Email insertado no es valido";
        }
}
?>
```
```
<form method="post">
    <label for="email">Nuevo Email:</label>
    <input type="text" size="40" name="email">
    <br>
    <button type="submit">Enviar</button>
</form>
```

In this case we have a form to change the email of your account:

![alt text](./images/CSFR%20Form%20Example.png)

Nevertheless this website doesn't verify if the post requests were sent to this website or to another, an attacker can use this to create a malicious website that replicates the original site and send fake info in the form.

http://localhost/Examples-of-Web-Vulnerabilities/CSRF/UnsafeFakeForm.html

```
<form method="post" action="./api/index.php">
    <label for="notemail">Nuevo Email:</label> 
        <!-- Fake input for the user email -->
        <input type="text" size="40" name="notemail">
        <!-- Hidden input with the attacker Email -->
        <input type="hidden" value="attacker@deepweb.com" name="email">
        <br>
    <button type="submit">Enviar</button>
</form>
```

If you sent an email, the real email that will be sent is attacker@deepweb.com

![alt text](./images/Change_Email_Attack.png)

### Secure Website

http://localhost/Examples-of-Web-Vulnerabilities/CSRF/api/index.php

For preventing that any website can send a Requests to this form you must creacte a CSRF Token, sending it in the form and before do any changes in the website verify that the token exists.

```
<?php
/* Session Token creation*/
session_start();
if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
/* Processing POST Request*/
if ($_SERVER['REQUEST_METHOD'] === "POST") {
        /* Check the session token if the token exists and is different to the actual token*/
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Error: Token CSRF inválido.");
        }
        /* Validate Email Input */
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

        /* Deletes the special HTML Characteres*/
        $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

        /* If the Email is valid shows a text with th new E-Mail.*/
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Tu email a sido cambiado a: " . $email;
        } else {
                echo "El Email insertado no es valido";
        }
}
?>
```

And send this token in the form

```
<form method="post">
    <label for="email">Nuevo Email:</label>
    <input type="text" size="40" name="email">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>"> <!--Input with the CSRF Token -->
    <br>
    <button type="submit">Enviar</button>
</form>
```

Using this form that sent a POST Requests to the secure website you can see that the secure website blocks the requests.

http://localhost/Examples-of-Web-Vulnerabilities/CSRF/FakeForm.html

![alt text](./images/Fail_Change_Mail_Attack.png)


