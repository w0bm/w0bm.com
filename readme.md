## w0bm.com

[![IRC Chat](https://img.shields.io/badge/chat-irc-green.svg)](https://webirc.n0xy.net/#w0bm)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

[w0bm.com](https://w0bm.com) is a fun modern website featuring many different kind of videos in webm format. It was initially thought as a [z0r.de](http://z0r.de) without flash, but already surpassed that in our opinion.

The page is build on top of the [Laravel Framework](https://laravel.com).

## Installing

1. Clone this repository: `git clone https://github.com/w0bm/w0bm.com.git`
2. Cd into the directory: `cd w0bm.com`, run `./composer.phar dump-autoload` and `./composer.phar install` to install all the dependencies
3. Create a .env file with your database information. ([Example](https://github.com/laravel/laravel/blob/master/.env.example)) and also set the `APP_KEY` (you can generate one with `php artisan key:generate`)
4. Put at least 1 webm file in the `public/b` folder named `1.webm`
5. Modify `database/seeds/DatabaseSeeder.php` and uncomment all the different seeders. (Initially you'll need all)
6. Run `php artisan migrate` and then `php artisan db:seed`
7. Start the development server with `php artisan serve`
8. Check your website at `http://localhost:8000` (username: admin, password: password)

## Contributing

Make your changes, test them locally (PLEASE!!! preferable write some unit tests aswell) and make a pull request.

Folder structure:  
- Models: `app/Models/`
- Routes: `app/Http/routes.php`
- Controllers: `app/Http/Controllers`
- Views: `resources/views`
- JS and CSS: `public/{css,js}`
- Database: `database/migrations`

To transpile and minify your modified w0bmscript.js you need to have npm (Node Package Manager) and this projects dependencies installed (dependencies installable with `npm i`). Then run `npm run build`.

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
