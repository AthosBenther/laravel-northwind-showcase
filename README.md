# Laravel Northwind Showcase

This project is intended as a showcase of my skills as a Laravel backend developer, but can be used as a basis for people who are learning Laravel.

It is based on the [SQLite version](https://github.com/jpwhite3/northwind-SQLite3) of [Microsoft's Northwind](https://github.com/microsoft/sql-server-samples/tree/master/samples/databases/northwind-pubs) database samples.

Most of the features and work around the Northwind's database quirks will be explained in the commentaries in the code itself.

## Requirements
- PHP 8.4
    - **Extensions:**
    - curl
    - fileinfo
    - gd
    - mbstring
    - pdo_sqlite
    - zip
- Composer 2
  
## Instalation
- After cloning the repository, assuming your environment is correctly set up, run `$ composer install`.
- Make a copy of `.env.example` to `.env`, then run `php artisan key:generate`

## Testing

This project uses [Pest](https://pestphp.com/) as it's test suite. All its capabilities are asserted using feature and unit testing.

To assert all listed features works run `$ php artisan test`

## Features
### **Reverting `databes\northwind.db` to its original contents**
Run `composer run-script download-db` to revert the database to its original contents

### **Automatic Documentation and Swagger Generation**
By using [Scramble](https://scramble.dedoc.co/) this project is capable of providing a clear and direct documentation with little to no the need for custom code or commentary.

The documentation is available on `/docs/api`.

To generate a Swagger run `php artisan scramble:export`. It will generate the file on `./docs/laravel-northwind-showcase.json`