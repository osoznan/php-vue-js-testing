<?php

namespace app\site\components;

use app\site\models\Acquire;

/**
 * Class Storage
 * Base class for all storages
 * Derived classes must define its own save function and that's enough
 * @package app\site\components
 */
abstract class Storage {

    /** @var Acquire */
    protected $model;

    public function __construct(Acquire $model) {
        $this->model = $model;
    }

    /**
     * Wrapper for getting attrs
     */
    public function getAttributes() {
        return $this->model->getAttributes();
    }

    /**
     * Wrapper for validation
     */
    public function validate() {
        return $this->model->validate();
    }

    /**
     * The first errors to output if validation fails (wrapper)
     */
    public function getFirstErrors() {
        return $this->model->getFirstErrors();
    }

    /**
     * The central point, where data is being saved
     * @return boolean
     */
    abstract public function save();

}
