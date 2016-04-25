<?php

class Post extends BaseModel {
 	public $postid, $sender, $posttime, $title, $content;
   	public function __construct($attributes){
    		parent::__construct($attributes);
        $this->validators = array('validate_title');
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

    //päivittää ilmoituksen tiedot tietokantaan
    public function update() {
      $query = DB::connection()->prepare('UPDATE Post SET title = :title, content = :content WHERE postid = :postid');
      $query->execute(array(
        'title' => $this->title,
        'content' => $this->content,
        'postid' => $this->postid
        ));
    }

    //etsii hakusanalla tietokannasta content- ja title-kentistä
    public static function findFromContent($searchword) {
      $query_string = 'SELECT * FROM Post WHERE';
      $query_string .= ' LOWER(content) LIKE :like';
      $query_string .= ' OR LOWER(title) LIKE :like';
      $options['like'] = '%' . $searchword['searchword'] . '%';
    

    $query = DB::connection()->prepare($query_string);
    $query->execute($options);

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

    //tallentaa uuden ilmoituksen tietokantaan
    public function save() {
      $query = DB::connection()->prepare('INSERT INTO Post (title, content, posttime, sender) VALUES (:title, :content, NOW(), :sender) RETURNING postid, posttime');
      $query->execute(array('title' => $this->title, 'content' => $this->content, 'sender' => $this->sender->friendid));
      $row = $query->fetch();
      $this->postid = $row['postid'];
      $this->posttime = $row['posttime'];
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

    //poistaa ilmoituksen tietokannasta
    public function destroy() {
      $query = DB::connection()->prepare('DELETE FROM Post WHERE postid = :postid');
      $query->execute(array('postid' => $this->postid));

      
    }
    
}