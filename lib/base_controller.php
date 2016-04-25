<?php

  class BaseController{

    public static function get_user_logged_in(){
        if(isset($_SESSION['friend'])) {
          $friendid = $_SESSION['friend'];
          $friend = Friend::find($friendid);

          return $friend;
        }
      return null;
    }

    public static function check_logged_in(){
      if(!isset($_SESSION['friend'])){
        Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään!'));
      }
    }

    public static function log_out(){
      $_SESSION['friend'] = null;
      Redirect::to('/', array('message' => 'Olet kirjautunut ulos!'));
    }
  }

