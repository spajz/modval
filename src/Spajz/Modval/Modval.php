<?php namespace Spajz\Modval;

use Eloquent;
use Validator;

class Modval extends Eloquent
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected static $rules = array();

    /**
     * Message bag.
     *
     * @var Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Validate model on save event.
     *
     * @return bool
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {

            if (!$model->validate()) return false;

        });
    }

    /**
     * Prepare rules array.
     *
     * @return array
     */
    protected function prepareRules()
    {
        $rules = static::$rules;

        if (count($rules) != count($rules, COUNT_RECURSIVE)) {

            $arr = isset($rules['save']) ? $rules['save'] : array();

            if ($this->exists) {

                $rules = array_merge($arr, isset($rules['update']) ? $rules['update'] : array());

            } else {

                $rules = array_merge($arr, isset($rules['create']) ? $rules['create'] : array());

            }
        }

        return $rules;
    }

    /**
     * Validation process.
     *
     * @return bool
     */
    public function validate()
    {
        $rules = $this->prepareRules();

        $validation = Validator::make($this->attributes, $rules);

        if ($validation->passes()) {

            return true;
        }

        $this->setErrors($validation->messages());

        return false;
    }

    /**
     * Set errors.
     *
     * @param  Illuminate\Support\MessageBag
     * @return void
     */
    protected function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Get errors.
     *
     * @return Illuminate\Support\MessageBag
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Has errors.
     *
     * @return bool
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

}
