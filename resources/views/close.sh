#!/bin/bash
cd /var/www/w0bm.com/resources/views
ln -sf registerclosed.blade.php register.blade.php
php ../../artisan view:clear
