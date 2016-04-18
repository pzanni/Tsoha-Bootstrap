<?php

class Message extends BaseModel {
 	public $msgid, $sender, $receiver, $title, $senttime, $content;
   	public function __construct($attributes){
    		parent::__construct($attributes);
        $this->validators = array('validate_title');
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
        
      }
      return $messages;
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
      }
      return $messages;
    }

    public function save() {
      $query = DB::connection()->prepare('INSERT INTO Message (receiver, title, content, senttime, sender) VALUES (:receiver, :title, :content, NOW(), :sender) RETURNING msgid, senttime');
      $query->execute(array('receiver' => $this->receiver, 'title' => $this->title, 'content' => $this->content, 'sender' => $this->sender->friendid));
      $row = $query->fetch();
      $this->msgid = $row['msgid'];
      $this->senttime = $row['senttime'];
      $this->receiver = Friend::find($this->receiver);
    }

    public function validate_title() {
      $errors = array();
      if($this->title == '' || $this->title == null) {
        $errors[] = 'Otsikko ei saa olla tyhjä!';
      }

      if(strlen($this->title) < 3) {
        $errors[] = 'Otsikon pituuden tulee olla vähintään kolme merkkiä!';
      }

      return $errors;
    }


    
}