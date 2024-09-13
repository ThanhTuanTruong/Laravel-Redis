<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\PostContract as PostContract;
use App\Services\PostRegistrar as PostRegistrar;
use Illuminate\Support\Facades\Redis;

class AdminController extends Controller
{
    public $post;
    public $postRegistrar;

    public function __construct(PostContract $post, PostRegistrar $postRegistrar)
	{
		$this->post = $post;
		$this->postRegistrar = $postRegistrar;
	}

    public function showAddArticle()
	{
		return view('admin.articles');
	}

    public function doAddArticle(Request $request)
	{
		$userInput = array(
			'title' 	=> $request->input('title'), 
			'author' 	=> $request->input('author'),
			'tags' 		=> $request->input('tagging'),
			'content' 	=> $request->input('inputContent')
		);

		$validation = $this->postRegistrar->validator($userInput);

		if ( $validation )
		{
			$result = $this->postRegistrar->create($userInput);

			if ( $result )
			{
				// Do we have any tags to add?
				if ( $userInput['tags'] != '' )
				{

					// Strip commas and spaces in tags input
					$filteredTags = explode(', ', trim($userInput['tags']));

					foreach( $filteredTags as $tag )
					{
						// Add a sorted set to maintain article order
						// This could also be a regular set, with DB sort used instead
						Redis::zadd('article:tag:' . $tag, $result['id'], $result['id'] );
						// Create set of tags for sepcific article so we can retrieve them later
						Redis::sadd('article:' . $result['id'] . ':tags', $tag);
						// Add tag to master list of tags
						Redis::sadd('article:tags', $tag);
					}

				}

				return view('admin.articles')->with('message', 'Post successfully created');
			}

			return view('admin.articles')->with('message', 'Error. Validation did not pass');

		}

		return view('admin.articles');
	}
}
