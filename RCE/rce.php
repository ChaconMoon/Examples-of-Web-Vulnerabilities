<?php
$allowed_cmds = ["ls", "whoami", "pwd"];
if (!isset($_GET['cmd'])) {
	die("Falta el parametro cmd");
}

$output = shell_exec(escapeshellarg($_GET['cmd']));
echo htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
?>
