Lumen Route List
===================


This package will help to display all the registered route list like laravel.


----------

Installation
-------------
Via Composer

``` bash
$ composer require thedevsaddam/lumen-route-list
```
Install manually (add the line to composer.json file)
``` bash
"thedevsaddam/lumen-route-list": "^1.0"
```
Then open your terminal and hit the command
```bash
composer update
```
Open bootstrap/app.php and add the line below

```php
$app->register(\Thedevsaddam\LumenRouteList\LumenRouteListServiceProvider::class);
```

<hr/>

### **Uses**
1. Run `php artisan route:list` to display the route list

![route list like laravel](https://raw.githubusercontent.com/thedevsaddam/lumen-route-list/master/screenshots/route-list.png)

### **Todo**
* Filtering routes
* Code refactor
<hr/>

### **License**
The **lumen-route-list** is a open-source software licensed under the [MIT License](LICENSE.md).

_Thank you :)_
