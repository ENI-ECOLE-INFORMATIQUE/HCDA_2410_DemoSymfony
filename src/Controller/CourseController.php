<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/cours', name: 'app_cours_')]
final class CourseController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(CourseRepository $courseRepository): Response
    {
        //Ici pas la meilleure pratique car on utilise le repository au lieu d'utiliser un Service.


        //$courses = $courseRepository -> findAll();
        //$courses = $courseRepository -> findBy([], ['name' => 'DESC'],5);
       // $courses = $courseRepository -> findBy([], ['name' => 'DESC']);
        $courses = $courseRepository -> findLastCourses();
        return $this->render('course/list.html.twig',[
            'courses' => $courses
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'],requirements: ['id'=>'\d+'])]
    public function show(int $id,CourseRepository $courseRepository): Response
    {
        //TODO: Rechercher le cours dans la BDD en fonction de son ID.
        $course = $courseRepository->find($id);
        if(!$course){
            throw $this->createNotFoundException('cours introuvable');
        }
        return $this->render('course/show.html.twig',
            ['course'=>$course]);
    }

    #[Route('/ajouter', name: 'create', methods: ['GET','POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        //dump($request);
        $course = new Course();
        $courseForm = $this->createForm(CourseType::class, $course);
        $courseForm->handleRequest($request);
        if($courseForm->isSubmitted() && $courseForm->isValid()){
            $em->persist($course);
            $em->flush();

            $this->addFlash('success','Le cours a été ajouté');
            return $this->redirectToRoute('app_cours_show', ['id'=>$course->getId()]);
        }
        return $this->render('course/create.html.twig',[
            'courseForm' => $courseForm
        ]);
    }

    #[Route('/{id}/modifier', name: 'edit', methods: ['GET','POST'], requirements: ['id'=>'\d+'])]
    public function edit(Course $course,Request $request, EntityManagerInterface $em): Response
    {
        //Ici $course passé en paramètre permet de faire la liaison avec l'id de course.
        //C'est Symfony qui fait le job.

        $courseForm = $this->createForm(CourseType::class, $course);
        $courseForm->handleRequest($request);
        if($courseForm->isSubmitted() && $courseForm->isValid()){
            //Pas besoin de persist car l'objet est déjà associé.
            $course->setDateModified(new \DateTimeImmutable());
            $em->flush();
            $this->addFlash('success','Le cours a été modifié');
            return $this->redirectToRoute('app_cours_show', ['id'=>$course->getId()]);
        }
        return $this->render('course/edit.html.twig',['courseForm'=>$courseForm]);
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
