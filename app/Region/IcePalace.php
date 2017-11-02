<?php namespace ALttP\Region;

use ALttP\Item;
use ALttP\Location;
use ALttP\Region;
use ALttP\Requirement;
use ALttP\Support\LocationCollection;
use ALttP\World;

/**
 * Ice Palace Region and it's Locations contained within
 */
class IcePalace extends Region {
	protected $name = 'Ice Palace';
	public $music_addresses = [
		0x155BF,
	];

	protected $region_items = [
		'BigKey',
		'BigKeyD5',
		'Compass',
		'CompassD5',
		'Key',
		'KeyD5',
		'Map',
		'MapD5',
	];

	/**
	 * Create a new Ice Palace Region and initalize it's locations
	 *
	 * @param World $world World this Region is part of
	 *
	 * @return void
	 */
	public function __construct(World $world) {
		parent::__construct($world);

		$this->locations = new LocationCollection([
			new Location\Chest("[dungeon-D5-B1] Ice Palace - Big Key room", 0xE9A4, null, $this),
			new Location\Chest("[dungeon-D5-B1] Ice Palace - compass room", 0xE9D4, null, $this),
			new Location\Chest("[dungeon-D5-B2] Ice Palace - map room", 0xE9DD, null, $this),
			new Location\Chest("[dungeon-D5-B3] Ice Palace - spike room", 0xE9E0, null, $this),
			new Location\Chest("[dungeon-D5-B4] Ice Palace - above Blue Mail room", 0xE995, null, $this),
			new Location\Chest("[dungeon-D5-B5] Ice Palace - b5 up staircase", 0xE9E3, null, $this),
			new Location\BigChest("[dungeon-D5-B5] Ice Palace - big chest", 0xE9AA, null, $this),
			new Location\Drop("Heart Container - Kholdstare", 0x180157, null, $this),

			new Location\Prize\Crystal("Ice Palace Crystal", [null, 0x120A4, 0x53F5A, 0x53F5B, 0x180059, 0x180073, 0xC705], null, $this),
		]);

		$this->prize_location = $this->locations["Ice Palace Crystal"];
	}

	/**
	 * Set Locations to have Items like the vanilla game.
	 *
	 * @return $this
	 */
	public function setVanilla() {
		$this->locations["[dungeon-D5-B1] Ice Palace - Big Key room"]->setItem(Item::get('BigKeyD5'));
		$this->locations["[dungeon-D5-B1] Ice Palace - compass room"]->setItem(Item::get('CompassD5'));
		$this->locations["[dungeon-D5-B2] Ice Palace - map room"]->setItem(Item::get('MapD5'));
		$this->locations["[dungeon-D5-B3] Ice Palace - spike room"]->setItem(Item::get('KeyD5'));
		$this->locations["[dungeon-D5-B4] Ice Palace - above Blue Mail room"]->setItem(Item::get('ThreeBombs'));
		$this->locations["[dungeon-D5-B5] Ice Palace - b5 up staircase"]->setItem(Item::get('KeyD5'));
		$this->locations["[dungeon-D5-B5] Ice Palace - big chest"]->setItem(Item::get('BlueMail'));
		$this->locations["Heart Container - Kholdstare"]->setItem(Item::get('BossHeartContainer'));

		$this->locations["Ice Palace Crystal"]->setItem(Item::get('Crystal5'));

		return $this;
	}

	private function bigKeyLocation($locations) {
		return new Requirement\RequireAny([
			'Hookshot',
			new Requirement\RequireAll([
				'KeyD5',
				new Requirement\RequireItemLocation('BigKeyD5', $locations),
			]),
			new Requirement\RequireCount('KeyD5', 2),
		]);
	}

	/**
	 * Initalize the requirements for Entry and Completetion of the Region as well as access to all Locations contained
	 * within for No Major Glitches
	 *
	 * @return $this
	 */
	public function initNoMajorGlitches() {
		$this->locations["[dungeon-D5-B1] Ice Palace - Big Key room"]->setRequirements(
			new Requirement\RequireAll([
				'Hammer',
				Requirement::get('canLiftRocks'),
				$this->bigKeyLocation([
					"[dungeon-D5-B2] Ice Palace - map room",
					"[dungeon-D5-B3] Ice Palace - spike room",
				]),
				new Requirement\RequireAny(['Hookshot', 'CaneOfByrna', 'Cape']),
			])
		);

		$this->locations["[dungeon-D5-B2] Ice Palace - map room"]->setRequirements(
			new Requirement\RequireAll([
				'Hammer',
				Requirement::get('canLiftRocks'),
				$this->bigKeyLocation([
					"[dungeon-D5-B3] Ice Palace - spike room",
					"[dungeon-D5-B1] Ice Palace - Big Key room",
				]),
				new Requirement\RequireAny(['Hookshot', 'CaneOfByrna', 'Cape']),
			])
		);

		$this->locations["[dungeon-D5-B3] Ice Palace - spike room"]->setRequirements(
			new Requirement\RequireAll([
				/* does NOT require Hammer and lifting rocks */
				$this->bigKeyLocation([
					"[dungeon-D5-B1] Ice Palace - Big Key room",
					"[dungeon-D5-B2] Ice Palace - map room",
				]),
				new Requirement\RequireAny(['Hookshot', 'CaneOfByrna', 'Cape']),
			])
		);

		$this->locations["[dungeon-D5-B4] Ice Palace - above Blue Mail room"]->setRequirements(
			Requirement::get('canMeltThings')
		);

		$this->locations["[dungeon-D5-B5] Ice Palace - big chest"]->setRequirements(
			new Requirement('BigKeyD5')
		)->setFillRules(function($item, $locations, $items) {
			return $item != Item::get('BigKeyD5');
		});

		$this->can_complete = new Requirement\RequireAll([
			&$this->can_enter, // reference
			'Hammer',
			Requirement::get('canMeltThings'),
			Requirement::get('canLiftRocks'),
			'BigKeyD5',
			new Requirement\RequireAny([
				new Requirement\RequireAll([
					'CaneOfSomaria', 'KeyD5'
				]),
				new Requirement\RequireCount('KeyD5', 2),
			]),
		]);

		$this->locations["Heart Container - Kholdstare"]->setRequirements($this->can_complete)
			->setFillRules(function($item, $locations, $items) {
				if (!$this->world->config('region.bossNormalLocation', true)
					&& (is_a($item, Item\Key::class) || is_a($item, Item\BigKey::class)
						|| is_a($item, Item\Map::class) || is_a($item, Item\Compass::class))) {
					return false;
				}

				if ($this->world->config('region.bossHaveKey', true)) {
					return $item != Item::get('BigKeyD5');
				}

				return !in_array($item, [Item::get('KeyD5'), Item::get('BigKeyD5')]);
			});


		$this->can_enter = new Requirement\RequireAll([
			'MoonPearl', 'Flippers',
			Requirement::get('canLiftDarkRocks'),
			Requirement::get('canMeltThings'),
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

		$this->can_enter = new Requirement\RequireAny([
			Requirement::get('canLiftDarkRocks'),
			new Requirement\RequireAll([
				'MagicMirror',
				Requirement::get('glitchedLinkInDarkWorld'),
				$this->world->getRegion('South Dark World')->getEntryRequirements(),
			])
		]);

		$this->prize_location->setRequirements($this->can_complete);

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

		$this->can_enter = new Requirement\RequireAll([
			Requirement::get('canLiftDarkRocks'),
			Requirement::get('canMeltThings'),
		]);

		return $this;
	}
}
