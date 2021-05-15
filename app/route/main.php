<?php
$routes->get('', function () {
    echo "Hello World!";
});

$routes->get('/user', function () {
    echo "User Route";
});