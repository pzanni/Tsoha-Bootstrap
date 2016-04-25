<?php

  $routes->get('/', function() {
    UserController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->post('/profile/:friendid/destroy', function($friendid){
    FriendController::destroy($friendid);
  });

  $routes->post('/profile/edit', function() {
    FriendController::update();
  });

  $routes->get('/profile/edit', function() {
    FriendController::edit();
  });

  $routes->get('/profile/:friendid', function($friendid) {
    FriendController::profile($friendid);
  });

  $routes->get('/login', function() {
    UserController::login();
  });

  $routes->post('/login', function(){
    UserController::handle_login();
  });

  $routes->post('/logout', function(){
    UserController::logout();
  });

  $routes->get('/register', function() {
    UserController::register();
  });

  $routes->post('/register', function(){
    UserController::add_user();
  });

  $routes->post('/posts/search', function() {
    PostController::limited();
  });

  $routes->get('/posts', function() {
    PostController::posts();
  });

  $routes->get('/post/:postid', function($postid) {
    PostController::post($postid);
  });

  $routes->get('/post/:postid/edit', function($postid) {
    PostController::edit($postid);
  }); 

  $routes->post('/post/:postid/edit', function($postid) {
    PostController::update($postid);
  });

  $routes->post('/post', function(){
    PostController::store();
  });

  $routes->get('/addpost', function(){
    PostController::create(); 
  });

  $routes->get('/sendmsg/:friendid', function($friendid) {
    MessageController::create($friendid);
  });

  $routes->get('/receivedmsgs', function() {
    MessageController::received();
  });

  $routes->get('/sentmsgs', function() {
    MessageController::sent();
  });

   $routes->post('/post/:id/destroy', function($postid){
    PostController::destroy($postid);
  });

  $routes->get('/message/:msgid', function($msgid) {
    MessageController::message($msgid);
  });

  $routes->post('/message', function() {
    MessageController::store();
  });

  
 
  
  

