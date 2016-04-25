<?php

  class FriendController extends BaseController {

    

  	public static function profile($friendid) {
      $friend = Friend::find($friendid);
      $user_logged_in = parent::get_user_logged_in();
  		View::make('profile.html', array('friend' => $friend, 'user_logged_in' => $user_logged_in));
  	}

    //näyttää profiilinmuokkaussivun kirjautuneelle käyttäjälle
  	public static function edit() {
      self::check_logged_in();
  		$user_logged_in = parent::get_user_logged_in();
      $attributes = array(
        'name' => $user_logged_in->name,
        'gender' => $user_logged_in->gender,
        'age' => $user_logged_in->age,
        'location' => $user_logged_in->location,
        'info' => $user_logged_in->info
        );

  		View::make('editprofile.html', array('user_logged_in' => $user_logged_in, 'attributes' =>$attributes));
  	}

    //päivittää profiilin tiedot
    public static function update() {
      $user_logged_in = parent::get_user_logged_in();
      $params = $_POST;
      $attributes = array(
        'friendid' => $user_logged_in->friendid,
        'name' => $params['name'],
        'gender' => $params['gender'],
        'age' => $params['age'],
        'location' => $params['location'],
        'info' => $params['info'],
        'email' => $user_logged_in->email,
        'password' => $user_logged_in->password
        );

      $friend = new Friend($attributes);
      $errors = $friend->errors();

      if(count($errors) > 0) {
        View::make('editprofile.html', array('errors' => $errors, 'user_logged_in' => $user_logged_in, 'attributes' => $attributes));
      } else {
        $friend->update();
        Redirect::to('/profile/' . $friend->friendid);
      }
    }
    //poistaa käyttäjätilin
     public static function destroy($friendid) {
      $user_logged_in = parent::get_user_logged_in();
      
      if($user_logged_in->friendid != $friendid) {
        Redirect::to('/login');
      } 
      $friend = new Friend(array('friendid' => $friendid));
      $friend->destroy();
      Redirect::to('/', array('message' => 'Käyttäjätilisi on poistettu'));
    }
  }

