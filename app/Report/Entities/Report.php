<?php

namespace Report\Entities;

class Report extends \Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'reports';

	/**
	 * The attibutes from the method create.
	 *
	 * @var array
	 */
	protected $fillable = ['title', 'message', 'client_id'];

}