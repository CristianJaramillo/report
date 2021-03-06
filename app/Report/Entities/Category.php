<?php 

namespace Report\Entities;

class Category extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'categories';
	
	/**
	 * The attibutes from the method create.
	 *
	 * @var array
	 */
	protected $fillable = ['name'];

	/**
	 * return string
	 */
	public function getNameAttribute($value)
	{
		return utf8_encode($value);
	}

	/**
	 * The utf8_decode name.
	 *
	 * @var string 
	 */
	public function setNameAttribute($value)
    {
        if (!empty($value) && is_string($value))
        {
            $this->attributes['name'] = utf8_decode($value);
        }
    }

}