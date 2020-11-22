# Nebraska 2018 FBI Crime Data Analysis
## By Chris Galusha

This project was written using the [Laravel PHP Frawework](https://laravel.com/docs) (version 8) with [Vue.js](https://vuejs.org/) and [Chart.js](https://www.chartjs.org/).

The database used was [MySQL](https://www.mysql.com/).

To get this running on your machine:

Install [Composer](https://getcomposer.org/), PHP's package manager.

Install [NPM](https://www.npmjs.com/).

Install [PHP](https://www.php.net/) version 7.3+ and the following PHP extensions:

- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

Run the command `composer global require laravel/installer`

Go into the FinalProject directory and edit the file `.env`. Look at the Database configuration block:

```
DB_CONNECTION=mysql (if using a different database driver, see below)
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=finalproject
DB_USERNAME=<your db username>
DB_PASSWORD=<your db password>
```

Laravel database configuration (if you aren't using mysql): https://laravel.com/docs/8.x/database#configuration

With a terminal, cd to the FinalProject directory and run `composer install; npm install; php artisan serve`

This will start a web server running at `localhost:8000`, which you can navigate to with a web browser.
The index page should offer navigation to all the available analyses.
