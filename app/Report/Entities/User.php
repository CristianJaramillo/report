<?php

namespace Report\Entities;

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends \Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes defining guarded
	 *
	 * @var array
	 */	
	protected $guarded = ['password', 'type', 'authorized', 'ip_address', 'country', 'city', 'remember_token'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'type', 'authorized', 'ip_address', 'country', 'city', 'remember_token'];

	/**
	 * The attibutes from the method create.
	 *
	 * @var array
	 */
	protected $fillable = ['full_name', 'username', 'email', 'password', 'departament_id', 'category_id'];

	/**
	 * 
	 * 
	 * @return \Lang
	 */
	public function getUserTypeAttribute()
    {
        return \Lang::get('utils.user_types.' . $this->type);
    }

	/**
	 * The filter users not authorized
	 * 
	 * @param $query
	 * @param $auth
	 * @return $query
	 */
	public function scopeAuthorized($query, $auth = false)
    {
        return $query->where('authorized', '=', $auth);
    }

	/**
	 * The decode to utf8.
	 *
	 * @var string 
	 */
	public function setCityAttribute($value)
    {
        if (!empty($value))
        {
            $this->attributes['city'] = utf8_decode($value);
        } else
        {
        	$this->attributes['city'] = 'undefined';
        }
    }

	/**
	 * The decode to utf8.
	 *
	 * @var string 
	 */
	public function setCountryAttribute($value)
    {
        if (!empty($value))
        {
            $this->attributes['country'] = utf8_decode($value);
        }
    }

	/**
	 * The The decode to utf8..
	 *
	 * @var string 
	 */
	public function setFullNameAttribute($value)
    {
        if (!empty($value))
        {
            $this->attributes['full_name'] = utf8_decode($value);
        }
    }

	/**
	 * The password encrypt.
	 *
	 * @var string 
	 */
	public function setPasswordAttribute($value)
    {
        if (!empty($value))
        {
            $this->attributes['password'] = \Hash::make($value);
        }
    }

}