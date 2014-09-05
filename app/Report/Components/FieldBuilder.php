<?php

namespace Report\Components;

use Illuminate\Html\FormBuilder as Form;
use Illuminate\View\Factory as View;
use Illuminate\Session\Store as Session;

class FieldBuilder {

    protected $form;
    protected $view;
    protected $session;

    protected $defaultClass = [
        'default'  => 'ease'
    ];

    public function __construct(Form $form, View $view, Session $session)
    {
        $this->form = $form;
        $this->view = $view;
        $this->session = $session;
    }

    public function getDefaultClass($type)
    {
        if (isset ($this->defaultClass[$type]))
        {
            return $this->defaultClass[$type];
        }

        return $this->defaultClass['default'];
    }

    public function buildCssClasses($type, &$attributes)
    {
        $defaultClasses = $this->getDefaultClass($type);

        if (isset ($attributes['class']))
        {
            $attributes['class'] .= ' ' . $defaultClasses;
        }
        else
        {
            $attributes['class'] = $defaultClasses;
        }
    }

    public function buildLabel($name)
    {
        if (\Lang::has('validation.attributes.' . $name))
        {
            $label = \Lang::get('validation.attributes.' . $name);
        }
        else
        {
            $label = str_replace('_', ' ', $name);
        }

        return ucfirst($label);
    }

    public function buildControl($type, $name, $value = null, $attributes = array(), $options = array())
    {
        switch ($type)
        {
            case 'email':
                return $this->form->email($name, $value, $attributes);
            case 'checkbox':
                return $this->form->checkbox($name, NULL, NULL,$attributes);
            case 'password':
                return $this->form->password($name, $attributes);
            case 'select':
                $options = array('' => '--- Elije una opción ---') + $options;
                return $this->form->select($name, $options, $value, $attributes);
            case 'textarea':
                return $this->form->textarea($name, $value, $attributes);
            default:
                return $this->form->input($type, $name, $value, $attributes);
        }
    }

    public function buildError($name)
    {
        $error = null;
        if ($this->session->has('errors'))
        {
            $errors = $this->session->get('errors');

            if ($errors->has($name))
            {
                $error = $errors->first($name);
            }
        }
        return $error;
    }

    public function buildTemplate($template)
    {
        if (\File::exists(app_path('views/fields/'.$template.'.blade.php')))
        {
            return 'fields/' . $template;
        }

        return 'fields/default';
    }

    public function input($type, $name, $value = null, $attributes = array(), $options = array(), $template = NULL)
    {
        $this->buildCssClasses($type, $attributes);
        $label = $this->buildLabel($name);
        $control = $this->buildControl($type, $name, $value, $attributes, $options);
        $error = $this->buildError($name);
        $template = $this->buildTemplate($template);

        return $this->view->make($template, compact ('name', 'label', 'control', 'error'));
    }

    public function password($name, $attributes = array(), $template = NULL)
    {
        return $this->input('password', $name, null, $attributes, NULL, $template);
    }

    public function select($name, $options, $value = null, $attributes = array(), $template = NULL)
    {
        return $this->input('select', $name, $value, $attributes, $options, $template);
    }

    public function __call($method, $params)
    {
        array_unshift($params, $method);
        return call_user_func_array([$this, 'input'], $params);
    }
} 