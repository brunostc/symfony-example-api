# Symfony Example API

## Description

This project is built using PHP 8.1.2 and Symfony 6.4. It uses Docker and Docker Compose for containerization. The project includes an API with documentation available via Swagger.

## Prerequisites

- PHP 8.1.2
- Composer
- Docker
- Docker Compose
- Symfony CLI

## Getting Started

Follow these steps to get the project up and running:

### Step 1: Clone the repository

```bash
git clone https://github.com/brunostc/symfony-example-api
cd symfony-example-api
```

### Step 2: Run the Database

Start the database container using Docker Compose:

```bash
docker compose up -d
```

### Step 3: Run the Symfony Application

Start the Symfony application server:

```bash
symfony server:start
```

### Step 4: Access the API Documentation

Open your web browser and navigate to the following URL to view the Swagger API documentation:

[http://localhost:8000/api/doc](http://localhost:8000/api/doc)

## Useful Commands

- **Start the Symfony Server**: `symfony server:start`
- **Stop the Symfony Server**: `symfony server:stop`
- **Check Docker Compose Status**: `docker compose ps`
- **Stop Docker Compose**: `docker compose down`

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contributing

If you would like to contribute, please fork the repository and use a feature branch. Pull requests are warmly welcome.

## Acknowledgements

- [Symfony](https://symfony.com/)
- [Docker](https://www.docker.com/)
- [Swagger](https://swagger.io/)
