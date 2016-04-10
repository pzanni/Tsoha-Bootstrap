<?php

  class PostController extends BaseController {
  	public static function posts() {
  		$posts = Post::all();
  		View::make('posts.html', array('posts' => $posts));
  	}

  	public static function post($postid) {
  		$post = Post::find($postid);
  		View::make('post.html', array('post' => $post));
  	}

    public static function store() {
      $params = $_POST;
      $post = new Post(array(
        'title' => $params['title'],
        'content' => $params['content'],
        ));
      $post->save();


      Redirect::to('/post/' . $post->postid, array('post' => $post));
    }

    public static function create() {
      View::make('addpost.html');
    }
  }