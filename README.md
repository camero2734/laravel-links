# Laravel Links

## Description
This project was made using the [Laravel Breeze template](https://github.com/laravel/breeze). This covered the
authentication, layout, and styling for the project.

The project is a simple link sharing platform. Users can create links and share them with others. Users can also edit, and delete their own links.

A list of files that were added by me:
- `app/Http/Controllers/LinkController.php`
- `app/Models/Link.php`
- `database/migrations/2024_04_27_121208_create_links_table.php`
- `routes/link.php`
- `resources/js/Components/LinkItem.vue`
- `resources/js/Pages/Dashboard.vue`

Links are generated using Nanoid to create a 10 character string using the alphabet from [Crockford's Base32](http://www.crockford.com/base32.html). This creates a short, unique identifier for each link that has unambiguous characters so it
can be manually typed, if needed.

## Running
This project uses Laravel 11 and also requires PHP 8.0.0 or higher.

To run this project, you will need to have PHP installed on your machine. You can download PHP from the [official PHP website](https://www.php.net/downloads). You will also need to have Composer installed on your machine. You can download Composer from the [official Composer website](https://getcomposer.org/download/).

Once you have PHP and Composer installed, you can run the following commands to set up the project:

```bash
composer install
php artisan migrate
```

Then run these two commands to start the frontend and backend servers (in separate terminals)

```bash
php artisan serve
npm run dev
```

You can then access the project in your web browser at `http://localhost:8000`.
