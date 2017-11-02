<?php namespace ALttP\Requirement;

use ALttP\Requirement;
use ALttP\Support\LocationCollection;
use ALttP\Support\ItemCollection;

class RequireCount extends Requirement {
    /**
     * How many of the item is required
     */
    protected $count;

    public function __construct($item, int $count) {
        parent::__construct($item);
        $this->count = $count;
    }

    public function isSatisfied(LocationCollection $locations, ItemCollection $items) {
        return $items->has($this->required, $this->count);
    }

    public function as_json() {
        return array(
            "op" => "count",
            "item" => $this->required,
            "count" => $this->count,
        );
    }
}