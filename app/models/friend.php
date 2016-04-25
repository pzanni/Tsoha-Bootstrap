<?php

class Friend extends BaseModel{
    public $friendid, $name, $email, $password, $age, $location, $gender, $info, $errors;

    public function __construct($attributes){
   		parent::__construct($attributes);
      $this->validators = array('validate_name', 'validate_email', 'validate_password');
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

    //liää profiilin muutoksen tietokantaan
    public function update() {
      $query = DB::connection()->prepare('UPDATE Friend SET name = :name, gender = :gender, age = :age, location = :location, info = :info, email = :email, password = :password WHERE friendid = :friendid');
      $query->execute(array(
        'friendid' => $this->friendid,
        'name' => $this->name, 
        'gender' => $this->gender, 
        'age' => $this->age, 
        'location' => $this->location, 
        'info' => $this->info,
        'email' => $this->email,
        'password' => $this->password
        ));
    }


    //tekee uuden käyttäjän tietokantaan
    public function save() {
      $query = DB::connection()->prepare('INSERT INTO Friend (email, name, password) VALUES (:email, :name, :password) RETURNING friendid');
      $query->execute(array('email' => $this->email, 'name' => $this->name, 'password' => $this->password));
      $row = $query->fetch();
      $this->friendid = $row['friendid'];
    }

    //poistaa  käyttäjän tietokannasta
    public function destroy() {
      $query = DB::connection()->prepare('DELETE FROM Post WHERE sender = :friendid');
      $query->execute(array('friendid' => $this->friendid));

      $query = DB::connection()->prepare('DELETE FROM Friend WHERE friendid = :friendid');
      $query->execute(array('friendid' => $this->friendid));
    }

    //validoi nimen
    public function validate_name() {
      $errors = array();
      if($this->name == '' || $this->name == null) {
        $errors[] = 'Nimi ei saa olla tyhjä';
      }
      return $errors;
    }

    //validoi sähköpostin
    public function validate_email() {
      $errors = array();
      if($this->email == '' || $this->email == null) {
        $errors[] = 'Sähköposti ei saa olla tyhjä';
      }
      return $errors;
    }

    //validoi salasanan
    public function validate_password() {
      $errors = array();
      if($this->password == '' || $this->password == null) {
        $errors[] = 'Salasana ei saa olla tyhjä';
      } 

      if(strlen($this->password) < 5) {
        $errors[] = 'Salasanan pituuden tulee olla vähintään viisi merkkiä!';
      }

      return $errors;
    }

    //etsii käyttäjän tietokannasta ja palauttaa sen id:n
    public function authenticate($email, $password) {
      $query = DB::connection()->prepare('SELECT * FROM Friend WHERE email = :email AND password = :password LIMIT 1');
      $query->execute(array('email' => $email, 'password' => $password));
      $row = $query->fetch();

      if($row) {
        return Friend::find($row['friendid']);
      } else {
        return null;
      } 
    }
}
