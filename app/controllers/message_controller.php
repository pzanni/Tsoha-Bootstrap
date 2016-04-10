<?php

  class MessageController extends BaseController {
  	public static function received($friendid) {
  		$messages = Message::findFriendsReceived($friendid);
  		View::make('receivedmsgs.html', array('messages' => $messages, 'friendid' => $friendid));
  	}

  	public static function sent($friendid) {
  		$messages = Message::findFriendsSent($friendid);
  		View::make('sentmsgs.html', array('messages' => $messages, 'friendid' => $friendid));
  	}

  	public static function message ($msgid) {
  		$message = Message::find($msgid);
  		View::make('message.html', array('message' => $message));
  	}

    public static function store() {
      $params = $_POST;
      $message = new Message(array(
        //'receiver' => $params['receiver'],
        'title' => $params['title'],
        'content' => $params['content'],
        'receiver' => $params['receiver']
        ));
      $message->save();

      Redirect::to('/message/' . $message->msgid, array('message' => $message));
    }

    public static function create($friendid) {
      $friend = Friend::find($friendid);
      View::make('sendmsg.html', array('friend' => $friend));
    }
  }
