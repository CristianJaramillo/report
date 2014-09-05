<?php

namespace Report\Repositories;

abstract class BaseRepo {

	/**
	 * @var object
	 */
	protected $model;

	
	/**
	 *
	 */
	public function __construct()
    {
        $this->model = $this->getModel();
    }
    
    /**
     *
     */
    abstract public function getModel();

    public function all()
    {
        return $this->model->all();
    }

    public function where($key, $exp, $value)
    {
        return $this->model->where($key, $exp, $value)->first();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

}