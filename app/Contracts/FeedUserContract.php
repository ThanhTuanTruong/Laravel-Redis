<?php 
namespace App\Contracts;

interface FeedUserContract {

	/**
	 * Get a list of users
	 * 
	 * @return Object posts
	 */
	public static function getUserList($userID, $num);
}