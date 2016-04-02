<?php

  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  View::make('home.html');
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

    public static function posts(){
      View::make('posts.html');
    }

    public static function addpost(){
      View::make('addpost.html');
    }

    public static function editprofile(){
      View::make('editprofile.html');
    }

  }
