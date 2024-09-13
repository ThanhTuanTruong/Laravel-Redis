<?php

namespace App\Models;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use App\Contracts\PostContract as PostContract;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements PostContract 
{
	protected $table = 'blog_posts';

	protected $fillable = ['id', 'title', 'author', 'content'];

	public function fetchAll()
	{
        $result = Cache::remember('blog_posts_cache', 60, function () {
            return $this->get();
        });

		return $result;
	}

	public function fetch( $id )
	{
        // $this->storage = Redis::connection();

        // $this->id = $id;

        // $this->storage->pipeline(function ($pipe){
        //     $pipe->zIncrBy('articleViews', 1, 'article:' . $this->id);
        //     $pipe->incr('article:' . $this->id . ':views');
        // });

		return $this->where('id', $id)->first();
	}

    public function getPostViews($id)
    {
        $this->storage = Redis::connection();

        return $this->storage->get('article:' . $id . ':views');
    }

    public function getViews()
    {
        
    }

    public function filterFetch($id)
	{
		return $this->whereIn('id', $id)
		// ->orderBy('created_at', 'desc')
		->get();
	}
}
