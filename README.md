## TO-DO

- [x] Load all configs using .env fiel
- [x] Connect DB
- [x] Start Session
- [x] Controller
- [x] Model
- [x] Route
- [x] Views/Templates
- [x] Page specific JS and CSS files
- [x] Master template feature
- [ ] Email
- [ ] File upload
- [ ] Image manipulation
- [ ] Make controller methods available inside view files

## .htaccess Code

```apache
RewriteEngine On
#Options All -Indexes

## ROUTER WWW Redirect.

#RewriteCond %{HTTP_HOST} !^www\. [NC]
#RewriteRule ^ https://www.%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

## ROUTER HTTPS Redirect

#RewriteCond %{HTTP:X-Forwarded-Proto} !https
#RewriteCond %{HTTPS} off
#RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# ROUTER URL Rewrite

RewriteCond %{SCRIPT_FILENAME} !-f
RewriteCond %{SCRIPT_FILENAME} !-d
RewriteRule ^(.\*)$ index.php?route=/$1 [L,QSA]

# Disable directory listing
Options -Indexes
```

## Routes Usage

```php
$router = new \Bramus\Router\Router();

$router->setNamespace('\App\Controllers');
$router->get('/about/{id}', 'PagesController@about');

$router->set404('PagesController@page_404');

$router->run();
```
