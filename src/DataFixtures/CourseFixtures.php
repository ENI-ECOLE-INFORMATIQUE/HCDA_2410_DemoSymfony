<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Course;
use App\Entity\Trainer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CourseFixtures extends Fixture implements DependentFixtureInterface
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
            $course->setCategory($this->getReference('category'.mt_rand(1,2),Category::class));
            $course->addTrainer($this->getReference('trainer'.mt_rand(1,20),Trainer::class));
            $manager->persist($course);

        }


        $manager->flush();
    }

    public function getDependencies(): array{
        return [CategoryFixtures::class, TrainerFixtures::class];
    }
}
