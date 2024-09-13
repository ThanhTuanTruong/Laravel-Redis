<?php namespace App\Services;

use App\Models\Update;
use Illuminate\Support\Facades\Validator;

class UpdateRegistrar {

	/**
	 * Get a validator for an incoming post submission.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'update' => 'required|max:50|min:5',
		]);
	}

	/**
	 * Create a new post instance after a valid submission.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data, $id)
	{
		return Update::create([
			'update' => $data['update'],
			'userID' => $id,
		]);
	}
}
