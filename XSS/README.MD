# XSS Exploit Example

an XSS Vulnerability consist in sent malicuis code to a Website with the aim of infect the server or the user of a website.

### Secure code

http://localhost/Examples-of-Web-Vulnerabilities/XSS/comment.php

This website contains a HTML Form what shows the text that you sent with a POST Request.

```
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset ($_POST['comment'])) {
    $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');

    if (!empty($comment) && strlen($comment) <= 500) {
        echo("Comentario Publicado: " . $comment);
    } else {
        echo("Error por limite de caracteres, el comentario tiene un limite de 500 caracteres.");
    }
}
?>
<from method="post">
    <input type="text" name="comment">
    <button type="submit">Enviar</button>
</form>
```

If you send a simple text the website shows it.