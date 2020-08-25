<?php
/**
 * User: Zemlyansky Alexander <astrolog@online.ua>
 */

namespace osoznan\patri;

/**
 * Class Model
 * The base Model object
 *
 */
class Model extends Component {
    public static $validatorsClass = ModelValidator::class;

    protected $errors;

    public function __construct(array $attributes = null) {
        $attributes ? $this->load($attributes) : null;

        $this->init();
    }

    public function init() {}

    public static function tableName() {
        return null;
    }

    public function rules() {
        return [];
    }

    public static function labels() {
        return [];
    }

    /**
     * Validates a single rule for a single attribute
     * @param $rule
     * @param $attribute
     */
    public function validateRule($rule, $attribute) {
        $validator = next($rule);
        $param = next($rule) ? [key($rule) => current($rule)] : null;
        if (!is_callable($validator)) {
            $result = static::$validatorsClass::$validator($this->$attribute ?? null, $param);
            if ($result !== true) {
                $this->errors[$attribute][] = $result;
            }
        } else {
            call_user_func($validator, $this);
        }
    }

    /**
     * Validation process of a single record data
     * @return bool
     */
    public function validate($attributes = null) {
        $this->errors = [];

        foreach ($this->rules() as $rule) {
            $attribute = reset($rule);

            foreach (is_array($attribute) ? $attribute : [ $attribute ] as $attr) {
                if (!$attributes || in_array($attr, $attributes)) {
                    $this->validateRule($rule, $attr);
                }
            }
        }

        return count($this->errors) == 0;
    }

    public static function attributes() {
        return [];
    }

    public function getAttributes() {
        $attrs = [];
        foreach ($this->attributes() as $value) {
            if (property_exists($this, $value)) {
                $attrs[$value] = $this->$value;
            }
        }

        return $attrs;
    }

    public static function find() {
        return new Query(static::class);
    }

    public function load(array $data) {
        foreach (array_merge($this->attributes(), ['id' => $data['id'] ?? null]) as $attr) {
            if (array_key_exists($attr, $data)) {
                $this->$attr = $data[$attr];
            }
        }

        $this->id = $data['id'] ?? null;

        return true;
    }

    public function getErrors($attr = null) {
        if ($attr) {
            return $this->errors[$attr];
        }

        return $this->errors ?? [];
    }

    public function getFirstError($attr = null) {
        if ($attr) {
            return $this->getErrors($attr)[0];
        }

        $errors = $this->getErrors();
        return reset($errors);
    }

    public function getFirstErrors() {
        $errors = [];
        foreach ($this->getErrors() as $key => $errorContent) {
            $errors[$key] = is_array($errorContent) ? $first = reset($errorContent) : $errorContent;
        }

        return $errors;
    }

    public static function getLabel($name) {
        if (!in_array($name, static::attributes())) {
            return false;
        }

        return isset(static::labels()[$name]) ? ucfirst(static::labels()[$name]) : $name;
    }

    // adds field label, it's for cases when message has to show label
    public static function addFieldLabelsToErrorMessages($errors) {
        if (!empty($errors)) {
            foreach ($errors as $attr => &$error) {
                $error = (static::labels()[$attr] ?? $attr) . ': ' . (is_array($error) ? $error[0] : $error);
            }
        }

        return $errors;
    }

}
