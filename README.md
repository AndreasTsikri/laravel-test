# Laravel API Project

This repository contains a Laravel API application that uses Docker for local development. It supports user registration, authentication with bearer tokens, and pivot table relationships.

---

## Prerequisites

Make sure you have installed the following:

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

---

## Getting Started

Follow these steps to get the project running locally:

### 1. Clone the repository

```bash
git clone https://github.com/your-username/your-repo.git
cd your-repo
```
### 2. Run Migrations

Before starting the containers, ensure your database schema is created. You can run migrations directly from Docker after the containers are up.
```bash
docker-compose run --rm app php artisan migrate
```
### 3.3. Build Docker Containers

Build your Docker environment with:

docker-compose build

### 4. Start Docker Containers

Run the containers in detached mode:
```bash
docker-compose up -d
```

This will start:

The Laravel application

The database (MySQL/PostgreSQL, depending on your Dockerfile setup). Here i have all the details inside the cloned dockerfile!

### 5. Access the Application

Once running, the Laravel API should be available at:

http://localhost:8080

Adjust the port in the docker-compose.yml if needed.

Environment Variables

All environment variables are defined directly in the Dockerfiles. You do not need a .env file for local development.

If you want to override variables locally, you can:

docker-compose exec app bash
export APP_ENV=local
export APP_DEBUG=true

Running API Requests

You can use curl, Postman, or any API client.

Example: Register a User
curl -X POST http://localhost:8080/api/register \
     -H "Content-Type: application/json" \
     -d '{"username":"john"}'


Response:

{
  "message": "User registered successfully",
  "username": "john",
  "bearer token": "random_generated_token"
}

Example: Login (if implemented)
curl -X POST http://localhost:8080/api/login \
     -H "Content-Type: application/json" \
     -d '{"username":"john"}'


Response:

{
    "message":"User registered successfully",
    "username":"me2",
    "bearer token":"AOeIDkkp4JqHieOX"}

### 6. Stop Docker Containers
```bash
docker-compose down 
```

## Notes

The simpleBearerToken is stored NOT hashed in the database. Always return the plain token to the user when registering or logging in.

API routes are defined in routes/api.php.

All migrations and seeding are handled via Laravel artisan commands inside the php-cli Docker container.

Recommended Workflow

Clone repo → cd into project

Build Docker → docker-compose build

Start containers → docker-compose up -d

Run migrations → docker-compose run --rm app php artisan migrate:fresh --seed

Test API via curl or Postman

License

This project is licensed under the MIT License.
