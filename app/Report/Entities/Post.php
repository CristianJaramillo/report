<?php

namespace Report\Entities;

class Post extends \Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';

	/**
	 * The attibutes from the method create.
	 *
	 * @var array
	 */
	protected $fillable = ['report_id', 'user_id', 'message', 'type'];

}