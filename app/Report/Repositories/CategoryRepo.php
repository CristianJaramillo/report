<?php

namespace Report\Repositories;

use Report\Entities\Category;

/**
 * 
 */
class CategoryRepo extends BaseRepo
{
	
	/**
	 *
	 */
	public function getModel()
	{
		return new Category;
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