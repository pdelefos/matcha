<?php

namespace App\Classes;

use App\Classes\ErrorHandler;

class Validator {

    protected $errorHandler;

    protected $rules = ['required', 'minlength', 'maxlength', 'email', 'alnum', 'maj'];

    public $messages = [
        'required' => 'The :field field is required',
        'minlength' => 'The :field field must be a minimum of :satisfier length',
        'maxlength' => 'The :field field must be a maximum of :satisfier length',
        'email' => 'email invalid',
        'alnum' => 'The :field field must be alphanumeric',
        'maj' => 'il faut des maj sur :field'
    ];

    public function __construct(ErrorHandler $errorHandler) {
        $this->errorHandler = $errorHandler;
    }

    public function check($items, $rules) {
        foreach ($items as $item => $value) {
            if (in_array($item, array_keys($rules))) {
                $this->validate([
                    'field' => $item,
                    'value' => $value,
                    'rules' => $rules[$item]
                ]);
            }
        }
    }

    public function fails() {
        return $this->errorHandler->hasErrors();
    }

    public function errors() {
        return $this->errorHandler;
    }

    protected function validate($item) {
        $field = $item['field'];
        foreach ($item['rules'] as $rule => $satisfier) {
            if (in_array($rule, $this->rules)) {
                if (!call_user_func_array([$this, $rule], [$field, $item['value'], $satisfier])) {
                    $this->errorHandler->addError(
                        str_replace([':field', ':satisfier'], [$field, $satisfier], $this->messages[$rule]),
                        $field
                    );
                }
            }
        }
    }

    protected function required($field, $value, $satisfier) {
        return !empty(trim($value));
    }

    protected function minlength($field, $value, $satisfier) {
        return mb_strlen($value) >= $satisfier;
    }

    protected function maxlength($field, $value, $satisfier) {
        return mb_strlen($value) <= $satisfier;
    }

    protected function email($field, $value, $satisfier) {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    protected function alnum($field, $value, $satisfier) {
        return ctype_alnum($value);
    }

    protected function maj($field, $value, $satisfier) {
        return ctype_upper($value);
    }
}