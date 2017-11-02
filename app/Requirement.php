<?php namespace ALttP;

use ALttP\Requirement\RequireAny;
use ALttP\Requirement\RequireAll;
use ALttP\Requirement\RequireCount;
use ALttP\Support\LocationCollection;
use ALttP\Support\ItemCollection;

/**
 * Represents item requirements for a location.
 */
class Requirement {
    protected $required;

    static protected $known;

    public function __construct($required) {
        $this->required = $required;
    }

    /**
     * Checks this Requirement against the given acquired item list.
     * The base class assumes the requirement is an item string.
     *
     * @param LocationCollection $locations accessible locations
     * @param ItemCollection $items items collected
     * @return bool
     */
    public function isSatisfied(LocationCollection $locations, ItemCollection $items) {
        return $items->has($this->required);
    }

    /**
     * Convert this Requirement tree to JSON for export.
     */
    public function as_json() {
        // assumes $this->required is an item string
        return $this->required;
    }

    /**
     * Get a named Requirement
     */
    static public function get(string $name) {
        $known = static::wellKnown();
        if (isset($known[$name])) {
            return $known[$name];
        }
        return null;
    }

    static public function wellKnown() {
        if (static::$known) {
            return static::$known;
        }

        $known = array();

        $known['hasUpgradedSword'] = new RequireAny([
            'L2Sword', 'MasterSword',
            'L3Sword', 'L4Sword',
            new RequireCount('ProgressiveSword', 2)
        ]);
        $known['hasSword'] = new RequireAny([
            'L1Sword', 'L1SwordAndShield',
            'ProgressiveSword',
            $known['hasUpgradedSword']
        ]);
        $known['hasABottle'] = new RequireAny([
            'BottleWithBee',
            'BottleWithFairy',
            'BottleWithRedPotion',
            'BottleWithGreenPotion',
            'BottleWithBluePotion',
            'Bottle',
            'BottleWithGoldBee',
        ]);

        $known['canLiftRocks'] = new RequireAny([
            'PowerGlove',
            'ProgressiveGlove',
            'TitansMitt'
        ]);
        $known['canLiftDarkRocks'] = new RequireAny([
            'TitansMitt',
            new RequireCount('ProgressiveGlove', 2)
        ]);

        $known['canLightTorches'] = new RequireAny([
            'FireRod', 'Lamp'
        ]);
        $known['canMeltThings'] = new RequireAny([
            'FireRod',
            new RequireAll([
                'Bombos',
                $known['hasSword'],
            ])
        ]);
        $known['canFly'] = new RequireAny([
            'OcarinaActive', 'OcarinaInactive'
        ]);
        $known['canSpinSpeed'] = new RequireAll([
            'PegasusBoots',
            new RequireAny([
                'Hookshot',
                $known['hasSword'],
            ]),
        ]);
        $known['canShootArrows'] = new RequireAny([
            'Bow', 'BowAndArrows', 'BowAndSilverArrows'
        ]);
        $known['canBlockLasers'] = new RequireAny([
            'MirrorShield',
            new RequireCount('ProgressiveShield', 3),
        ]);
        $known['canExtendMagic'] = new RequireAny([
            'HalfMagic',
            'QuarterMagic',
            $known['hasABottle'],
        ]);
        $known['glitchedLinkInDarkWorld'] = new RequireAny([
            'MoonPearl',
            $known['hasABottle'],
        ]);

        static::$known = $known;
        return static::$known;
    }
}
