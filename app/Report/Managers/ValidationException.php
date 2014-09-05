<?php 

namespace Report\Managers;

class ValidationException extends \Exception {

    /**
     * @var array
     */
    protected $errors;

    /**
     * @param string $message
     * @param array $errors
     * @return void
     */
    public function __construct($message, $errors)
    {
        $this->errors = $errors;
        parent::__construct($message);
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

} 