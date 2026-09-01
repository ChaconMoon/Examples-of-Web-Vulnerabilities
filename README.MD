# Examples of Web Vulnerabilities (by Carlos Chacón)

This Repository contains 6 examples of diferent web vulnerabilities, example code with each vulnerability and how secure each one.

[Spanish Readme](./README_ES.MD)

### Docker Deployment (Recommended)

1. Make sure **Docker Desktop** is running on your machine.
2. Clone the repository and navigate into the project directory:
   ```bash
   git clone https://github.com/ChaconMoon/Examples-of-Web-Vulnerabilities.git
   cd Examples-of-Web-Vulnerabilities
   ```
3. Launch the environment using Docker Compose:
   ```bash
   docker compose up -d
   ```
4. To stop and remove the containers:
   ```bash
   docker compose down -v
   ```

### Manual Deployment (Without Docker) 

In a Linux system install:

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

Start Apache:
```
sudo systemctl start apache2
```

#### Create a MySQL Database

Start MySQL:

```
sudo systemctl start mysql
```
Check if MySQL works
```
sudo systemctl status mysql
```

Create a example database:
Log in as root in mysql

```
sudo mysql -u root -p
```

Create a database:

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

#### Clone Repository

Go to the Apache html folder:

```
cd /var/www/html
```

Clone this repository:

```
git clone https://github.com/ChaconMoon/Examples-of-Web-Vulnerabilities.git
```

Connect to the index of this repository:

```
http://localhost/Examples-of-Web-Vulnerabilities/
```

### [SQL Injection](./SQL_INJECTION/README.MD)
### [Cross-Site Scripting (XSS)](./XSS/README.MD)
### [Cross-site request forgery (CSRF)](./CSRF/README.MD)
### [Remote Code Execution (RCE)](./RCE/README.MD)
### [Unsafe Deseralization](./UNSAFE_DESERIALIZATION/README.MD)
### [XML External Entities (XXE)](./XXE/README.MD)


