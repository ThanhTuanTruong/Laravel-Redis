<?php
namespace App\Models;

use Illuminate\Support\Facades\Redis;
use App\Contracts\UpdateContract as UpdateContract;

class Update implements UpdateContract {

	/**
	 * Create an update
	 * 
	 * @param  array  $data 
	 * @return Boolean
	 */
	public static function create( array $data )
	{
		// Get unique post ID
		$postID = Redis::incr('next_post_id');

		$time = time();

		// Create the post message
		$postSuccess = Redis::hmset('post:' . $postID, 
			[ 
				'user_id' => $data['userID'], 
				'time' => $time, 
				'text' => $data['update'] 
			]
		);

		if ($postSuccess)
		{
			// Push update to followers after successful creation
			if ( Update::pushUpdate($postID, $data['userID']) )
			{
				// Everything succeeded, so return the new post's ID
				return $postID;
			}

			// Unsuccessful push to followers. Delete post and decrement ID
			// In real world case we could queue and try again or give user another chance
			Redis::delete('post:' . $postID);
			Redis::decr('next_post_id');
		}

		return false;		
	}

	/**
	 * Send update to all follower's feeds
	 * 
	 * @param  $postID
	 * @param  $userID
	 * @return Boolean
	 */
	public static function pushUpdate($postID, $userID)
	{
		// Get all the user's followers
		$followers = Redis::zRange('followers:' . $userID, 0, -1);

		// Include update author
		$followers[] = $userID;

		// Push the update to all followers
		foreach ($followers as $followerID) 
		{
			$pushSuccess = Redis::lpush('posts:' . $followerID, $postID);
		}
		// Success of update push to followers
		if ($pushSuccess)
		{
			return true;
		}

		return false;
	}

	/**
	 * Get updates associated with specified IDs
	 * 
	 * @param  $postIDs
	 * @return array Posts
	 */
	public function getPosts($postIDs)
	{
		$posts = [];

		foreach($postIDs as $postID)
		{
			// Get all fields and values in the hash
			$posts[$postID] = Redis::hGetAll('post:' . $postID);

			// Get username of user who wrote post
			$userName = Redis::hGet('user:' . $posts[$postID]['user_id'], 'username');

			// Add username to array
			$posts[$postID]['username'] = $userName;
		}

		return $posts;
	}

}
