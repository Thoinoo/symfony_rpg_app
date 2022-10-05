<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {/*
        for ($i = 1; $i < 100; $i++) {
            $type = new Type('Classe' . $i, 'description' . $i);
            $manager->persist($type);
        }

        $manager->flush();*/
    }
}
