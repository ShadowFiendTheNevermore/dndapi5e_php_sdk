<?php
namespace ShadowFiend\Entities\Monsters;

use ShadowFiend\Entities\DndEntity;

class Monster extends DndEntity
{
    protected $endpoint = 'monsters';

    protected const STATS = ['charisma', 'wisdom', 'intellegience', 'strength', 'dexterity', 'constitution'];

    /**
     * Get only stats of creature
     */
    public function stats()
    {
        return array_intersect_key($this->data, array_flip(static::STATS));
    }

    public function actions()
    {
        return [
            'actions' => $this->data['actions'],
            'legendary_actions' => $this->data['legendary_actions'],
        ];
    }

    public function proficiencies()
    {
        $proficiencies = $this->data['proficiencies'];

        foreach ($proficiencies as $key => $proficiency) {
            $proficiencies[$key]['skill'] = trim(explode(':', $proficiency['name'])[1]);
        }

        return $proficiencies;
    }

    public function getStatList()
    {
        return static::STATS;
    }
}

