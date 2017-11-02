<?php namespace ALttP\Requirement;

use ALttP\Requirement;
use ALttP\Support\LocationCollection;
use ALttP\Support\ItemCollection;

class RequireAny extends Requirement {
    public function __construct(array $subitems) {
		parent::__construct($subitems);
    }

    public function isSatisfied(LocationCollection $locations, ItemCollection $items) {
        foreach ($this->required as $requirement) {
            if (is_string($requirement)) {
                if ($items->has($requirement)) {
                    return true;
                }
            } else if ($requirement->isSatisfied($locations, $items)) {
                return true;
            }
        }
        return false;
    }

    public function as_json() {
        $ary = [];
        foreach ($this->required as $requirement) {
            if ($requirement instanceof Requirement) {
                array_push($ary, $requirement->as_json());
            } else {
                array_push($ary, $requirement);
            }
        }
        return array(
            "op" => "any",
            "of" => $ary,
        );
    }
}
