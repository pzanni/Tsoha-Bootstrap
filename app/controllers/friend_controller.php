<?php

  class FriendController extends BaseController {
  	public static function profile($friendid) {
  		$friend = Friend::find($friendid);
  		View::make('profile.html', array('friend' => $friend));
  	}

  	public static function edit($friendid) {
  		$friend = Friend::find($friendid);
  		View::make('editprofile.html', array('friend' => $friend));
  	}
  }

