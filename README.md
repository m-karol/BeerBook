# Beer Forum 🍺

This is a simple PHP forum website with user registration, login, posts, and comments. The project uses PostgreSQL for the database and can be run with Docker Compose.

Directory Structure:

- `templates` contains Twig templates for rendering views
- `server` contains PHP application code
- `server/migrations` contains SQL migrations, including init.php

Building and Running

```bash
    docker compose up --build
```

The site is served at http://localhost:8080

ERD:
![alt text](https://raw.githubusercontent.com/m-karol/BeerBook/refs/heads/main/ERD.png)
