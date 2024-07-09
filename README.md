# Symfony Example API

## Description

This project is built using PHP 8.1.2 and Symfony 6.4. It uses Docker and Docker Compose for containerization. The project includes an API with documentation available via Swagger.
It is under construction and may receive updates.

## Prerequisites

- Docker
- Docker Compose

## Getting Started

Follow these steps to get the project up and running:

### Step 1: Clone the repository

```bash
git clone https://github.com/brunostc/symfony-example-api
cd symfony-example-api
```

### Step 2: Run the containers

Build and start all the containers:

```bash
docker compose up -d --build
```
After the process is finished proceed to Step 3.

### Step 3: Install composer dependencies and migrate Database

```bash
docker exec symfony-example-api-php-fpm-1 composer install
docker exec symfony-example-api-php-fpm-1 php bin/console doctrine:migrations:migrate
```

### Step 4: Access the API Documentation

Open your web browser and navigate to the following URL to view the Swagger API documentation:

[http://localhost:8080/api/doc](http://localhost:8080/api/doc)

## Useful Commands

- **Check Docker Compose Status**: `docker ps`
- **Stop Docker Compose**: `docker compose down`

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contributing

If you would like to contribute, please fork the repository and use a feature branch. Pull requests are warmly welcome.

## Acknowledgements

- [Symfony](https://symfony.com/)
- [Docker](https://www.docker.com/)
- [Swagger](https://swagger.io/)
