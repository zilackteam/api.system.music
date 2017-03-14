<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VeoModel extends Model {
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * Get table name from model
     *
     * @return string
     */
    public static function getTableName() {
        // init model and get the table name
        return with(new static)->getTable();
    }

    /**
     * Get Fillable Fields from model
     *
     * @return string
     */
    public static function getFillableFields() {
        // init model and get the table name
        return with(new static)->fillable;
    }

    /**
     * Checks if $rawInputArray is not empty or has less then one element.
     *
     * @param $rawInputArray $rawInputArray
     * @param string $message
     * @throws \InvalidArgumentException
     *
     * @return void in case that array is not empty
     */
    public static function checkInputsNotEmpty($rawInputArray, $message = "") {
        if (!is_array($rawInputArray) or count($rawInputArray) < 1) {
            throw new \InvalidArgumentException($message . ' No Inputs provided');
        }
    }
}
