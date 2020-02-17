# SimpleBookListLaravel

This project is meant to be run in a development environment with PHP and Laravel installed.
The whole project has been tested on Windows OS and Laravel 6.15.0.

To start using the project, please open a command terminal inside the repository folder, then do the following:

- On the command terminal, run: **composer install**
- Move the contents of the .env.example file to .env.
On windows, to get around the mandatory filename limitation, run the following command on your terminal: **xcopy .env.example .env**
- On the command terminal, run: **php artisan key:generate**
- Create the *database/database.sqlite* file.
- On the command terminal, run: **php artisan migrate**

There is no database configuration since data is stored in the *database/database.sqlite* file that has been created.