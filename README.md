<img src="https://raw.githubusercontent.com/batinmustu/corna-rest/main/resources/logo.png" alt="corna-rest">

# Corna-Rest - Micro Framework For Rest API's

**Corna-Rest, working with minimum configuration for create basically rest apis. Even, if you are not use database, you not need even configuration. Install, create routes and run**

## Features
- Lightweight, 61.9kb
- Add Middlewares to routes
- Create custom libraries
- Contains database helper - [DBHelper For PHP](https://github.com/batinmustu/dbhelper-for-php)
- You can use multiple files for your routes
- You can create routes for different methods [POST, GET]

## Example Usage

```php
// In app/routes/main.php
// Add '' for root url
$routes->get('', function () {
    echo "Hello World!";
});
```

## Table of Contents

  * [Create Route](#create-route)
    * [Get](#get)
    * [Post](#post)
  * [Response](#response)
    * [Return Response](#usage)
    * [Status Code](#with-status-code)
  * [Add Middleware](#add-middleware)
  * [Create Custom Library](#create-custom-library)
  * [Database Helper](#database-helper)

## Create Route
First, create a php file in `app/routes` folder. After, you can add route like examples.

#### Get
**Basically Usage**
```php
$routes->get('/users', function () {
    // CONTENT
});
```

**With Parameters**
```php
$routes->get('/user/{id}', function ($id) {
    // CONTENT
});
```

#### Post
**Basically Usage**
```php
$routes->post('/new_user', function () {
    // CONTENT
});
```

**With Parameters**
```php
$routes->post('/new_user', function () {
    // You can use default $_POST varaible for post parameters.
    echo $_POST['user_name'];
});
```

## Response
You can use `$response` variable to create response. If you need `$response` variable, you need add `use` to your function.

#### Usage
```php
$routes->get('/users', function () use ($response) {
    $users = array();
    $response->response($users);
});
```
#### With Status Code
```php
$routes->get('/users', function () use ($response) {
    $users = array();
    $response->statusCode(200)->response($users);
});
```

## Add Middleware
First, create a php class in `app/middleware` folder. The skeleton of this class should be,


```php
// MyMiddleware.php

namespace App\Middleware;
use App\Core\Middleware;

class MyMiddleware extends Middleware {
    function next($params) {
        return true;
    }
}
```
If you don't add `return true` or add `return false`, the request cannot be completed.

If you route contain parameters, you can use this parameters in `$params` variable.

And usage,
```php
$routes->middleware('mymiddleware')->get('/users', function () use ($response) {
    $users = array();
    $response->statusCode(200)->response($users);
});
```

## Create Custom Library

First, create a php class in `app/library` folder. The skeleton of this class should be,

```php
// MyLibrary.php

namespace App\Library;

class MyLibrary {

}
```
And usage,

```php
use App\Library\MyLibrary;

$routes->get('/users', function () use ($response) {
    $library = new MyLibrary();
});
```

## Database Helper
You can use `$db` variable for Database Helper. If you need `$db` variable, you need add `use` to your function like `$response`.

**Usage**
```php
$routes->get('/users', function () use ($response, $db) {
    $db->connect();
    $users = $db->get('users');
    $response->response($users);
    $db->disconnect();
});
```

If you need a detailed document for database helper, you can visit [DBHelper For PHP](https://github.com/batinmustu/dbhelper-for-php) repo.
