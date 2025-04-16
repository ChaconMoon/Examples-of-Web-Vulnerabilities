<!--
Script written by Carlos Chacón Molina

Script vulnerable for a CSRF Vulnerability
-->
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
/* Processing POST Request*/
if ($_SERVER['REQUEST_METHOD'] === "POST") {
        /* Get The Email input*/
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);

        /* Delete HTML scpecial characters*/
        $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

        /* If the Email is valid shows a text with th new E-Mail.*/
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Tu email a sido cambiado a: " . $email;
        } else {
                echo "El Email insertado no es valido";
        }
}
?>
<head>
        <link rel="stylesheet" href="../style.css">
</head>
<body>
        <!--
        Create the form to change the Email
        -->
        <div class="form">
        <h4>Cambio de correo electrónico:</h4>
                <form method="post">
                <label for="email">Nuevo Email:</label>
                <input type="text" size="40" name="email">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <br>
                <button type="submit">Enviar</button>
                </form>
                <br>
        </div>
<body>