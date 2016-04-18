<?php

  class FriendController extends BaseController {

    

  	public static function profile($friendid) {
      $friend = Friend::find($friendid);
      $user_logged_in = parent::get_user_logged_in();
  		View::make('profile.html', array('friend' => $friend, 'user_logged_in' => $user_logged_in));
  	}

  	public static function edit() {
  		$user_logged_in = parent::get_user_logged_in();
      if($user_logged_in == null) {
        Redirect::to('/login');
      }
      $attributes = array(
        'name' => $user_logged_in->name,
        'gender' => $user_logged_in->gender,
        'age' => $user_logged_in->age,
        'location' => $user_logged_in->location,
        'info' => $user_logged_in->info
        );

  		View::make('editprofile.html', array('user_logged_in' => $user_logged_in, 'attributes' =>$attributes));
  	}

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
        View::make('editprofile.html', array('errors' => $errors, 'attributes' => $attributes));
      } else {
        $friend->update();
        Redirect::to('/profile/' . $friend->friendid);
      }
    }
  }

