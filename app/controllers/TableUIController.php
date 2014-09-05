<?php

use Report\Tools\TableUI;

class TableUIController extends BaseController {


	// Datos a procesar.
	protected $data = [];
	// Datos recibidos.
	protected $input = [
		"_token"  => NULL,
		"action"  => NULL 
        // "limit"    => NULL,
        // "offset"   => NULL,
	];
	// Reglas de validación
	protected $rules = [
		"_token"  => "required|confirmed",
		"action" => "required|min:4|max:20"
        // "limit"    => "required|numeric|min:1|max:4",
        // "offset"   => "required|numeric|min:1|max:4", 
	];
    // Mensajes de error.
    protected $messages = [
        "required"  => "El campo :attribute es obligatorio.",
        "numeric"   => "El campo :attribute debe ser un número.",
        "min"       => "El campo :attribute no puede tener menos de :min carácteres.",
        "max"       => "El campo :attribute no puede tener más de :min carácteres."
    ];
	// Respuesta por defecto para cualquier solicitud.
	protected $response = [
		"errors"   => NULL,
		"messages" => NULL,
		"success"  => NULL
	];

	/*
	 * 
	 */
	public function addError($error){
		$this->response["errors"] = $error;
	}

	/**
	 *
	 */
	public function addMessage($message){
		$this->response["messages"] = $message;
	}

	/**
	 *
	 */
	public function addSuccess($success){
		$this->response["success"] = $success;
	}

	/**
	 *
	 */
	public function ajax(){
	
		if (Request::ajax())
		{
			if (Input::has("_token", "action")) 
			{
				$this->setInput(Input::only("_token", "action"));
				$this->setData(Input::except("_token", "action", "limit", "offset", "table"));	
				$content = Input::only("limit", "offset", "table");

				if ($this->validate()) 
				{
					if (isset($content["table"])) 
					{
						$this->addSuccess(TableUI::getQuery($this->input['action'], $this->data, $content["table"]));
					} else {
						$this->addSuccess(TableUI::getQuery($this->input['action']));
					}
				}
			}
		}

		return $this->getResponse();
	
	}

	/**
	 *
	 */
	public function getResponse(){
		$response = $this->response;
		$this->utf8_encode_deep($response);
		$this->response = $response;
		return Response::json($response);
	}

	/**
	 *
	 */
	public function setData($data){
		$this->data = $data;
	}

	/**
	 *
	 */
	public function setInput($input){
		$input['_token_confirmation'] = csrf_token();
		$this->input = $input;
	}

	/**
	 *
	 */
	public function utf8_encode_deep(&$input) {
	    if (is_string($input)) {
	        $input = utf8_encode($input);
	    } else if (is_array($input)) {
	        foreach ($input as &$value) {
	            $this->utf8_encode_deep($value);
	        }

	        unset($value);
	    } else if (is_object($input)) {
	        $vars = array_keys(get_object_vars($input));

	        foreach ($vars as $var) {
	            $this->utf8_encode_deep($input->$var);
	        }
	    }
	}

	/**
	 * Valida los datos recibidos de la petición.
	 */
	public function validate(){
		$this->validation = Validator::make($this->input, $this->rules, $this->messages);
		$this->addMessage($this->validation->getMessageBag()->toArray());
		return $this->validation->fails() == TRUE ? FALSE : TRUE;
	}

}