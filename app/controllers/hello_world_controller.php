<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('home.html');
    }

    public static function sandbox(){
      $post = new Post(array('title' => '', 'content' => 'testi-ilmoitus'));
      $errors = $post->errors();
      Kint::dump($errors);
    }

    public static function profile(){
      // Testaa koodiasi täällä
      View::make('profile.html');
    }

    public static function login(){
      View::make('login.html');
    }

    public static function register(){
      View::make('register.html');
    }

    public static function addpost(){
      View::make('addpost.html');
    }

    public static function editprofile(){
      View::make('editprofile.html');
    }

    public static function sendmsg(){
      View::make('sendmsg.html');
    }

    public static function post(){
      View::make('post.html');
    }

    public static function receivedmsgs(){
      View::make('receivedmsgs.html');
    }

    public static function sentmsgs(){
      View::make('sentmsgs.html');
    }

    public static function message(){
      View::make('message.html');
    }

  }
