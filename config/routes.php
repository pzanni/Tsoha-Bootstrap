<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/profile', function() {
    HelloWorldController::profile();
  });

 $routes->get('/login', function() {
    HelloWorldController::login();
  });

  $routes->get('/register', function() {
    HelloWorldController::register();
  });
