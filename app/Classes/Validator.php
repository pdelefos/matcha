<?php

namespace App\Classes;

use App\Classes\ErrorHandler;
use App\Models\User;

class Validator {

    protected $errorHandler;

    protected $rules = ['required', 'minlength', 'maxlength', 'email', 'alnum', 'password', 'uniqueEmail', 'uniqueLogin'];

    public $messages = [
        'required' => 'Le champ :field est requis',
        'minlength' => 'Le champ :field doit faire au minimum :condition caractères',
        'maxlength' => 'Le champ :field doit faire au maximum :condition caractères',
        'email' => 'Cet email est invalide',
        'alnum' => 'Le champ :field doit être composé uniquement de chiffres et de lettres',
        'password' => 'Le mot de passe doit comporter une majuscule, une minuscule et un chiffre', 
        'uniqueEmail' => 'Cet email est déjà utilisé',
        'uniqueLogin' => 'Ce login est déjà utilisé'
    ];

    public function __construct(ErrorHandler $errorHandler) {
        $this->errorHandler = $errorHandler;
    }

    // Récupère pour chaque input la valeur et les regles, puis les valide
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

    // Applique chaque function de validation a l'input
    // les erreurs sont ajouté a l'errorHandler
    protected function validate($item) {
        $field = $item['field'];
        foreach ($item['rules'] as $rule => $condition) {
            if (in_array($rule, $this->rules) && $condition != false) {
                if (!call_user_func_array([$this, $rule], [$field, $item['value'], $condition])) {
                    $this->errorHandler->addError(
                        str_replace([':field', ':condition'], [$field, $condition], $this->messages[$rule]),
                        $field
                    );
                }
            }
        }
    }

    // renvoi false s'il y a des erreurs dans l'errorHandler
    public function fails() {
        return $this->errorHandler->hasErrors();
    }

    // renvoi l'errorHandler
    public function errors() {
        return $this->errorHandler;
    }

    //======================================================================
    // VALIDATION FUNCTIONS
    //======================================================================

    // Verifie que le valeur n'est pas vide
    protected function required($field, $value, $condition) {
        return !empty(trim($value));
    }

    // Verifie que la valeur est superieur a la condition
    protected function minlength($field, $value, $condition) {
        return mb_strlen($value) >= $condition;
    }

    // Verifie que la valeur est inferieur a la condition
    protected function maxlength($field, $value, $condition) {
        return mb_strlen($value) <= $condition;
    }

    // Verifie que la valeur est un email valide
    protected function email($field, $value, $condition) {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    // Verifie que la valeur n'est composé que de valeurs alphanumeriques
    protected function alnum($field, $value, $condition) {
        return ctype_alnum($value);
    }

    // Verifie que le mot de passe est composé d'une majuscule, une minuscule et un chiffre
    protected function password($field, $value, $condition) {
        $uppercase = preg_match('/[A-Z]/', $value);
        $lowercase = preg_match('/[a-z]/', $value);
        $number    = preg_match('/[0-9]/', $value);
        
        if(!$uppercase || !$lowercase || !$number)
            return false;
        return true;
    }

    // Verifie si le champ email existent déjà en base
    protected function uniqueEmail($field, $value, $condition) {
        return User::emailExists($value) ? false : true;
    }

    // Verifie si le champ login existent déjà en base
    protected function uniqueLogin($field, $value, $condition) {
        return User::loginExists($value) ? false : true;
    }
}