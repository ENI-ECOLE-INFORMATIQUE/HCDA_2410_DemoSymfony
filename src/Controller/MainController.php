<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function list(): Response
    {
        return $this->render('main/list.html.twig', [

        ]);
    }

    #[Route('/test', name: 'app_main_test')]
    public function test(): Response
    {
        $serie=[
            "title"=>"<h1>Games of Thrones</h1>",
            "year"=>2000,
            "monScript"=>"<script>alert('hello');</script>",
        ];
        return $this->render('main/test.html.twig', [
            'mySerie'=>$serie,
            "autreVar"=>414242
        ]);
    }
}
