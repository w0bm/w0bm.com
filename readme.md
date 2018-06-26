# w0bm.com
![w0bm](https://i.imgur.com/hPvnspu.png "w0bm logo")

[![IRC Chat](https://img.shields.io/badge/chat-irc-green.svg)](https://webirc.n0xy.net/?join=%23w0bm)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

[w0bm.com](https://w0bm.com) is a fun modern website featuring many different kind of videos in webm format. It was initially thought as a [z0r.de](http://z0r.de) without flash, but already surpassed that in our opinion.

The page is build on top of the [Laravel Framework](https://laravel.com).

# Contents
1. Dependencies
2. Installation

# Dependencies
Our prefered distribution is Arch Linux, so all of the commands will be for Arch Linux and can be modified for the distro of your choice, the names of the packages may be different.

`sudo pacman -S php php-fpm composer mariadb nginx ffmpeg imagemagick npm`

w0bm requires at least PHP 7.1 to work!

# Preparation
This includes recommended settings for w0bm to work!

## Database
Before you can get started you need to set up mariadb, nginx and php.

Set up mariadb (assuming you don't already have a database running)

```mysql_install_db --user=mysql --basedir=/usr --datadir=/var/lib/mysql```

After that you can start the database server, you can also directly enable the service so it starts automatically if your system needs a reboot for exmaple.

```sudo systemctl start mysqld```

```sudo systemctl enable mysqld```

Now you can log into your freshly installed database, the user root doesn't have a password, so just issue the command below and hit enter when it asks you for a password.

```mysql -u root -p```

Now create the actual database and the user for it

<pre>
CREATE DATABASE w0bm;
GRANT ALL ON w0bm.* TO w0bm@localhost IDENTIFIED BY 'w0bm';
</pre>

## PHP/PHP-FPM
Open the php config file

```sudo nvim /etc/php/php.ini```

and edit the following settings

<pre>
post_max_size = 500M
upload_max_filesize = 100M
extension=pdo_mysql.so
</pre>

Then edit the php-fpm config file

```sudo nvim /etc/php/php-fpm.d/www.conf```

Change the default user/group to the user who owns the w0bm directory, we run w0bm as w0bm.

<pre>
user = w0bm
group = w0bm
</pre>

Next set up php-fpm to use a unix sock.

<pre>
listen = /run/php-fpm/php-fpm.sock
listen.owner = w0bm
listen.group = w0bm
</pre>

```sudo systemctl start php-fpm```

```sudo systemctl enable php-fpm```

## NGINX

First you have to create a config file in `/etc/nginx/conf.d/`

`sudo nvim /etc/nginx/conf.d/w0bm.conf`

This config is for the use with a reverse proxy intended.

<pre>
#w0bm.com Configuration
server {
    listen 80;
    listen [::]:80;
    server_name w0bm.com www.w0bm.com v4.w0bm.com;
    include letsencrypt.conf;
    large_client_header_buffers 4 32k;
    return 301 https://w0bm.com$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name w0bm.com www.w0bm.com v4.w0bm.com;
    access_log /var/log/nginx/w0bm/w0bm-access.log;
    root /home/w0bm/w0bm.com/public;
    error_log /var/log/nginx_w0bm_error.log;
    index index.php;
    client_max_body_size 500M;
    gzip on;
    ssl on;
    ssl_certificate /path/to/your/cert.pem;
    ssl_certificate_key /path/to/your/key.pem;
    ssl_session_timeout 1d;
    ssl_protocols TLSv1.2;
    ssl_ciphers 'ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384:ECDHE-ECDSA-CHACHA20-POLY1305:ECDHE-RSA-CHACHA20-POLY1305:ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-SHA384:ECDHE-RSA-AES256-SHA384:ECDHE-ECDSA-AES128-SHA256:ECDHE-RSA-AES128-SHA256';
    ssl_prefer_server_ciphers on;
    ssl_stapling on;
    ssl_stapling_verify on;
    large_client_header_buffers 4 32k;
    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_index index.php;
        include fastcgi.conf;
        fastcgi_param PATH_TRANSLATED $document_root$fastcgi_script_name;
        #fastcgi_param GEOIP_ADDR $remote_addr;
        #fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass unix:/run/php-fpm/php-fpm.sock;
    }
    location ~* \.(?:css|js)$ {
        gzip on;
        expires 1y;
        add_header Cache-Control "public";
    }
    location ~* \.(?:jpg|jpeg|gif|png|ico|svg)$ {
        expires 1M;
        access_log off;
        add_header Cache-Control "public";
    }
    location / {
        if ($http_user_agent ~* 'MSIE ([1-9]|10)\.') {
            return 302 https://www.microsoft.com/en-us/WindowsForBusiness/End-of-IE-support;
        }
        try_files $uri $uri/ /index.php?$args;
    }
}

#CDN Configuration
server {
    listen 80;
    listen [::]:80;
    server_name b.w0bm.com v4.b.w0bm.com;
    return 301 https://$server_name$request_uri;
    large_client_header_buffers 4 32k;
    return 301 https://b.w0bm.com$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name b.w0bm.com;
    access_log /var/log/nginxw0bm/cdn-access.log;
    error_log /var/log/nginx/w0bm/cdn-error.log;
    root /home/w0bm/w0bm.com/public/b;
    ssl on;
    ssl_certificate /path/to/your/cert.pem;
    ssl_certificate_key /path/to/your/key.pem;
    large_client_header_buffers 4 32k;
}
</pre>


# Installation
`git clone https://github.com/w0bm/w0bm.com.git`

`cd w0bm.com`

`./composer.phar dump-autoload`

`./composer.phar install --no-scripts`

(make sure you have enough RAM for the installation, otherwise use swap)

`touch .env`

`php artisan key:generate`

`nvim .env`
<pre>
APP_KEY=
APP_ENV=production
APP_DEBUG=false

DB_HOST=localhost
DB_DATABASE=w0bm
DB_USERNAME=w0bm
DB_PASSWORD=w0bm

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

RECAPTCHA_PUBLIC=
RECAPTCHA_PRIVATE=
</pre>

`mkdir public/b`

`cd public/b`

Now put some random webm in the folder and name it `1.webm`

Modify `database/seeds/DatabaseSeeder.php` and uncomment all the different seeders. (Initially you'll need all)

Run `php artisan migrate` and then `php artisan db:seed`

Run `php artisan tags` to initially tag all videos

Start the development server with `php artisan serve`

Check your website at `http://localhost:8000/1`

Log in with Username=admin and Password=password

To transpile and minify your modified w0bmscript.js you need to have this projects dependencies installed (dependencies installable with `npm i`). Then run `npm run build`.

## Contributing

Make your changes, test them locally (PLEASE!!! preferable write some unit tests aswell) and make a pull request.

Folder structure:  
- Models: `app/Models/`
- Routes: `app/Http/routes.php`
- Controllers: `app/Http/Controllers`
- Views: `resources/views`
- JS and CSS: `public/{css,js}`
- Database: `database/migrations`

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
