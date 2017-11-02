<?php namespace ALttP\Requirement;

use ALttP\Requirement;
use ALttP\Support\LocationCollection;
use ALttP\Support\ItemCollection;

class RequireLegacyFunc extends Requirement {
    public function __construct(Callable $callback) {
		parent::__construct($callback);
    }

    public function isSatisfied(LocationCollection $locations, ItemCollection $items) {
        return call_user_func($this->required, $locations, $items);
    }

    public function as_json() {
        return array(
            "op" => "legacy_func",
        );
    }
}
