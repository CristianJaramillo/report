<?php 

namespace Report\Entities;

class Page extends \Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';
	
	/**
	 * The attibutes from the method create.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'layout', 'lang', 'title', 'description', 'menu', 'app'];

	/**
	 * return utf8_encode description.
	 *
	 * @var string 
	 */
	public function getDescriptionAttribute($value)
    {
        return utf8_encode($this->attributes['description']);
    }

	/**
	 * return utf8_encode title.
	 *
	 * @var string 
	 */
	public function getTitleAttribute()
    {
        return utf8_encode($this->attributes['title']);
    }

    /**
	 * The filter users not authorized
	 * 
	 * @param $query
	 * @return $query
	 */
	public function scopeCurrent($query)
    {
        return $query->where('name', '=', \Route::currentRouteName());
    }

	/**
	 * The utf8_decode description.
	 *
	 * @var string 
	 */
	public function setDescriptionAttribute($value)
    {
        if (!empty($value))
        {
            $this->attributes['description'] = utf8_decode($value);
        }
    }

	/**
	 * The utf8_decode title.
	 *
	 * @var string 
	 */
	public function setTitleAttribute($value)
    {
        if (!empty($value))
        {
            $this->attributes['title'] = utf8_decode($value);
        }
    }

}