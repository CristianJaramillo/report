<?php

namespace Report\Entities;

class File extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'files';

	/**
	 * The attibutes from the method create.
	 *
	 * @var array
	 */
	protected $fillable = ['post_id', 'path'];
}