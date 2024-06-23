# Todo App

Todo App is a simple web application built using Laravel.
It allows users to create, read, update, and delete tasks.
The application follows Laravel's best practices and is designed to be easy to extend and maintain.

### Prerequisites

- Laravel 11 project
- Composer installed
- Basic understanding of Laravel concepts (models, controllers, routes)
- Basic understanding of GraphQL queries and mutations

### Getting Started

To get started with Todo App, follow these steps:

1. Navigate to the project directory: `cd todo-app`
1. Install dependencies: `composer install`
1. Copy the environment file: `cp .env.example .env`
1. Generate an application key: `php artisan key:generate`
1. Create a database and update the `.env` file with your database credentials.
1. Migrate the database: `php artisan migrate --seed`
1. Run the application: `php artisan serve`

### Installation

1. Install the `rebing/graphql-laravel` package using Composer:

   ```bash
   composer require rebing/graphql-laravel
   ```

2. The package will publish its configuration file to `config/graphql.php`.

### Configuration

The `config/graphql.php` file defines your GraphQL schema and endpoints.

Here's a breakdown of the important settings:

- **`schemas`**: This defines your GraphQL schemas. You can have multiple named schemas.

  ```php
  'schemas' => [
      'default' => DefaultSchema::class,
  ],
  ```

- **`schema`**: (Optional) If you don't define named schemas, you can define the default schema class directly here.

- **`http`**: This configures the GraphQL HTTP endpoint. By default, it's set to `/graphql`.

  ```php
  'http' => [
      'path' => '/graphql',
      'methods' => ['GET', 'POST'],
  ],
  ```

- **`middleware`**: You can define middleware to be applied to GraphQL requests.

### Defining GraphQL Schema

The details on how to implement graphql visit [https://github.com/rebing/graphql-laravel](/https://github.com/rebing/graphql-laravel)

### Running Tests

To test a specific test, for example, run the following command:

  ```cmd
  php artisan test --filter "can login a user"
  ```

More conprehensive discussion visit [https://laravel.com/docs/11.x/testing](/https://laravel.com/docs/11.x/testing)

### Running testing server

To run the testing server, use the following command in your terminal:

```cmd
php artisan serve
```

When you run `php artisan serve`, it starts the Laravel development server. The server runs on `http://localhost:8000` by default. You can access your Laravel application through this URL.

The server provides a convenient way to develop and test your application locally. It automatically reloads the PHP code whenever you make changes to the code.

Note: It's important to stop the server using `Ctrl + C` in the terminal when you're done testing or developing.

## Details

Visit [Collection of markdowns](/markdown/index.md)

## License

Todo App is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

