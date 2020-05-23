<?php

namespace App\Controller;

use App\Entity\User;
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
     * @param PostRepository $postRepository
     * @return Response
     */
    public function feed(PostRepository $postRepository)
    {
        /** @var User $user */
        $user = $this->getUser();

        $posts = $postRepository->findFeed($user);

        return $this->render('feed/feed.html.twig', [
            'posts' => $posts,
        ]);
    }
}
