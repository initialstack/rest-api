# Base Laravel API using Doctrine
==============================

## Overview

This example web application is built with Laravel and utilizes Doctrine ORM. It incorporates design patterns such as the Collection-Oriented Repository, Persistence-Oriented Repository, CQRS (Command Query Responsibility Segregation), Action-Domain-Responder, Decorator, and JWT authentication.

## Requirements

- PHP 8.4+
- Laravel 12.0+
- PostgreSQL 17.4+

## Installation

To deploy the project, simply run the following command:

```
$ make all
```

If your device does not have the g++ compiler installed, you can deploy manually:

\# Build and start containers

```
$ docker compose up --build -d --remove-orphans
```

\# Restart containers (if any fail during build)

```
$ docker compose up -d
```

\# Copy .env.example to .env

```
$ cp .env.example .env
```

\# Install dependencies

```
$ docker compose exec app composer install
```

\# Generate application key

```
docker compose exec app php artisan key:generate
```

\# Generate JWT key

```
$ docker compose exec app php artisan jwt:secret
```

\# Run migrations and seed the database

```
$ docker compose exec app php artisan migrate:fresh --seed
```

\# Create a symbolic link

```
$ docker compose exec app php artisan storage:link
```

## Features

- **Collection-Oriented Repository**: Simplifies data access using collection-like structures.
- **Persistence-Oriented Repository**: Manages data persistence operations like save, update, and delete.
- **CQRS**: Separates read/write operations for scalability.
- **Action-Domain-Responder**: Separates domain logic from presentation.
- **Decorator Pattern**: Extends functionality without altering core code.

## Contributing

Contributions are welcome! Here's how you can contribute:

1. **Fork the Repository**: Create a fork of this project.
2. **Create a Branch**: Make changes in a new branch.
3. **Submit a Pull Request**: Send your changes for review.

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).