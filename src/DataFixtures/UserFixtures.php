<?php

namespace App\DataFixtures;

use App\Entity\Trainer;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    const PLAINPASSWORD = '123456';

    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher){

    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = \Faker\Factory::create('fr_FR');
        //Création d'un administrateur
        $userAdmin = new User();
        $userAdmin->setFirstName('Admin');
        $userAdmin->setLastName('Admin');
        $userAdmin->setEmail('admin@test.fr');
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $password = $this->userPasswordHasher->hashPassword($userAdmin, '' . self::PLAINPASSWORD . '');
        $userAdmin->setPassword($password);
        $manager->persist($userAdmin);

        //Création d'un planificateur
        $userPlanner = new User();
        $userPlanner->setFirstName('Planner');
        $userPlanner->setLastName('Planner');
        $userPlanner->setEmail('planner@test.fr');
        $userPlanner->setRoles(['ROLE_PLANNER']);
        $password = $this->userPasswordHasher->hashPassword($userPlanner, '' . self::PLAINPASSWORD . '');
        $userPlanner->setPassword($password);
        $manager->persist($userPlanner);

        //Créer 10 utilisateurs classiques
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setEmail("user$i@test.fr");
            $user->setRoles(['ROLE_USER']);
            $password = $this->userPasswordHasher->hashPassword($user, self::PLAINPASSWORD);
            $user->setPassword($password);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
