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
docker-compose run --rm php-cli  php artisan migrate
```
### 3 Build Docker Containers

Build your Docker environment with:
```bash
docker-compose build
```
### 4. Start Docker Containers

Run the containers in detached mode:
```bash
docker-compose up -d
```
(*Important: You can build and run docker compose in one step by using 
```bash
docker-compose up -d --build
```)
This will start:

The Laravel application (as all indepentent containers like nginx and php-fpm running!)

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

Example: Register (to get a bearer token!)
curl -X POST http://localhost:8080/api/register \
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

### 7.visit API routes

For slots you must provide specialistId(1,2,...) and service('maniqure')

To CREATE an appointment 1) register to get bearer token 2)see slots through slots route 3)call POST on  appointments/store URL and  specicfy service id, specialist id and starting datetime of slot on the create route!

To CANCEL an appointment call DELETE on appointments/id URL  with the appointment id to delete!


## Notes

The simpleBearerToken is stored NOT hashed in the database. Always return the plain token to the user when registering or logging in.

API routes are defined in routes/api.php.

All migrations and seeding are handled via Laravel artisan commands inside the php-cli Docker container.

Dont forget to include the Bearer token on the url calls!

## Recommended Workflow

Clone repo → cd into project

Build Docker → docker-compose build

Start containers → docker-compose up -d

Run migrations → docker-compose run --rm php-cli php artisan migrate:fresh --seed

Test API via curl or Postman

License

This project is licensed under the MIT License.
