<?php

namespace Report\Repositories;

use Report\Entities\Page;

/**
 * 
 */
class PageRepo extends BaseRepo
{
	
	/**
	 * The filter page not authorized
	 * 
	 * @param $auth
	 * @return Eloquent
	 */
	public function current()
    {
        return $this->model->current()->first();
    }

	/**
	 *
	 */
	public function getModel()
	{
		return new Page;
	}

}