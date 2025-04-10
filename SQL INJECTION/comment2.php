<?php
session_start();
if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}



if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Error: Token CSRF inválido.");
        }
        if (isset($_POST['comment'])) {
                echo "Comentario publicado: " . $_POST['comment'];
        }
}

?>
<form method="post">
<input type="text" name="comment">
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
<button type="submit">Enviar</button>
</form>