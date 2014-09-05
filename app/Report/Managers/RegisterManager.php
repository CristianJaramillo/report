<?php

namespace Report\Managers;

class RegisterManager extends BaseManager
{
	/**
	 * @return array
	 */
	public function getRules(){
		return [
			'full_name'        => 'min:3|max:50|required',
			'username'         => 'integer|required|unique:users,username',
			'password'         => 'confirmed|min:6|max:25|required',
			'password_confirmation' => 'min:6|max:25|required',
			'email'            => 'confirmed|email|required|unique:users,email',
			'email_confirmation' => 'required',
			'category_id'      => 'exists:categories,id|required',
			'departament_id'   => 'exists:departaments,id|required',
		];
	}

	/**
	 * @param array $data
	 * @return array $data
	 */
	public function preparateData(array $data)
	{
		$data['full_name'] = strip_tags($data['full_name']);
	
		$delete = ['password_confirmation', 'email_confirmation'];

		foreach ($delete as $value) {
			unset($data[$value]);
		}

		return $data;

	}

}