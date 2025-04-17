<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
if (isset ($_POST['comment'])) {
    echo "Comnetario publicado: " . $_POST['commnet'];

}
?>
<from method="post">
    <input type="text" name="comment">
    <button type="submit">Enviar</button>
</form>