# Ejemplos de Vulnerabilidades Web (por Carlos Chacón)

Este repositorio contiene 6 ejemplos diferentes de vulnerabilidades web, el código de ejemplo de cada una de ellas y cómo solventar cada una de ellas.

[English README](./README.MD)

### Despliegue con Docker

1. Asegúrate de tener **Docker Desktop** iniciado en tu sistema.
2. Clona el repositorio y entra en el directorio del proyecto:
   ```bash
   git clone https://github.com/ChaconMoon/Examples-of-Web-Vulnerabilities.git
   cd Examples-of-Web-Vulnerabilities
   ```
3. Ejecuta el entorno con Docker Compose:
   ```bash
   docker compose up -d
   ```

4. Para detener y eliminar los contenedores:
   ```bash
   docker compose down -v
   ```

Estos son los README de cada una de las vulnerabilidades que contiene el repositorio.

### [SQL Injection](./SQL_INJECTION/README_ES.MD)
### [Cross-Site Scripting (XSS)](./XSS/README_ES.MD)
### [Cross-site request forgery (CSRF)](./CSRF/README_ES.MD)
### [Remote Code Execution (RCE)](./RCE/README_ES.MD)
### [Unsafe Deserialization](./UNSAFE_DESERIALIZATION/README_ES.MD)
### [XML External Entities (XXE)](./XXE/README_ES.MD)
