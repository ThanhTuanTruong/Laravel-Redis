<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Contracts\PostContract as PostContract;

class BlogController extends Controller
{
    public $id;
    public $post;

    public function __construct(PostContract $post)
    {
        $this->post = $post;
    }

    // public function index()
    // {
    //     //DB::connection()->enableQueryLog();

    //     $posts = $this->post->fetchAll();

    //     //$log = DB::getQueryLog();

    //     //print_r($log);

    //     return view('home')->with([ 'posts' => $posts]);
    // }

    // public function showArticle($id)
    // {
    //     $this->id = $id;
    //     $storage = Redis::connection();

    //     if ($storage->zScore('articleViews', 'article:' . $id)) {
    //         $storage->pipeline(function($pipe){
    //             $pipe->zIncrBy('articleViews', 1, 'article:' . $this->id);
    //             $pipe->incr('article:' . $this->id . ':views');
    //         });

    //     } else {
    //         $views = $storage->incr('article:' . $this->id . ':views');
    //         $storage->zIncrBy('articleViews', $views, 'article:' . $this->id);
    //     }

    //     $views = $storage->get('article:' . $this->id . ':views'); 

    //     return 'This is an article with id: ' . $id . '. It has ' . $views . ' views';
    // }

	public function create(Request $request)
	{
		$blog = $request->input('blog');
		Redis::publish('create:blog', json_encode($blog));
		return $blog;
	}

    public function index()
	{
		$posts = $this->post->fetchAll();

		$tags = Redis::sRandMember('article:tags', 4);

		return view('home')->with([ 'posts' => $posts, 'tags' => $tags ]);
	}

    public function showArticle( $id )
	{
		// Fetch post
		$article = $this->post->fetch($id);

		if ( $article )
		{

			// Increment article views
			$views = Redis::pipeline(function ($pipe) use ($id)
			{
				$pipe->zIncrBy('articleViews', 1, 'article:' . $id);
				$pipe->incr('article:' . $id . ':views');
			});

			// Get number of views from resulting array of Redis::pipeline
			$views = $views['1'];

			// Get article's tags
			$tags = Redis::sMembers('article:' . $id . ':tags');

			return view('blog.article')->with([ 'article' => $article, 'views' => $views, 'tags' => $tags ]);

		}

		return view('errors.404');
	}

    public function showFilteredArticles( $tag )
	{
		// Array of post IDs matching the tag filter
		$postIDs = Redis::zRange('article:tag:' . $tag, 0, -1);

		// Fetch posts
		$posts = $this->post->filterFetch($postIDs);

		// Return more random tags
		// We can ensure we don't repeat the same tag by fetching +1 tag
		// and checking if it matches $tag 
		$tags = Redis::sRandMember('article:tags', 4);

		return view('home')->with([ 'posts' => $posts, 'tags' => $tags ]);
	}
}
