<?php

namespace App\Controller;

use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/cours', name: 'app_cours_')]
final class CourseController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(): Response
    {
        return $this->render('course/list.html.twig');
    }

    #[Route('/{id}', name: 'show', methods: ['GET'],requirements: ['id'=>'\d+'])]
    public function show(): Response
    {
        //TODO: Rechercher le cours dans la BDD en fonction de son ID.
        return $this->render('course/show.html.twig');
    }

    #[Route('/ajouter', name: 'create', methods: ['GET','POST'])]
    public function create(Request $request): Response
    {
        dump($request);
        return $this->render('course/create.html.twig');
    }

    #[Route('/{id}/modifier', name: 'edit', methods: ['GET','POST'], requirements: ['id'=>'\d+'])]
    public function edit(): Response
    {
        return $this->render('course/edit.html.twig');
    }
    #[Route('/demo', name: 'demo', methods: ['GET'])]
    public function demo(Request $request,EntityManagerInterface $em): Response{
        //Créer une instance de l'entité Cours
        $course = new Course();
        //hydrater toutes les propriétés de l'entité cours.
        $course->setName('Symfony');
        $course->setContent('Le développement web côté serveur (avec Symfony)');
        $course->setDuration(10);
        $course->setDateCreated(new \DateTimeImmutable());
        $course->setPublished(true);
        $em->persist($course);

        dump($course);
        //Penser à faire le flush sinon l'objet ne sera pas persisté dans la BD.
        $em->flush();
        dump($course);
        $course->setName('PHP Symfony');
        $em->flush();
        dump($course);

        $em->remove($course);
        $em->flush();
        return $this->render('course/create.html.twig');
    }
}
