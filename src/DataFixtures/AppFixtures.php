<?php

namespace App\DataFixtures;

use App\Entity\Course;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = \Faker\Factory::create('fr_FR');

        //Creation de 30 cours
        for ($i = 0; $i < 30; $i++) {
            $course = new Course();

            //hydrater toutes les propriétés de l'entité cours.
            $course->setName('Course ' . $i);
            //$course->setContent('Description ' . $i);
            $course->setContent( $faker->realText());
            $course->setDuration(mt_rand(1,10));
            $dateCreated = $faker->dateTimeBetween('-2 months','now');
            $course->setDateCreated(\DateTimeImmutable::createFromMutable($dateCreated));
            $dateCreated = $faker->dateTimeBetween($course->getDateCreated()->format('Y-m-d'),'now');
            $course->setDateModified(\DateTimeImmutable::createFromMutable($dateCreated));
            $course->setPublished(false);
            $manager->persist($course);

        }

        $manager->flush();
    }
}
