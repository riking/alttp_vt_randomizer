<?php namespace ALttP\Region;

use ALttP\Item;
use ALttP\Location;
use ALttP\Region;
use ALttP\Support\LocationCollection;
use ALttP\World;

/**
 * Ganons Tower Region and it's Locations contained within
 */
class GanonsTower extends Region {
	protected $name = 'Ganons Tower';
	public $music_addresses = [
		0x155C9,
	];

	protected $region_items = [
		'BigKey',
		'BigKeyA2',
		'Compass',
		'CompassA2',
		'Key',
		'KeyA2',
		'Map',
		'MapA2',
	];

	/**
	 * Create a new Ganons Tower Region and initalize it's locations
	 *
	 * @param World $world World this Region is part of
	 *
	 * @return void
	 */
	public function __construct(World $world) {
		parent::__construct($world);

		$this->locations = new LocationCollection([
			new Location\Dash("[dungeon-A2-1F] Ganon's Tower - down left staircase from entrance", 0x180161, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - north of gap room [top left chest]", 0xEAB8, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - north of gap room [top right chest]", 0xEABB, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - north of gap room [bottom left chest]", 0xEABE, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - north of gap room [bottom right chest]", 0xEAC1, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - west of teleport room [top left chest]", 0xEAC4, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - west of teleport room [top right chest]", 0xEAC7, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - west of teleport room [bottom left chest]", 0xEACA, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - west of teleport room [bottom right chest]", 0xEACD, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - north of teleport room", 0xEAD0, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - map room", 0xEAD3, null, $this),
			new Location\BigChest("[dungeon-A2-1F] Ganon's Tower - big chest", 0xEAD6, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - down right staircase from entrance [left chest]", 0xEAD9, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - down right staircase from entrance [right chest]", 0xEADC, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - above Armos", 0xEADF, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - east of down right staircase from entrance", 0xEAE2, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - compass room [top left chest]", 0xEAE5, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - compass room [top right chest]", 0xEAE8, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - compass room [bottom left chest]", 0xEAEB, null, $this),
			new Location\Chest("[dungeon-A2-1F] Ganon's Tower - compass room [bottom right chest]", 0xEAEE, null, $this),
			new Location\Chest("[dungeon-A2-B1] Ganon's Tower - north of Armos room [bottom chest]", 0xEAF1, null, $this),
			new Location\Chest("[dungeon-A2-B1] Ganon's Tower - north of Armos room [left chest]", 0xEAF4, null, $this),
			new Location\Chest("[dungeon-A2-B1] Ganon's Tower - north of Armos room [right chest]", 0xEAF7, null, $this),
			new Location\Chest("[dungeon-A2-6F] Ganon's Tower - north of falling floor four torches [top left chest]", 0xEAFD, null, $this),
			new Location\Chest("[dungeon-A2-6F] Ganon's Tower - north of falling floor four torches [top right chest]", 0xEB00, null, $this),
			new Location\Chest("[dungeon-A2-6F] Ganon's Tower - before Moldorm", 0xEB03, null, $this),
			new Location\Chest("[dungeon-A2-6F] Ganon's Tower - Moldorm room", 0xEB06, null, $this),
			new Location\Prize\Event("Agahnim 2", null, null, $this),
		]);

		$this->prize_location = $this->locations["Agahnim 2"];
		$this->prize_location->setItem(Item::get('DefeatAgahnim2'));
	}

	/**
	 * Set Locations to have Items like the vanilla game.
	 *
	 * @return $this
	 */
	public function setVanilla() {
		$this->locations["[dungeon-A2-1F] Ganon's Tower - down left staircase from entrance"]->setItem(Item::get('KeyA2'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - north of gap room [top left chest]"]->setItem(Item::get('ThreeBombs'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - north of gap room [top right chest]"]->setItem(Item::get('TenArrows'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - north of gap room [bottom left chest]"]->setItem(Item::get('TwentyRupees'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - north of gap room [bottom right chest]"]->setItem(Item::get('TwentyRupees'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - west of teleport room [top left chest]"]->setItem(Item::get('TenArrows'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - west of teleport room [top right chest]"]->setItem(Item::get('TenArrows'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - west of teleport room [bottom left chest]"]->setItem(Item::get('ThreeBombs'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - west of teleport room [bottom right chest]"]->setItem(Item::get('ThreeBombs'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - north of teleport room"]->setItem(Item::get('KeyA2'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - map room"]->setItem(Item::get('MapA2'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - big chest"]->setItem(Item::get('RedMail'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - down right staircase from entrance [left chest]"]->setItem(Item::get('TenArrows'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - down right staircase from entrance [right chest]"]->setItem(Item::get('ThreeBombs'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - above Armos"]->setItem(Item::get('TenArrows'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - east of down right staircase from entrance"]->setItem(Item::get('KeyA2'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - compass room [top left chest]"]->setItem(Item::get('Compass'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - compass room [top right chest]"]->setItem(Item::get('OneRupee'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - compass room [bottom left chest]"]->setItem(Item::get('TwentyRupees'));
		$this->locations["[dungeon-A2-1F] Ganon's Tower - compass room [bottom right chest]"]->setItem(Item::get('TenArrows'));
		$this->locations["[dungeon-A2-B1] Ganon's Tower - north of Armos room [bottom chest]"]->setItem(Item::get('BigKeyA2'));
		$this->locations["[dungeon-A2-B1] Ganon's Tower - north of Armos room [left chest]"]->setItem(Item::get('TenArrows'));
		$this->locations["[dungeon-A2-B1] Ganon's Tower - north of Armos room [right chest]"]->setItem(Item::get('ThreeBombs'));
		$this->locations["[dungeon-A2-6F] Ganon's Tower - north of falling floor four torches [top left chest]"]->setItem(Item::get('ThreeBombs'));
		$this->locations["[dungeon-A2-6F] Ganon's Tower - north of falling floor four torches [top right chest]"]->setItem(Item::get('ThreeBombs'));
		$this->locations["[dungeon-A2-6F] Ganon's Tower - before Moldorm"]->setItem(Item::get('KeyA2'));
		$this->locations["[dungeon-A2-6F] Ganon's Tower - Moldorm room"]->setItem(Item::get('TwentyRupees'));

		return $this;
	}

	private function iceBigKeyRandoRoom($items, $excludeLocation) {
		return new Requirement\RequireAll([
			$items,
			new Requirement\RequireAny([
				new Requirement\RequireAll([
					new Requirement\RequireCount('KeyA2', 3),
					// XXX Was this supposed to be the Ice Palace Big Key?
					new Requirement\RequireItemLocation('BigKeyD5', array_filter([
						"[dungeon-A2-1F] Ganon's Tower - west of teleport room [top right chest]",
						"[dungeon-A2-1F] Ganon's Tower - west of teleport room [top left chest]",
						"[dungeon-A2-1F] Ganon's Tower - west of teleport room [bottom left chest]",
						"[dungeon-A2-1F] Ganon's Tower - west of teleport room [bottom right chest]",
					], function($_, $loc) {
						return $loc !== $excludeLocation;
					}, ARRAY_FILTER_USE_BOTH))
				]),
				new Requirement\RequireCount('KeyA2', 4),
			])
		]);
	}

	private function iceBigKeyCompassRoom($items, $excludeLocation) {
		return new Requirement\RequireAll([
			$items,
			new Requirement\RequireAny([
				new Requirement\RequireAll([
					new Requirement\RequireCount('KeyA2', 3),
					// XXX Was this supposed to be the Ice Palace Big Key?
					new Requirement\RequireItemLocation('BigKeyD5', array_filter([
						"[dungeon-A2-1F] Ganon's Tower - compass room [top right chest]",
						"[dungeon-A2-1F] Ganon's Tower - compass room [top left chest]",
						"[dungeon-A2-1F] Ganon's Tower - compass room [bottom left chest]",
						"[dungeon-A2-1F] Ganon's Tower - compass room [bottom right chest]",
					], function($_, $loc) {
						return $loc !== $excludeLocation;
					}, ARRAY_FILTER_USE_BOTH))
				]),
				new Requirement\RequireCount('KeyA2', 4),
			])
		]);
	}

	/**
	 * Initalize the requirements for Entry and Completetion of the Region as well as access to all Locations contained
	 * within for No Major Glitches
	 *
	 * @return $this
	 */
	public function initNoMajorGlitches() {
		$this->can_enter = new Requirement\RequireAll([
			'MoonPearl',
			'Crystal1',
			'Crystal2',
			'Crystal3',
			'Crystal4',
			'Crystal5',
			'Crystal6',
			'Crystal7',
			$this->world->getRegion('East Dark World Death Mountain')->getEntryRequirements(),
		]);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - down left staircase from entrance"]->setRequirements(
			new Requirement('PegasusBoots')
		);

		$hammerAndHookshot = new Requirement\RequireAll(['Hammer', 'Hookshot']);
		$fireAndCane = new Requirement\RequireAll(['FireRod', 'CaneOfSomaria']);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - north of gap room [top left chest]"]->setRequirements($hammerAndHookshot);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - north of gap room [top right chest]"]->setRequirements($hammerAndHookshot);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - north of gap room [bottom left chest]"]->setRequirements($hammerAndHookshot);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - north of gap room [bottom right chest]"]->setRequirements($hammerAndHookshot);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - west of teleport room [top left chest]"]->setRequirements(
			$this->iceBigKeyRandoRoom($hammerAndHookshot, "[dungeon-A2-1F] Ganon's Tower - west of teleport room [top left chest]")
		);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - west of teleport room [top right chest]"]->setRequirements(
			$this->iceBigKeyRandoRoom($hammerAndHookshot, "[dungeon-A2-1F] Ganon's Tower - west of teleport room [top right chest]")
		);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - west of teleport room [bottom left chest]"]->setRequirements(
			$this->iceBigKeyRandoRoom($hammerAndHookshot, "[dungeon-A2-1F] Ganon's Tower - west of teleport room [bottom left chest]")
		);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - west of teleport room [bottom right chest]"]->setRequirements(
			$this->iceBigKeyRandoRoom($hammerAndHookshot, "[dungeon-A2-1F] Ganon's Tower - west of teleport room [bottom right chest]")
		);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - north of teleport room"]->setRequirements(
			new Requirement\RequireAll([
				$hammerAndHookshot,
				new Requirement\RequireAny([
					new Requirement\RequireAll([
						new Requirement\RequireCount('KeyA2', 2),
						// XXX Was this supposed to be the Ice Palace Big Key?
						new Requirement\RequireItemLocation('BigKeyD5', [
							"[dungeon-A2-1F] Ganon's Tower - west of teleport room [top right chest]",
							"[dungeon-A2-1F] Ganon's Tower - west of teleport room [top left chest]",
							"[dungeon-A2-1F] Ganon's Tower - west of teleport room [bottom left chest]",
							"[dungeon-A2-1F] Ganon's Tower - west of teleport room [bottom right chest]",
						]),
					]),
					new Requirement\RequireCount('KeyA2', 3),
				])
			])
		);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - map room"]->setRequirements(
			new Requirement\RequireAll([
				'Hammer',
				new Requirement\RequireAny([
					'PegasusBoots', 'Hookshot'
				]),
				new Requirement\RequireCount('KeyA2', 3),
			])
		);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - big chest"]->setRequirements(
			new Requirement\RequireAll([
				'BigKeyA2',
				new Requirement\RequireCount('KeyA2', 3),
				new Requirement\RequireAny([
					$hammerAndHookshot,
					$fireAndCane,
				])
			])
		)->setFillRules(function($item, $locations, $items) {
			return $item != Item::get('BigKeyA2');
		});

		$threeKeysAndEitherSide = new Requirement\RequireAll([
			new Requirement\RequireCount('KeyA2', 3),
			new Requirement\RequireAny([
				$hammerAndHookshot,
				$fireAndCane,
			])
		]);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - above Armos"]->setRequirements(
			$threeKeysAndEitherSide
		);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - east of down right staircase from entrance"]->setRequirements(
			new Requirement('CaneOfSomaria')
		);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - compass room [top left chest]"]->setRequirements(
			$this->iceBigKeyCompassRoom($fireAndCane, "[dungeon-A2-1F] Ganon's Tower - compass room [top left chest]")
		);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - compass room [top right chest]"]->setRequirements(
			$this->iceBigKeyCompassRoom($fireAndCane, "[dungeon-A2-1F] Ganon's Tower - compass room [top right chest]")
		);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - compass room [bottom left chest]"]->setRequirements(
			$this->iceBigKeyCompassRoom($fireAndCane, "[dungeon-A2-1F] Ganon's Tower - compass room [bottom left chest]")
		);

		$this->locations["[dungeon-A2-1F] Ganon's Tower - compass room [bottom right chest]"]->setRequirements(
			$this->iceBigKeyCompassRoom($fireAndCane, "[dungeon-A2-1F] Ganon's Tower - compass room [bottom right chest]")
		);

		$this->locations["[dungeon-A2-B1] Ganon's Tower - north of Armos room [bottom chest]"]->setRequirements(
			$threeKeysAndEitherSide
		);

		$this->locations["[dungeon-A2-B1] Ganon's Tower - north of Armos room [left chest]"]->setRequirements(
			$threeKeysAndEitherSide
		);

		$this->locations["[dungeon-A2-B1] Ganon's Tower - north of Armos room [right chest]"]->setRequirements(
			$threeKeysAndEitherSide
		);

		$arrowsTorchesGTBigAndThreeKeys = new Requirement\RequireAll([
			Requirement::get('canShootArrows'),
			Requirement::get('canLightTorches'),
			'BigKeyA2',
			new Requirement\RequireCount('KeyA2', 3),
		]);

		$this->locations["[dungeon-A2-6F] Ganon's Tower - north of falling floor four torches [top left chest]"]->setRequirements(
			$arrowsTorchesGTBigAndThreeKeys
		)->setFillRules(function($item, $locations, $items) {
			return $item != Item::get('BigKeyA2');
		});

		$this->locations["[dungeon-A2-6F] Ganon's Tower - north of falling floor four torches [top right chest]"]->setRequirements(
			$arrowsTorchesGTBigAndThreeKeys
		)->setFillRules(function($item, $locations, $items) {
			return $item != Item::get('BigKeyA2');
		});

		$this->locations["[dungeon-A2-6F] Ganon's Tower - before Moldorm"]->setRequirements(
			$arrowsTorchesGTBigAndThreeKeys
		)->setFillRules(function($item, $locations, $items) {
			return $item != Item::get('BigKeyA2');
		});

		$moldormRoom = new Requirement\RequireAll([
			'Hookshot',
			Requirement::get('canShootArrows'),
			Requirement::get('canLightTorches'),
			'BigKeyA2',
			new Requirement\RequireCount('KeyA2', 4),
		]);

		$this->locations["[dungeon-A2-6F] Ganon's Tower - Moldorm room"]->setRequirements(
			$moldormRoom
		)->setFillRules(function($item, $locations, $items) {
			return $item != Item::get('KeyA2') && $item != Item::get('BigKeyA2');
		});

		$this->can_complete = new Requirement\RequireAll([
			$this->can_enter,
			$moldormRoom,
			new Requirement\RequireAny([
				Requirement::get('hasSword'),
				'BugCatchingNet',
				'Hammer',
			]),
		]);

		$this->prize_location->setRequirements($this->can_complete);

		return $this;
	}

	/**
	 * Initalize the requirements for Entry and Completetion of the Region as well as access to all Locations contained
	 * within for MajorGlitches Mode.
	 *
	 * @return $this
	 */
	public function initMajorGlitches() {
		$this->initNoMajorGlitches();

		$this->can_enter = function($locations, $items) {
			return $this->world->getRegion('West Death Mountain')->canEnter($locations, $items);
		};

		return $this;
	}

	/**
	 * Initalize the requirements for Entry and Completetion of the Region as well as access to all Locations contained
	 * within for Overworld Glitches Mode
	 *
	 * @return $this
	 */
	public function initOverworldGlitches() {
		$this->initNoMajorGlitches();

		$this->can_enter = function($locations, $items) {
			return $items->has('PegasusBoots') && $items->has('MoonPearl');
		};

		return $this;
	}
}
