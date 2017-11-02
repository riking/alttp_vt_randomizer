<?php namespace ALttP\Requirement;

use ALttP\Item;
use ALttP\Requirement;
use ALttP\Support\LocationCollection;
use ALttP\Support\ItemCollection;

class RequireItemLocation extends Requirement {
    /**
     * List of locations the item is allowed to be in
     */
    protected $locations;

    public function __construct(string $item, $locations) {
        parent::__construct($item);
        $this->locations = $locations;
    }

    public function isSatisfied(LocationCollection $locations, ItemCollection $items) {
        return $locations->itemInLocations(Item::get($this->required), $this->locations);
    }

    public function as_json() {
        return array(
            "item" => $this->required,
            "locations" => $this->locations,
        );
    }
}
