<?php namespace ALttP\Region;

use ALttP\Item;
use ALttP\Location;
use ALttP\Region;
use ALttP\Requirement;
use ALttP\Support\LocationCollection;
use ALttP\World;

/**
 * Hyrule Castle Tower Region and it's Locations contained within
 */
class HyruleCastleTower extends Region {
	protected $name = 'Castle Tower';

	protected $region_items = [
		'BigKey',
		'BigKeyH1',
		'Compass',
		'CompassH1',
		'Key',
		'KeyH1',
		'Map',
		'MapH1',
	];

	/**
	 * Create a new Hyrule Castle Tower Region and initalize it's locations
	 *
	 * @param World $world World this Region is part of
	 *
	 * @return void
	 */
	public function __construct(World $world) {
		parent::__construct($world);

		$this->locations = new LocationCollection([
			new Location\Chest("[dungeon-A1-2F] Hyrule Castle Tower - 2 knife guys room", 0xEAB5, null, $this),
			new Location\Chest("[dungeon-A1-3F] Hyrule Castle Tower - maze room", 0xEAB2, null, $this),
			new Location\Prize\Event("Agahnim", null, null, $this),
		]);

		$this->locations["[dungeon-A1-2F] Hyrule Castle Tower - 2 knife guys room"]->setItem(Item::get('Key'));
		$this->locations["[dungeon-A1-3F] Hyrule Castle Tower - maze room"]->setItem(Item::get('Key'));

		$this->prize_location = $this->locations["Agahnim"];
		$this->prize_location->setItem(Item::get('DefeatAgahnim'));
	}

	/**
	 * Set Locations to have Items like the vanilla game.
	 *
	 * @return $this
	 */
	public function setVanilla() {
		$this->locations["[dungeon-A1-2F] Hyrule Castle Tower - 2 knife guys room"]->setItem(Item::get('Key'));
		$this->locations["[dungeon-A1-3F] Hyrule Castle Tower - maze room"]->setItem(Item::get('Key'));

		return $this;
	}

	/**
	 * Initalize the requirements for Entry and Completetion of the Region as well as access to all Locations contained
	 * within for No Major Glitches
	 *
	 * @return $this
	 */
	public function initNoMajorGlitches() {
		if (config('game-mode') == 'swordless') {
			$this->can_enter = new Requirement\RequireAll([
				'Lamp',
				new Requirement\RequireAny([
					'Cape',
					Requirement::get('hasUpgradedSword'),
					'Hammer'
				])
			]);
			$this->can_complete = new Requirement\RequireAll([
				$this->can_enter,
				new Requirement\RequireAny([
					'Hammer', Requirement::get('hasSword'), 'BugCatchingNet'
				])
			]);
		} else {
			$this->can_enter = new Requirement\RequireAll([
				'Lamp',
				new Requirement\RequireAny([
					'Cape',
					Requirement::get('hasUpgradedSword')
				])
			]);
			$this->can_complete = new Requirement\RequireAll([
				$this->can_enter,
				Requirement::get('hasSword'),
			]);
		}

		$this->prize_location->setRequirements($this->can_complete);

		return $this;
	}
}
