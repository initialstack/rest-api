# Base Laravel API using Doctrine
==============================

## Overview
-----------

This is an example web application built with Laravel, utilizing Doctrine ORM. It incorporates design patterns such as Collection-Oriented Repository, Persistence-Oriented Repository, CQRS (Command Query Responsibility Segregation), Action-Domain-Responder, Decorator, and JWT authentication.

## Requirements

- PHP 8.4+
- Laravel 12.0+
- PostgreSQL 17.4+

## Installation

To deploy the project, simply run the following command:

```
$ make all
```

## Features
--------

- **Collection-Oriented Repository**: Simplifies data access by treating data as collections.
- **Persistence-Oriented Repository**: Focuses on data persistence logic.
- **CQRS**: Separates read and write operations for better scalability.
- **Action-Domain-Responder**: Enhances request handling with a clear domain logic separation.
- **Decorator**: Allows for flexible extension of functionalities without altering core code.
- **JWT Authentication**: Provides secure token-based authentication.

## Contributing
------------

Contributions are welcome! Here's how you can contribute:

1. **Fork the Repository**: Create a fork of this project.
2. **Create a Branch**: Make changes in a new branch.
3. **Submit a Pull Request**: Send your changes for review.

## License
-------

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).