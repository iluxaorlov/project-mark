<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @param PostRepository $postRepository
     * @return Response
     *
     * @Route("/", name="index")
     */
    public function index(PostRepository $postRepository)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $posts = $postRepository->findAll();

        return $this->render('main/index.html.twig', [
            'posts' => $posts
        ]);
    }
}