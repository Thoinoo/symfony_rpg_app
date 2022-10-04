<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $skill1 = new Skill('Patate de forain','ça renvoi d\'ou on vient');
        $skill2 = new Skill('Brasier','le feu ça brûle');
        $skill3 = new Skill('Roublardise','C\'est pour les rats');

        $classe1 = new Type('Mage','Ils font de la lumière quoi');
        $classe2 = new Type('Guerrier','Ils font du bruit quand ils mangent et tapent fort');
        $classe3 = new Type('Soigneur','Personne de veut être healer');

        $manager->persist($skill1);
        $manager->persist($skill2);
        $manager->persist($skill3);
        $manager->persist($classe1);
        $manager->persist($classe2);
        $manager->persist($classe3);
        $manager->flush();
    }
}
