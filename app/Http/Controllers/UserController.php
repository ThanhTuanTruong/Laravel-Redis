<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Contracts\UpdateContract as UpdateContract;
use App\Services\UpdateRegistrar as UpdateRegistrar;
use App\Models\FeedUser;

class UserController extends Controller
{
    protected $update;

	protected $updateRegistrar;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(UpdateContract $update, UpdateRegistrar $updateRegistrar)
	{
		$this->update = $update;
		$this->updateRegistrar = $updateRegistrar;
	}

	/**
	 * Take user to add update page
	 *
	 * @return Response
	 */
	public function showAddUpdate($id)
	{
		return view('user.update')->with([ 'userID' => $id ]);
	}

	/**
	 * Create update from user input
	 * 
	 * @return Response
	 */
	public function doAddUpdate(Request $request, $id)
	{
		$userInput = array(
			'update' 	=> $request->input('update')
		);

		// Validate input
		$validation = $this->updateRegistrar->validator($userInput);

		if ( $validation )
		{
			// Create update
			$result = $this->updateRegistrar->create($userInput, $id);

			if ( $result )
			{
				// Update posted. Redirect to newsfeed
				return view('user.newsfeed')->with([ 'message' => 'Update successfully posted', 'user_id' => $id ]);	
			}

		}

		// Update did not post successfully
		// return view('update')->withMessage('Update did not post. Please try again');
        return view('update')->with('success', 'Update did not post. Please try again');
	}

	/**
	 * Show list of all users except current user
	 * 
	 * @param  $id
	 * @return Response
	 */
	public function showUserList( $id )
	{
		if ( $users = FeedUser::getUserList( $id, 10 ) )
		{
			return view('user.userlist')->with([ 'users' => $users, 'current_user_id' => $id ]);
		}

		// return view('user.userList')->withMessage('No users to follow');
        return view('update')->with('success', 'No users to follow');
	}

	/**
	 * Follow a user
	 * 
	 * @param  $id     ID of current user
	 * @param  $userID ID of user to follow
	 * @return Response
	 */
	public function followUser( $id, $userID )
	{
		if ( FeedUser::followUser($id, $userID) )
			return view('user.followsuccess')->with([ 'message' => 'Successfully followed user.', 'user_id' => $id ]);

		return view('user.followsuccess')->with([ 'message' => 'Follow failed. Please try again', 'user_id' => $id ]);
	} 

	/**
	 * Show user news feed
	 * 
	 * @param  $userID
	 * @return Response
	 */
	public function showFeed($userID)
	{
		// Get 40 posts from people user follows
		Redis::ltrim('posts:' . $userID, 0, 100);

		// Get post IDs
		$postIDs = Redis::lRange('posts:' . $userID, 0, 100);

		// Get post information from IDs
		$posts = $this->update->getPosts($postIDs);

		// return view('user.newsfeed')->withPosts($posts);
        return view('user.newsfeed')->with([ 'posts' => $posts]);
	}
}
