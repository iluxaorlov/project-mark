<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedController extends AbstractController
{
    /**
     * @Route("/", name="feed")
     * @IsGranted("ROLE_USER")
     *
     * @param PostRepository $postRepository
     *
     * @return Response
     */
    public function feed(PostRepository $postRepository)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $posts = $postRepository->findAll();

        return $this->render('feed/feed.html.twig', [
            'posts' => $posts,
        ]);
    }
}
