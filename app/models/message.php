<?php

class Message extends BaseModel {
 	public $msgid, $sender, $receiver, $title, $senttime, $content;
   	public function __construct($attributes){
    		parent::__construct($attributes);
  	}

  	public static function all() {
  		$query = DB::connection()->prepare('SELECT * FROM Message');
  		$query->execute();
  		$rows = $query->fetchAll();
  		$messages = array();

  		foreach($rows as $row) {
        $sender = Friend::find($row['sender']);
        $receiver = Friend::find($row['receiver']);

  			$messages[] = new Message(array(
  				'msgid'=> $row['msgid'],
  				'sender' => $sender,
  				'receiver' => $receiver,
  				'title' => $row['title'],
  				'content' => $row['content'],
  				'senttime' => $row['senttime']
  				));
  		}
  		return $messages;
  	}

  	public static function find($msgid) {
  		$query = DB::connection()->prepare('SELECT * FROM Message WHERE msgid = :msgid LIMIT 1');
  		$query->execute(array('msgid' => $msgid));
  		$row = $query->fetch();

  		if($row) {
        $sender = Friend::find($row['sender']);
        $receiver = Friend::find($row['receiver']);

  			$message =  new Message(array(
  				'msgid'=> $row['msgid'],
  				'sender' => $sender,
  				'receiver' => $receiver,
  				'title' => $row['title'],
  				'content' => $row['content'],
  				'senttime' => $row['senttime']
  				));
  			return $message;
  		}
  		return null;
  	}

    public static function findFriendsReceived($friendid) {
      $query = DB::connection()->prepare('SELECT * FROM Message WHERE receiver = :friendid');
      $query->execute(array('friendid' => $friendid));
      $rows = $query->fetchAll();
      $messages = array();

      foreach($rows as $row) {
        $sender = Friend::find($row['sender']);
        $receiver = Friend::find($row['receiver']);

        $messages[] = new Message(array(
          'msgid'=> $row['msgid'],
          'sender' => $sender,
          'receiver' => $receiver,
          'title' => $row['title'],
          'content' => $row['content'],
          'senttime' => $row['senttime']
          ));
        return $messages;
      }
      return null;
    }

    public static function findFriendsSent($friendid) {
      $query = DB::connection()->prepare('SELECT * FROM Message WHERE sender = :friendid');
      $query->execute(array('friendid' => $friendid));
      $rows = $query->fetchAll();
      $messages = array();

      foreach($rows as $row) {
        $sender = Friend::find($row['sender']);
        $receiver = Friend::find($row['receiver']);

        $messages[] = new Message(array(
          'msgid'=> $row['msgid'],
          'sender' => $sender,
          'receiver' => $receiver,
          'title' => $row['title'],
          'content' => $row['content'],
          'senttime' => $row['senttime']
          ));
        return $messages;
      }
      return null;
    }

    public function save() {
      $query = DB::connection()->prepare('INSERT INTO Message (receiver, title, content, senttime) VALUES (:receiver, :title, :content, NOW()) RETURNING msgid, senttime');
      $query->execute(array('receiver' => $this->receiver, 'title' => $this->title, 'content' => $this->content));
      $row = $query->fetch();
      $this->msgid = $row['msgid'];
      $this->senttime = $row['senttime'];
      $this->receiver = Friend::find($this->receiver);
    }
}