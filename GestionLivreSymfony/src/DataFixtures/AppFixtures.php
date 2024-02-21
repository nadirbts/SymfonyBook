<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        
        for ($i = 0; $i < 10; $i++) {
            $persons = new Author();
            $persons->setName($faker->name());
            $persons->setAge($faker->numberBetween(18,80));


            $manager->persist($persons);
        }

        $manager->flush();
    }
}
