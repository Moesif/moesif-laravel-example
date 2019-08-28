# Moesif Laravel Example

Laravel is a web application framework that many developers to serve APIs.

Moesif is an API analyatics and monitoring platform. [moesif-laravel](https://github.com/Moesif/moesif-laravel)
is a middleware that makes integration with Moesif easy for Laravel based applications.

This is an example of laravel application with Moesif integrated.

## Key files

moesif-laravel's github readme already documented the steps for setup,
so following those instruction, these files are modified in relation to the
standard files of Laravel app.

- `app/Http/Kernel.php` added Moesif middleware.

- `config/moesif.php` this is the settings for Moesif Middleware with example options.

If you are going to run this example, please remember to go to `config/moesif.php`
and update with application id with your actual application id.

Your Moesif Application Id can be found in the [_Moesif Portal_](https://www.moesif.com/).
After signing up for a Moesif account, your Moesif Application Id will be displayed during the onboarding steps. 

You can always find your Moesif Application Id at any time by logging 
into the [_Moesif Portal_](https://www.moesif.com/), click on the top right menu,
and then clicking _Installation_.

## How to run.

Step 1: Install all dependencies by `composer install` or `composer update`. See [composer](https://getcomposer.org) for more information. 

Step 2: Please follow standard [Homestead setup instructions](https://laravel.com/docs/4.2/homestead) from Laravel

There are several routes for testing APIs and none JSON webpages.
Please see `routes/api.php` for available routes for testing.
