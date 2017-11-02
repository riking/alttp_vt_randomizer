<?php namespace ALttP;

use ALttP\Requirement;
use ALttP\Support\LocationCollection;

/**
 * A Location is any place an Item can be found in game
 */
class Location {
	protected $name;
	protected $address;
	protected $bytes;
	protected $region;
	protected $requirements;
	protected $fill_callback;
	protected $item = null;

	/**
	 * Create a new Location
	 *
	 * @param string $name Unique name of location
	 * @param array $address Addresses in ROM to write to
	 * @param array|null $bytes data to write back to Item addresses if set
	 * @param Region|null $region Region that this Location belongs to
	 * @param Requirement|null $requirements Requirements to determine if Location is accessable
	 *
	 * @return void
	 */
	public function __construct($name, $address, $bytes = null, Region $region = null, Requrement $requirements = null) {
		$this->name = $name;
		$this->address = (array) $address;
		$this->bytes = (array) $bytes;
		$this->region = $region;
		$this->requirements = $requirements;
	}

	/**
	 * Try to place the given Item in this Location.
	 *
	 * @param Item $item Item we are trying to place
	 * @param ItemCollection $items Items that can be collected
	 *
	 * @return bool
	 */
	public function fill(Item $item, $items) {
		$old_item = $this->item;
		$this->setItem($item);
		if ($this->canFill($item, $items)) {
			return true;
		}

		$this->setItem($old_item);

		return false;
	}

	/**
	 * Test if given Item can be placed in this location without soft locks.
	 *
	 * @param Item $item Item we are testing for placement
	 * @param ItemCollection $items Items that can be collected
	 * @param bool $check_access also test access
	 *
	 * @return bool
	 */
	public function canFill(Item $item, $items, $check_access = true) {
		return $this->region->canFill($item)
			&& (!$this->fill_callback || call_user_func($this->fill_callback, $item, $this->region->getWorld()->getLocations(), $items))
		 	&& (!$check_access || $this->canAccess($items));
	}

	/**
	 * Determine if Link can access this location given his Items collected. Starts by checking if access to the Region
	 * is granted, then checks the spcific location.
	 *
	 * @param ItemCollection $items Items Link can collect
	 *
	 * @return bool
	 */
	public function canAccess($items, $locations = null) {
		$locations = $locations ?? $this->region->getWorld()->getLocations();
		if (!$this->region->canEnter($locations, $items)) {
			return false;
		}

		if ($this->requirements instanceof Requirement) {
			return $this->requirements->isSatisfied($locations, $items);
		} else if ($this->requirements) {
			return call_user_func($this->requirements, $locations, $items);
		} else {
			return true;
		}
	}

	/**
	 * Determine if Link can access this location given his Items collected.
	 * Returns a RequireAll of the region requirements and this specific location.
	 * 
	 * @return Requirement
	 */
	public function getAccessRequirements() {
		if ($this->requirements instanceof Requirement) {
			return new Requirement\RequireAll([
				$this->region->getEntryRequirements(),
				$this->requirements,
			]);
		} else if ($this->requirements) {
			return new Requirement\RequireAll([
				$this->region->getEntryRequirements(),
				new Requirement\RequireLegacyFunc($this->requirements),
			]);
		} else {
			return $this->region->getEntryRequirements();
		}
	}

	/**
	 * Set the requirements callback for this Location.
	 *
	 * An object of type \ALttP\Requrement is preferred.
	 * A passed closure should take 2 arguments, $locations and $items and
	 * return boolean.
	 *
	 * @param mixed $requirements Callable or Requirements to be called when checking if Location is accessible
	 *
	 * @return $this
	 */
	public function setRequirements($requirements) {
		if (!($requirements instanceof Requirement) && !is_callable($requirements)) {
			throw new \Error("setRequirements() must be passed a closure or a Requirement, got ");
		}
		$this->requirements = $requirements;
		return $this;
	}

	/**
	 * Set the rules for filling this location
	 *
	 * @param Callable $callback
	 *
	 * @return $this
	 */
	public function setFillRules(Callable $callback) {
		$this->fill_callback = $callback;

		return $this;
	}

    /**
     * Sets the item for this location.
     *
     * @param Item|null $item Item to be placed at this Location
     *
     * @return $this
     */
	public function setItem(Item $item = null) {
		$this->item = $item;

		return $this;
	}

	/**
	 * Does this Location have (a particular) Item assigned
	 *
	 * @param Item|null $item item to search locations for
	 *
	 * @return bool
	 */
	public function hasItem(Item $item = null) {
		return $item ? $this->item == $item : $this->item !== null;
	}

	/**
	 * Get the Item assigned to this Location, null is nothing is assigned
	 *
	 * @return Item|null
	 */
	public function getItem() {
		return $this->item;
	}

	/**
	 * Write the Item to this Location in ROM. Will set Item if passed in, and only write if there is an Item set.
	 * @TODO: this is side-affecty
	 *
	 * @param Rom $rom ROM we are writing to
	 * @param Item|null $item item we are going to write
	 *
	 * @throws Exception if no item is set for location
	 *
	 * @return $this
	 */
	public function writeItem(Rom $rom, Item $item = null) {
		if ($item) {
			$this->setItem($item);
		}

		if (!$this->item) {
			throw new \Exception('No Item set to be written');
		}

		$item = $this->item;

		if ($item instanceof Item\Key && $this->region->isRegionItem($item)) {
			$item = Item::get('Key');
		}

		if ($item instanceof Item\BigKey && $this->region->isRegionItem($item)) {
			$item = Item::get('BigKey');
		}

		$item_bytes = $item->getBytes();

		foreach ($this->address as $key => $address) {
			if (!isset($item_bytes[$key]) || !isset($address)) continue;
			$rom->write($address, pack('C', $item_bytes[$key]));
		}

		foreach ($item->getAddress() as $key => $address) {
			if (!isset($this->bytes[$key]) || !isset($address)) continue;
			$rom->write($address, pack('C', $this->bytes[$key]));
		}

		return $this;
	}

	/**
	 * Read Item from ROM into this Location.
	 *
	 * @param Rom $rom ROM we are reading from
	 *
	 * @throws Exception if cannot read Item
	 *
	 * @return $this
	 */
	public function readItem(Rom $rom) {
		if (empty($this->address) || !$this->address[0]) {
			throw new \Exception(sprintf("No Address to read: %s", $this->getName()));
		}

		$read_byte = $rom->read($this->address[0]);

		$this->setItem(Item::getWithByte($read_byte));

		return $this;
	}

	/**
	 * Get the name of this Location.
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Get the ROM addres of this Location.
	 *
	 * @return string
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Set the Region of this Location.
	 * @TODO: determine if this has side affects that are extremely negitive.
	 *
	 * @param Region $region new region to assign location to.
	 *
	 * @return $this
	 */
	public function setRegion(Region $region) {
		$this->region = $region;

		return $this;
	}

	/**
	 * Get the Region of this Location.
	 *
	 * @return Region
	 */
	public function getRegion() {
		return $this->region;
	}

	/**
	 * Convert this to string representation
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->name;
	}
}
