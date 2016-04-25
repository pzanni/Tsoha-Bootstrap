<?php

  class PostController extends BaseController {
    //näyttää ilmoitukset-sivun kenelle tahansa
  	public static function posts() {
  		$posts = Post::all();
  		View::make('posts.html', array('posts' => $posts));
  	}

    //näyttää tietyn ilmoituksen kenelle tahansa
  	public static function post($postid) {
  		$post = Post::find($postid);
      $user_logged_in = parent::get_user_logged_in();
  		View::make('post.html', array('post' => $post, 'user_logged_in' => $user_logged_in));
  	}

    //tallentaa uuden ilmoituksen jos käyttäjä on sisäänkirjautunut ja ilmoituksessa ei ole virheitä
    public static function store() {
      $user_logged_in = parent::get_user_logged_in();
      self::check_logged_in();
      $params = $_POST;
      $attributes = (array(
        'title' => $params['title'],
        'content' => $params['content'],
        'sender' => parent::get_user_logged_in()
        ));
      $post = new Post($attributes);
      $errors = $post->errors();

      if(count($errors) == 0) {
        $post->save();
        Redirect::to('/post/' . $post->postid, array('post' => $post));
      } else {
        View::make('addpost.html', array('errors' => $errors, 'attributes' => $attributes));
      }
    }

    //näyttää ilmoituksen muokkaus -sivun jos käyttäjä on ilmoituksen lähettäjä
    public static function edit($postid) {
      $user_logged_in = parent::get_user_logged_in();
      $post = Post::find($postid);

      if($user_logged_in == $post->sender) {
        View::make('editpost.html', array('post' => $post));
      } else if ($user_logged_in != null) {
        Redirect::to('/post/' . $postid);
      } else {
        Redirect::to('/login');
      }
    }

    //päivittää ilmoituksen muokkaussivun mukaan (errorit ei toimi tässä :( ))
    public static function update($postid) {
      $user_logged_in = parent::get_user_logged_in();
      $params = $_POST;
      $post = Post::find($postid);
      $attributes = (array(
        'title' => $params['title'],
        'content' => $params['content'],
        'sender' => $post->sender,
        'posttime' => $post->posttime,
        'postid' => $postid
        ));
      $post = new Post($attributes);
      $errors = $post->errors();
      //if($errors > 0) {
      //  Redirect::to('/post/' . $postid . '/edit', array('errors' => $errors));
      if($user_logged_in == $post->sender) {
        $post->update();
        Redirect::to('/post/' . $postid);
      } else {
        Redirect::to('/login');
      }
    }

    //näyttää lisää ilmoitus -sivun jos käyttäjä on kirjautunut sisään
    public static function create() {
      self::check_logged_in();
      View::make('addpost.html'); 
    }

    //poistaa ilmoituksen jos käyttäjä on ilmoituksen lähettäjä
    public static function destroy($postid) {
      $user_logged_in = parent::get_user_logged_in();
      $oldpost = Post::find($postid);
      if($user_logged_in != $oldpost->sender) {
        Redirect::to('/login');
      } 
      $post = new Post(array('postid' => $postid));
      $post->destroy();
      Redirect::to('/posts', array('message' => 'Ilmoitus on poistettu'));
    }

    //näyttää haun mukaisen version ilmoitukset-sivusta
    public static function limited() {
      $params = $_POST;
      $lowerword = strtolower($params['searchword']);
      $searchword = array('searchword' => $lowerword);
      $posts = Post::findFromContent($searchword);
      View::make('posts.html', array('posts' => $posts, 'searchword' => $params['searchword']));
    }
  }

    