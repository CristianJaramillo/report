<?php

namespace Report\Managers;

abstract class BaseManager {

    /**
     * @var \Eloquent $entity
     */
    protected $entity;

    /**
     * @var array
     */
    protected $data;

    /**
     * @param \Eloquent $entity
     * @param array $data
     * @return void
     */
    public function __construct($entity, array $data)
    {
        $this->entity = $entity;
        $this->data   = array_only($data, array_keys($this->getRules()));
    }

    /**
     * @return array
     */
    abstract public function getRules();

    /**
     * @return void
     * @throws ValidationException
     */
    public function isValid()
    {
        $rules = $this->getRules();

        $validation = \Validator::make($this->data, $rules);

        if ($validation->fails())
        {
            throw new ValidationException('Validation failed', $validation->messages());
        }
    }

    /**
     * @var array $data
     * @return array $data
     */
    public function prepareData(array $data)
    {
        return $data;
    }

    /**
     * @return boolean true
     * @throws ValidationException
     */
    public function save()
    {
        $this->isValid();
        $this->entity->fill($this->prepareData($this->data));
        $this->entity->save();

        return true;
    }

} 