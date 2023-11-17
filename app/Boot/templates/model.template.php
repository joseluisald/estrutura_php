<?php

namespace App\Models\{{theme}};

use \CoffeeCode\DataLayer\DataLayer;

/**
 * class {{name}}Model
 */
class {{name}}Model extends DataLayer
{
    /**
     * {{name}}Model constructor.
     */
    public function __construct()
    {
        //string "TABLE_NAME", array ["REQUIRED_FIELD_1", "REQUIRED_FIELD_2"], string "PRIMARY_KEY", bool "TIMESTAMPS"
        parent::__construct("{{table}}", ["", ""]);
    }

    /**
     * @return {{name}}Model|array|null
     */
    public function getAll()
    {
        return $this->find()->fetch();
    }
}