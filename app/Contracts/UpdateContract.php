<?php
namespace App\Contracts;

interface UpdateContract {

	/**
	 * Retrieve all posts
	 * 
	 * @return Object posts
	 */
	public static function create(array $data);

	public static function pushUpdate($postID, $userID);

    public function getPosts($postIDs);
}