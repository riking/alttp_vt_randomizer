<?php namespace ALttP\Requirement;

use ALttP\Requirement;
use ALttP\Support\LocationCollection;
use ALttP\Support\ItemCollection;

class RequireNone extends Requirement {
    static $inst;

    public function __construct() {
		parent::__construct(null);
    }

    public function isSatisfied(LocationCollection $locations, ItemCollection $items) {
        return true;
    }

    public function as_json() {
        return true;
    }

    static public function getInst() {
        if (static::$inst) {
            return static::$inst;
        }
        static::$inst = new RequireNone();
        return static::$inst;
    }
}