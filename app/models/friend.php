<?php

class Friend extends BaseModel{
    public $friendid, $name, $email, $password, $age, $location, $gender, $info;

    public function __construct($attributes){
   		parent::__construct($attributes);
  	}

  	public static function all(){
    $query = DB::connection()->prepare('SELECT * FROM Friend');
    $query->execute();
    $rows = $query->fetchAll();
    $friends = array();

    foreach($rows as $row){
      $friends[] = new Friend(array(
        'friendid' => $row['friendid'],
        'name' => $row['name'],
        'email' => $row['email'],
        'password' => $row['password'],
        'age' => $row['age'],
        'location' => $row['location'],
        'gender' => $row['gender'],
        'info' => $row['info']
      ));
    }

    return $friends;
  }

  	public static function find($friendid) {
  		$query = DB::connection()->prepare('SELECT * FROM Friend WHERE friendid = :friendid LIMIT 1');
  		$query->execute(array('friendid' => $friendid));
  		$row = $query->fetch();

  		if($row) {
  			$friend = new Friend(array(
  				'friendid'=> $row['friendid'],
  				'name' => $row['name'],
  				'email' => $row['email'],
  				'password' => $row['password'],
  				'age' => $row['age'],
  				'location' => $row['location'],
  				'gender' => $row['gender'],
  				'info' => $row['info']
  				));
  			return $friend;
  		}
  		return null;
   	}
}
