# Ejemplos de vulnerabilidades web (por Carlos Chacón)

Este repositorio contiene 6 ejemplos de diferentes vulnerabilidades y el un ejemplo de codigo de cada una de ellas al igual que como solventar cada una de ellas.

[English Readme](./README_ES.MD)

### How it Works? 

En un equipo con Linux instala lo siguiente:

- Apache2 server
- PHP (Lasted Version)
- libapache2-mod-php
- mariadb-server
- mariadb-client
- php-mysql
- php-xml

```
sudo apt update && sudo apt install apache2 php libapache2-mod-php mariadb-server mariadb-client php-mysql php-xml -y
```

Inicia Apache:
```
sudo systemctl start apache2
```

#### Create a MySQL Database

Inicia MySQL:

```
sudo systemctl start mysql
```
Comprueba si el servicio MySQL funciona:
```
sudo systemctl status mysql
```

Crea una base de datos de ejemplo:

Inicia sesión como root

```
sudo mysql -u root -p
```

Crea unqa base de datos:

```
CREATE DATABASE seguridad_db;
USE seguridad_db;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL
);
INSERT INTO users (username, password) VALUES ('admin', 'admin123'), ('usuario', 'pass123');
SET PASSWORD FOR 'root'@'localhost' = PASSWORD('root');
EXIT;
```

#### Clonación del repositorio

Muevete hacia la carpeta del servidor Apache:

```
cd /var/www/html
```

Clona este repositorio:

```
git clone https://github.com/ChaconMoon/Examples-of-Web-Vulnerabilities.git
```

Conectate al indice de este repositorio:

```
http://localhost/Examples-of-Web-Vulnerabilities/
```

### [SQL Injection](./SQL_INJECTION/README_ES.MD)
### [Cross-Site Scripting (XSS)](./XSS/README_ES.MD)
### [Cross-site request forgery (CSRF)](./CSRF/README_ES.MD)
### [Remote Code Execution (RCE)](./RCE/README_ES.MD)
### [Unsafe Deseralization](./UNSAFE_DESERIALIZATION/README_ES.MD)
### [XML External Entities (XXE)](./XXE/README_ES.MD)


