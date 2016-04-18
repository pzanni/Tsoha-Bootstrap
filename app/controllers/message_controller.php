<?php

  class MessageController extends BaseController {
  	public static function received() {
      $user_logged_in = parent::get_user_logged_in();
      if($user_logged_in == null) {
        Redirect::to('/login');
      }
  		$messages = Message::findFriendsReceived($user_logged_in->friendid);
  		View::make('receivedmsgs.html', array('messages' => $messages, 'user_logged_in' => $user_logged_in));
  	}

  	public static function sent() {
      $user_logged_in = parent::get_user_logged_in();
      if($user_logged_in == null) {
        Redirect::to('/login');
      }
  		$messages = Message::findFriendsSent($user_logged_in->friendid);
  		View::make('sentmsgs.html', array('messages' => $messages, 'user_logged_in' => $user_logged_in));
  	}

  	public static function message($msgid) {

  		$message = Message::find($msgid);
      $user_logged_in = parent::get_user_logged_in();
      if($user_logged_in == $message->sender || $user_logged_in == $message->receiver) {
        View::make('message.html', array('message' => $message, 'user_logged_in' => $user_logged_in));
      } else if($user_logged_in != null) {
        Redirect::to('/receivedmsgs');
      } else {
        Redirect::to('login');
      }
  		
  	}

    public static function store() {
      $params = $_POST;
      $attributes = (array(
        'title' => $params['title'],
        'content' => $params['content'],
        'receiver' => $params['receiver'],
        'sender' => parent::get_user_logged_in()
        ));

      $message = new Message($attributes);
      $errors = $message->errors();

      if (count($errors) == 0) {
        $message->save();
        Redirect::to('/message/' . $message->msgid, array('message' => $message));
      } else {
        Redirect::to('/sendmsg/' . $message->receiver, array('errors' => $errors, 'attributes' => $attributes));
      }    
    }

    public static function create($friendid) {
      $user_logged_in = parent::get_user_logged_in();
      $friend = Friend::find($friendid);
      if($user_logged_in == null) {
        Redirect::to('/login');
      } else {
        View::make('sendmsg.html', array('friend' => $friend));
      }
    }
  }
