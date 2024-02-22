<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Editor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $authors=[];
        for ($i = 0; $i < 10; $i++) {
            $authors[$i] = new Author();
            $authors[$i]->setName($faker->name());
            $authors[$i]->setAge($faker->numberBetween(18,80));


            $manager->persist($authors[$i]);
        }
        $editors=[];
        for ($i = 0; $i < 10; $i++) {
            $editors[$i] = new Editor();
            $editors[$i]->setName($faker->company());
            $editors[$i]->setAdress($faker->address());


            $manager->persist($editors[$i]);
        }
        for ($i = 0; $i < 10; $i++) {
            $book = new Book();
            $book->setIsbn($faker->isbn13());
            $book->setTitre($faker->words(3,true));
            $book->setResumer($faker->sentence());
            $book->setDescription($faker->sentences(2,true));
            $book->setPrix($faker->randomFloat(2,1,9999));
            $book->setEditor($editors[array_rand($editors)]);
            $book->setAuthor($authors[array_rand($authors)]);


            $manager->persist($book);
        }

        $manager->flush();
    }
}
