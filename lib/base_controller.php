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
      // Toteuta kirjautumisen tarkistus tähän.
      // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
    }

  }
