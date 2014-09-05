<?php

namespace Report\Managers;

class TableUIManager extends BaseManager
{
	/**
	 * @var return array
	 */	
	public function getRules()
	{
		return [
			"_token" => "required|confirmed",
			"action" => "required|min:4|max:20"
		];
	}
}