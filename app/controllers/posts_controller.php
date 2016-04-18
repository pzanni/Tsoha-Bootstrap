<?php

  class PostController extends BaseController {
  	public static function posts() {
  		$posts = Post::all();
  		View::make('posts.html', array('posts' => $posts));
  	}

  	public static function post($postid) {
  		$post = Post::find($postid);
      $user_logged_in = parent::get_user_logged_in();
  		View::make('post.html', array('post' => $post, 'user_logged_in' => $user_logged_in));
  	}

    public static function store() {
      $user_logged_in = parent::get_user_logged_in();
      if($user_logged_in == null) {
        Redirect::to('/login');
      }
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

    public static function create() {
      $user_logged_in = parent::get_user_logged_in();
      if($user_logged_in == null) {
        Redirect::to('/login');
      } else {
        View::make('addpost.html');
      }
    }

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
  }