<?php

namespace Report\Managers;

class AuthManager extends BaseManager
{

	/**
	 * @var boolean $remember
	 */
	protected $remember = false;

	/**
     * @param array $data
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data   = array_only($data, array_keys($this->getRules()));
    }

	/**
	 * @param array $credentials
	 * @return boolean
	 */
	public function auth($credentials)
	{
		return \Auth::attempt($credentials, $this->remember);
	}

	/**
	 * @return array
	 */
	public function getRules()
	{
		return [
			'username' => 'integer|required|exists:users,username',
			'password' => 'min:6|max:25|required',
			'remember' => ''
		];
	}

	/**
     * @var array $data
     * @return array $data
     */
    public function prepareData(array $data)
    {

    	if (isset($data['remember'])) {
    		$this->remember = true;
    	}

    	$data = ['username' => $data['username'], 'password' => $data['password']];

        return $data;
    }

	/**
	 * @return boolean
	 */
	public function save()
	{
		$this->isValid();

		return $this->auth($this->prepareData($this->data));
	}
}