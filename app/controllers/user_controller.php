<?php

  class UserController extends BaseController {

  	public static function login() {
      View::make('login.html');
    }

    public static function handle_login() {
      $params = $_POST;
      $friend = Friend::authenticate($params['email'], $params['password']);

      if(!$friend) {
      	View::make('login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!'));
      } else {
      	$_SESSION['friend'] = $friend->friendid;
      	Redirect::to('/');
      }
    }

    public static function index() {
    	$user_logged_in = parent::get_user_logged_in();
    	View::make('home.html', array('user_logged_in' => $user_logged_in));
    }

    public static function register() {
    	View::make('register.html');
    }

    public static function add_user() {
    	$params = $_POST;
    	$attributes = (array(
    		'email' => $params['email'],
    		'name' => $params['name'],
    		'password' => $params['password']
    	));
    	$friend = new Friend($attributes);
    	$errors = $friend->errors();

    	if(count($errors) == 0) {
    		$friend->save();
    		$_SESSION['friend'] = $friend->friendid;
    		Redirect::to('/');
    	} else {
    		View::make('register.html', array('errors' => $errors));
    	}

    }



  }