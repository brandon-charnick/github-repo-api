# Most Starred PHP GitHub Repositories

## Description

This is a `Symfony 6` application built with `Docker` and `Docker Compose V2` that lists the most starred PHP repositories on GitHub.

It is composed of the following containers:

| Container | Image |
| ----------- | ----------- |
| php | `php:8.2-fpm` |
| nginx | `nginx:stable-alpine` |
| mysql | `mysql:8.0.28` |

## Usage

### Running the application

1. Clone this repository
2. Run `docker compose up`, or `docker compose up -d` to run the containers as daemons
3. Visit http://localhost

### Container start notes

The PHP container will automatically install all composer dependencies and preload the database with the top 10 PHP repositories.