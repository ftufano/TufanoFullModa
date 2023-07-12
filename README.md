# Shoe Factory Management App

This is a Laravel-based App for a shoe factory management, creation and management of customers, sellers, sell zones, customer status & categories and more, where was developed the Back End with the APIs as the No- Framework Front End

Developed By Francesco Tufano

Tufano Full Moda assets and/or other resources are from the customer

Caelum Dev Images and other resources are from my own entrepreneurship

## Deployed on the internet

The app is up and running on the internet...You can access the app [here](https://tufano.caelumdev.com/).

The App credentials are

- email: test@mail.com
- password: 4321

## Features

- Responsive Design
- Login with DB connection and session establishment
- Creation, edition and/or delete of the following:
- Customers
- Sellers
- System users(after login into the system under customer request)
- Geographical states
- Selling zones associated to the geographical states and sellers
- Categories and status for customers management
- Print of each list previously mentioned
- Encrypted passwords for users

## Runtimes & Engines

- MySQL 5.6.43
- Laravel 8
- PHP 7.3 - 8.0+
- jQuery 3.5.1
- Bootstrap 4


## Installation

Clone or get the files from the GitHub repository [here](https://github.com/ftufano/TufanoFullModa).

Install the dependencies and devDependencies and start the server. You will need to install Composer dependencies, you can do so on your CLI by typing...

```sh
composer install
```

If you use 8.0 or above you , you can do so on your CLI by typing...

```sh
composer update
```

Then look for the .env.example file which is on the root of the project, create a copy of it on the same root, then change the name to .env

Then you will need to create the database, for that, go to the project CLI and type...

```sh
php artisan db:create laravel
```

Then you will need to run the migrations in order to create the tables and their structures, for that, get back to the CLI and type...

```sh
php artisan migrate
```

Then you will need seed the DB users table with the previous mentioned default user in order to have access on the app's login, for that, get back to the CLI and type...

```sh
php artisan db:seed
```

Then get back to the CLI and start the app server by typing...

```sh
php artisan serve
```

Then access to the project through localhost URL, if you reach it, will ask to generate the app key.

And that's it, you're ready to go

## Extras

Added EER Diagram made on MySQL Workbench reffering to DB Diagram in path resources/extra_files/Tufano Full Moda App.mwb

