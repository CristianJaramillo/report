<?php

namespace Report\Repositories;

use Report\Entities\Page;

/**
 * 
 */
class PageRepo extends BaseRepo
{
	
	/**
	 *
	 */
	public function getModel()
	{
		return new Page;
	}

}