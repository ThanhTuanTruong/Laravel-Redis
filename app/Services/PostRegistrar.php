<?php
namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Validator;

class PostRegistrar
{
	public function validator(array $data)
	{
		return Validator::make($data, [
			'title' => 'required|max:255',
			'author' => 'required|max:255',
			'content' => 'required|min:6',
		]);
	}

	public function create(array $data)
	{
		return Post::create([
			'title' => $data['title'],
			'author' => $data['author'],
			'content' => $data['content'],
		]);
	}

}
