<?php

namespace Utility;

/**
 * Validator class : automatic validation of the input
 *
 * @author martin
 * @return \Utility\Validator
 */
class Validator extends \Utility\MainUtility {

    /**
     *
     * @var Array $validations 
     * Contains the validation list 
     * 
     */
    private $validations = Array();
    private $defaultForbidden = '!@#$%^&*{}[]~`|\\\/<>"\';';

    /**
     * 
     * @var Array $errors 
     * 
     * Contains list of the errors found during the validation process
     * 
     */
    private $errors = Array();

    /**
     * Required. Cannot be empty
     */
    const PATTERN_REQUIRED = 'validateRequired';
    const PATTERN_MIN_LENGTH = 'validateMinLength';
    const PATTERN_MAX_LENGTH = 'validateMaxLength';
    const PATTERN_NUMBER_ONLY = 'validateNumberOnly';
    const PATTERN_REGEX = 'validateRegex';
    const PATTERN_EMAIL = 'validateEmail';
    const PATTERN_URL = 'validateUrl';
    const PATTERN_IP = 'validateIp';
    const PATTERN_FORBIDDEN = 'validateForbidden';
    const PATTERN_MUST_START_WITH_NUMBER = 'validateMustStartWithNumber';
    const PATTERN_MUST_NOT_START_WITH_NUMBER = 'validateMustNotStartWithNumber';
    const PATTERN_MIN_VALUE = 'validateMinValue';
    const PATTERN_MAX_VALUE = 'validateMaxValue';
    const PATTERN_CUSTOM_FUNCTION = 'validateCustomFunction';

    public function addValidation($field_name = NULL, $pattern = NULL, $params = NULL, $err_message = NULL) {

        $refl = new \ReflectionClass($this);
        $constants = $refl->getConstants();

        if ($field_name === NULL) {
            die('You must specify a field name');
        }
        if ($pattern === NULL || (!in_array($pattern, $constants))) {
            die('You must specify a existing validation method');
        }


        if (!isset($this->validations[$field_name])) {
            $this->validations[$field_name] = Array();
        }


        switch ($pattern) {
            case self::PATTERN_MIN_LENGTH :
            case self::PATTERN_MAX_LENGTH :
            case self::PATTERN_MIN_VALUE :
            case self::PATTERN_MAX_VALUE : {
                    if (!is_numeric($params)) {
                        die('You must provid a valid number in the params.');
                    }
                    break;
                }
            case self::PATTERN_REGEX : {
                    if (@preg_match($params, NULL) === FALSE) {
                        die('Invalid regular expression provided');
                    }
                    break;
                }
            case self::PATTERN_CUSTOM_FUNCTION : {
                    if (!is_callable($params)) {
                        die('You must provide a valid callable function');
                    }
                    break;
                }
            default : break;
        }

        $this->validations[$field_name][] = Array(
            'method' => $pattern,
            'params' => $params,
            'err_message' => $err_message);
    }

    public function validateAll($input) {
        $this->errors = Array();
        foreach ($input as $key => $value) {
            if (isset($this->validations[$key])) {
                foreach ($this->validations[$key] as $validationAction) {
                    if (method_exists($this, '_' . $validationAction['method'])) {
                        $validation = $this->{'_' . $validationAction['method']}($validationAction['params'], $value);
                        if (!$validation['result']) {
                            $this->errors[$key][] = ($validationAction['err_message'] !== NULL) ? $validationAction['err_message'] : $validation['default_message'];
                        }
                    }
                }
            }
        }
        return $this->errors;
    }

    public function clear(){
        $this->validations = Array();
    }

    private function _validateRequired($params = NULL, $value) {
        return Array(
            'result' => trim($value) != '',
            'default_message' => 'This field is required!'
        );
    }

    private function _validateEmail($params = NULL, $value) {
        return Array(
            'result' => (trim($value) == '') || (filter_var($value, FILTER_VALIDATE_EMAIL) !== false),
            'default_message' => 'This is not valid email address'
        );
    }

    private function _validateMinLength($params = NULL, $value) {
        return Array(
            'result' => !(mb_strlen(trim($value)) < $params),
            'default_message' => 'The field cannot be shorter than <b>' . $params . '</b> characters.'
        );
    }

    private function _validateMaxLength($params = NULL, $value) {
        return Array(
            'result' => !(mb_strlen(trim($value)) > $params),
            'default_message' => 'The field cannot be longer than <b>' . $params . '</b> characters.'
        );
    }

    private function _validateNumberOnly($params = NULL, $value) {
        return Array(
            'result' => (is_numeric($value)) || (trim($value) == ''),
            'default_message' => 'You can use only numbers'
        );
    }

    private function _validateUrl($params = NULL, $value) {
        return Array(
            'result' => (filter_var($value, FILTER_VALIDATE_URL) !== FALSE) || (trim($value) == ''),
            'default_message' => '<strong>' . $value . '</strong> is not valid URL'
        );
    }
    
    private function _validateIp($params = NULL, $value) {
        return Array(
            'result' => (filter_var($value, FILTER_VALIDATE_IP) !== FALSE) || (trim($value) == ''),
            'default_message' => '<strong>' . $value . '</strong> is not valid IP address'
        );
    }

    private function _validateRegex($params = NULL, $value) {
        return Array(
            'result' => (preg_match($params, $value) === 1),
            'default_message' => 'Invalid format'
        );
    }

    private function _validateForbidden($params = NULL, $value) {
        $_forbidden = ($params !== NULL) ? $params : $this->defaultForbidden;

        $found = Array();
        $forbiden = str_split($_forbidden);
        foreach ($forbiden as $char) {
            if (mb_strpos($value, $char) !== FALSE) {
                $found[] = '<strong style="color:blue">' . $char . '</strong>';
            }
        }
        return Array(
            'result' => (count($found) == 0),
            'default_message' => 'The field contains forbidden characters ' . implode(',', $found)
        );
    }

    private function _validateMustStartWithNumber($params = NULL, $value) {
        $_value = str_split($value);
        return Array(
            'result' => (is_numeric($_value[0])),
            'default_message' => 'This field MUST start with a number'
        );
    }

    private function _validateMustNotStartWithNumber($params = NULL, $value) {
        $_value = str_split($value);
        return Array(
            'result' => (!is_numeric($_value[0])),
            'default_message' => 'This field cannot start with a number'
        );
    }

    private function _validateMinValue($params = NULL, $value) {
        return Array(
            'result' => ($value >= $params),
            'default_message' => 'The field value cannot be less than <b>' . $params . '</b>.'
        );
    }

    private function _validateMaxValue($params = NULL, $value) {
        return Array(
            'result' => ($value <= $params),
            'default_message' => 'The field value cannot be less than <b>' . $params . '</b>.'
        );
    }

    private function _validateCustomFunction($params = NULL, $value) {
        return Array(
            'result' => $params($value),
            'default_message' => 'Validation failed.'
        );
    }

}
