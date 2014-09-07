<?php

namespace Report\Repositories;

use GeoIp2\Database\Reader as GeoIp;
use Report\Entities\User;

class UserRepo extends BaseRepo
{
	
	/**
	 * The filter users not authorized
	 * 
	 * @param $auth
	 * @return Eloquent
	 */
	public function authorized($auth = false)
    {
        return $this->model->authorized($auth)->get();
    }

	/**
	 * @return Report\Entities\User
	 */
	public function getModel()
	{
		return new User;
	}

	/**
	 * @return Report\Entities\User
	 * @throws \MaxMind\Db\Reader\InvalidDatabaseException if the database
     *          is corrupt or invalid
	 */
	public function newUser()
	{
		$user = new User();

		$user->ip_address = '201.141.89.52';

		$geoIp = new GeoIp(app_path('database/GeoLite2-City.mmdb'));

		$record = $geoIp->city($user->ip_address);

		$user->country = $record->country->names['es'];
		$user->city    = $record->mostSpecificSubdivision->names['es'];

		return $user;

	}

}