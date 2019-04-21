## Setup

To run this demo, you need to clone it and install dependencies:

```
git clone https://github.com/vienzent/sample-cart.git
cd sample-cart
composer install
```

Modify the database name in cart.sql (default is ```cart```)
```
...
CREATE DATABASE IF NOT EXISTS `any_name_here` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `any_name_here`;
...
```

Then execute the cart.sql
```
mysql -u username -p < cart.sql
```

Configure the database in ```/config/doctrine.php```
```
<?php declare(strict_types=1);
....
return EntityManager::create([
    'dbname' => 'cart',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
], $config);
```

You can then run the web application using PHP's built-in server:

```
php -S localhost:8881 -t public
```

The web application is running at [http://localhost:8881](http://localhost:8881/).
You can use any available port number (e.g. ```php -S localhost:8888 -t public```)