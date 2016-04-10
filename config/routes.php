<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/profile/:friendid', function($friendid) {
    FriendController::profile($friendid);
  });

 $routes->get('/login', function() {
    HelloWorldController::login();
  });

  $routes->get('/register', function() {
    HelloWorldController::register();
  });

  $routes->get('/posts', function() {
    PostController::posts();
  });

  $routes->get('/post/:postid', function($postid) {
    PostController::post($postid);
  });

  $routes->post('/post', function(){
    PostController::store();
  });

  $routes->get('/addpost', function(){
    PostController::create(); 
  });

  $routes->get('/editprofile/:friendid', function($friendid) {
    FriendController::edit($friendid);
  });

  $routes->get('/sendmsg/:friendid', function($friendid) {
    MessageController::create($friendid);
  });

  $routes->get('/receivedmsgs/:friendid', function($friendid) {
    MessageController::received($friendid);
  });

  $routes->get('/sentmsgs/:friendid', function($friendid) {
    MessageController::sent($friendid);
  });

  $routes->get('/message/:msgid', function($msgid) {
    MessageController::message($msgid);
  });

  $routes->post('/message', function() {
    MessageController::store();
  });

  
  

