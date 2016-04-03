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

  $routes->get('/posts', function() {
    HelloWorldController::posts();
  });

  $routes->get('/addpost', function() {
    HelloWorldController::addpost();
  });

  $routes->get('/editprofile', function() {
    HelloWorldController::editprofile();
  });

  $routes->get('/sendmsg', function() {
    HelloWorldController::sendmsg();
  });

  $routes->get('/post', function() {
    HelloWorldController::post();
  });

   $routes->get('/receivedmsgs', function() {
    HelloWorldController::receivedmsgs();
  });

  $routes->get('/sentmsgs', function() {
    HelloWorldController::sentmsgs();
  });

  $routes->get('/message', function() {
    HelloWorldController::message();
  });


  
  

