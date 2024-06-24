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

When you run `php artisan serve`, it starts the Laravel development server. The server runs on `http://localhost:8000` by default. You can access your Laravel application through this URL.

The server provides a convenient way to develop and test your application locally. It automatically reloads the PHP code whenever you make changes to the code.

Note: It's important to stop the server using `Ctrl + C` in the terminal when you're done testing or developing.

## License

Todo App is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

### Documentation

[Continue to documentation](/readme/page-0001.md)