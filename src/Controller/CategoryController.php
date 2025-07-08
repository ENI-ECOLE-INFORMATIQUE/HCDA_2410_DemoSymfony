<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/category', name: 'app_category_')]
final class CategoryController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(): Response
    {
        return $this->render('category/list.html.twig', [
        ]);
    }

    #[Route('/{id}/supprimer', name: 'delete', methods: ['GET'],requirements: ['id'=>'\d+'] )]
    public function delete(Category $category, Request $request, EntityManagerInterface $em): Response
    {
        try{
            //1er solution pour pouvoir supprimer la catégorie
           /* if(count($category->getCourses())>0){
                //Si la catégorie possède des cours, on les supprime
                foreach ($category->getCourses() as $course){
                    $category->removeCourse($course);
                }
            }*/
            $em->remove($category);
            $em->flush();
            $this->addFlash('success','La catégorie a été supprimée');
        }catch(\Exception $e){
            $this->addFlash('danger','La catégorie n\'a pu être supprimée<br>'.$e->getMessage());
        }
        return $this->redirectToRoute('app_category_list');
    }
}
