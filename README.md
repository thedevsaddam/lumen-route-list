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
1. Inorder to filter routes use `php artisan route:list --method=searchKeyword --uri=searchKeyword`
1. To display in reverse order use `--reverse` or `-r`

Filtering example given below:
```bash
php artisan route:list --method=post
#The above example will filter all the routes with post method#
or
php artisan route:list --name=users
#The above example will filter all the routes which name contains *user* keyword#
or
php artisan route:list --name=users --method=get --uri=api/v1
#This above example will filter all the routes where name matches users, method matches get and uri matches api/v1
or to display in reverse order use
php artisan route:list --name=users -r
```

![route list like laravel](https://raw.githubusercontent.com/thedevsaddam/lumen-route-list/master/screenshots/route-list.png)


### **License**
The **lumen-route-list** is a open-source software licensed under the [MIT License](LICENSE.md).

_Thank you :)_
