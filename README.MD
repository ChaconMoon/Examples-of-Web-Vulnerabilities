# Examples of Web Vulnerabilities (by Carlos Chacón)

This repository contains 6 examples of different web vulnerabilities, example code for each vulnerability, and how to fix each one.

[Spanish README](./README_ES.MD)

### Docker Deployment

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

These are the README files for each vulnerability contained in the repository.

### [SQL Injection](./SQL_INJECTION/README.MD)
### [Cross-Site Scripting (XSS)](./XSS/README.MD)
### [Cross-site request forgery (CSRF)](./CSRF/README.MD)
### [Remote Code Execution (RCE)](./RCE/README.MD)
### [Unsafe Deserialization](./UNSAFE_DESERIALIZATION/README.MD)
### [XML External Entities (XXE)](./XXE/README.MD)
