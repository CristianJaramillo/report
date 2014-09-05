<?php

namespace Report\Repositories;

use Report\Entities\Departament;

/**
 * 
 */
class DepartamentRepo extends BaseRepo
{
	
	/**
	 *
	 */
	public function getModel()
	{
		return new Departament;
	}

	/**
	 * 
	 * return
	 */
	public function getList()
	{
		return $this->model->lists('name', 'id');
	}

}