<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SkillFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /*
        for ($i = 1; $i < 100; $i++) {
            $skill = new Skill('Classe' . $i, 'description' . $i);
            $manager->persist($skill);
        }

        $manager->flush();*/
    }
}
