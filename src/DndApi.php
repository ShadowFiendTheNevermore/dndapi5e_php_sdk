<?php
namespace ShadowFiend;

use GuzzleHttp\Client;
use ShadowFiend\Exceptions\BadCallException;

class DndApi
{
    /**
     * @var GuzzleHttp\Client
     */
    protected $http;

    /**
     * Entity map for classes of API
     * 
     * @var Array
     */
    protected const ENTITIES = [
        'ability_scores' => \ShadowFiend\Entities\CharacterData\AbilityScore::class,
        'languages' => \ShadowFiend\Entities\CharacterData\Language::class,
        'proficiencies' => \ShadowFiend\Entities\CharacterData\Proficiency::class,
        'skills' => \ShadowFiend\Entities\CharacterData\Skill::class,
        'classes' => \ShadowFiend\Entities\Classes\DndClass::class,
        'subclasses' => \ShadowFiend\Entities\Classes\DndSubClass::class,
        'features' => \ShadowFiend\Entities\Classes\Feature::class,
        'races' => \ShadowFiend\Entities\Races\Race::class,
        'subraces' => \ShadowFiend\Entities\Races\Subrace::class,
        'equipment' => \ShadowFiend\Entities\Equipment\Equipment::class,
        'equipment_category' => \ShadowFiend\Entities\Equipment\EquipmentCategory::class,
        'spells' => \ShadowFiend\Entities\Spells\Spell::class,
        'monsters' => \ShadowFiend\Entities\Monsters\Monster::class,
        'bestiary' => \ShadowFiend\Entities\Monsters\Monster::class,
    ];

    protected const BASE_URI = 'http://www.dnd5eapi.co/api/';

    // TODO: add configuration for http client
    public function __construct()
    {
        $this->http = new Client([
            'base_uri' => static::BASE_URI
        ]);
    }

    public function __get($class)
    {
        if (isset($class) && array_key_exists($class, static::ENTITIES)) {
            $entity = static::ENTITIES[$class];
            return new $entity($this->http, $class);
        }

        throw new BadCallException("Call undefined method or index of API");
    }
}
