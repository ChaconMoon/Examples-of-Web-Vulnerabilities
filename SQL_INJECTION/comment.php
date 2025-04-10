<?php
session_start();
if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}



if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                die("Error: Token CSRF inválido.");
        }
        $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
        $comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');

        if (!empty($comment) && strlen($comment) <= 50) {
                echo "Comentario publicado: " . $comment;
        } else {
                echo "Error: El comentario no puede estar vacío y debe tener máximo 50 caracteres.";
        }
}

?>
<form method="post">
<input type="text" name="comment">
<input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
<button type="submit">Enviar</button>
</form>