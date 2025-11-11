# Laravel Northwind Showcase

This project is intended as a showcase of my skills as a Laravel backend developer, but can be used as a basis for people who are learning Laravel.

It is based on the [SQLite version](https://github.com/jpwhite3/northwind-SQLite3) of [Microsoft's Northwind](https://github.com/microsoft/sql-server-samples/tree/master/samples/databases/northwind-pubs) database samples.

According to the [documentation](https://github.com/microsoft/sql-server-samples/tree/master/samples/databases/northwind-pubs) from Microsoft itself, "These scripts were originally created for SQL Server 2000".

This makes for a legacy database that will have quirks and what seems like intentional mistakes.

This project will consider this as a production, do-not-change, legacy database on the v1 of the API.

Plans are to add laravel-controlled fixes for a v2, as deployment scripts and migrations.

## Requirements
- PHP 8.4
- Composer 2
  
## Instalation
- After cloning the repository, assuming your environment is correctly set up, run `$ composer install`.
- Make a copy of `.env.example` to `.env`, then run `php artisan key:generate`

## Testing

This project uses [Pest](https://pestphp.com/) as it's test suite. All its capabilities are asserted using feature and unit testing.

To assert all listed features works run `$ php artisan test`

## Challeneges

### Employees
<font color="red">**(TODO: Finish description)**</font>

The `Employees` table have what seems to be a mistake, as it have a `BLOB` column called `Photo`, and a `TEXT` collumn called `PhotoPath`. This hints of a deployment mistake or ongoing change to the data structure.

Considering that BLOB storage in databases is outdated, a highly customized controller was created to assure both compliance to current storage solutions and compatbility with the legacy database.

## Features
### **Reverting `databes\northwind.db` to its original contents**
Run `composer run-script download-db` to revert the database to its original contents

### **Automatic Documentation and Swagger Generation**
By using [Scramble](https://scramble.dedoc.co/) this project is capable of providing a clear and direct documentation with little to no the need for custom code or commentary.

The documentation is available on `/docs/api`.

To generate a Swagger run `php artisan scramble:export`. It will generate the file on `./docs/laravel-northwind-showcase.json`