<?php

class Post extends BaseModel {
 	public $postid, $sender, $posttime, $title, $content;
   	public function __construct($attributes){
    		parent::__construct($attributes);
  	}

  	public static function all() {
  		$query = DB::connection()->prepare('SELECT * FROM Post');
  		$query->execute();
  		$rows = $query->fetchAll();
  		$posts = array();

  		foreach($rows as $row) {
        $sender = Friend::find($row['sender']);
  			$posts[] = new Post(array(
  				'postid'=> $row['postid'],
  				'sender' => $sender,
  				'posttime' => $row['posttime'],
  				'title' => $row['title'],
  				'content' => $row['content'],
  				));
  		}
  		return $posts;
  	}

  	public static function find($postid) {
  		$query = DB::connection()->prepare('SELECT * FROM Post WHERE postid = :postid LIMIT 1');
  		$query->execute(array('postid' => $postid));
  		$row = $query->fetch();

  		if($row) {
        $sender = Friend::find($row['sender']);
  			$post =  new Post(array(
  				'postid'=> $row['postid'],
  				'sender' => $sender,
  				'posttime' => $row['posttime'],
  				'title' => $row['title'],
  				'content' => $row['content'],
  				));
  			return $post;
  		}
  		return null;
  	}		

    public function save() {
      $query = DB::connection()->prepare('INSERT INTO Post (title, content, posttime) VALUES (:title, :content, NOW()) RETURNING postid, posttime');
      $query->execute(array('title' => $this->title, 'content' => $this->content));
      $row = $query->fetch();
      $this->postid = $row['postid'];
      $this->posttime = $row['posttime'];
    }
    
}