<?php

  class MessageController extends BaseController {
    //näyttää sisäänkirjautuneelle saapuneet viestit -sivun
  	public static function received() {
      $user_logged_in = parent::get_user_logged_in();
      self::check_logged_in();
  		$messages = Message::findFriendsReceived($user_logged_in->friendid);
      $reversed = array_reverse($messages);
  		View::make('receivedmsgs.html', array('messages' => $reversed, 'user_logged_in' => $user_logged_in));
  	}

    //näyttää sisäänkirjautuneelle lähetetyt viestit -sivun
  	public static function sent() {
      $user_logged_in = parent::get_user_logged_in();
      self::check_logged_in();
  		$messages = Message::findFriendsSent($user_logged_in->friendid);
      $reversed = array_reverse($messages);
  		View::make('sentmsgs.html', array('messages' => $reversed, 'user_logged_in' => $user_logged_in));
  	}

    //näyttää tietyn viestin vain sen lähettäjälle tai vastaanottajalle
  	public static function message($msgid) {

  		$message = Message::find($msgid);
      $user_logged_in = parent::get_user_logged_in();
      if($user_logged_in == $message->receiver) {
        $message->setRead();
        View::make('message.html', array('message' => $message, 'user_logged_in' => $user_logged_in));
      } else if($user_logged_in == $message->sender) {
        View::make('message.html', array('message' => $message, 'user_logged_in' => $user_logged_in));
      } else if($user_logged_in != null) {
        Redirect::to('/receivedmsgs');
      } else {
        Redirect::to('login');
      }
  		
  	}
    //tallentaa uuden viestin
    public static function store() {
      self::check_logged_in();
      $params = $_POST;
      $attributes = (array(
        'title' => $params['title'],
        'content' => $params['content'],
        'receiver' => $params['receiver'],
        'sender' => parent::get_user_logged_in(),
        'read' => 1
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

    //näyttää viestin lähetys sivun sisäänkirjautuneelle käyttäjälle
    public static function create($friendid) {
      $user_logged_in = parent::get_user_logged_in();
      $friend = Friend::find($friendid);
      self::check_logged_in();
        View::make('sendmsg.html', array('friend' => $friend));
    }
  }
