<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
