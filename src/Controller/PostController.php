<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @param Request $request
     * @param PostRepository $postRepository
     * @throws NotFoundHttpException
     * @throws HttpException
     * @return Response
     *
     * @Route("/post/create")
     */
    public function create(Request $request, PostRepository $postRepository)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        $user = $this->getUser();
        $text = $request->get('text');

        if (!$text) {
            throw new HttpException(204);
        }

        $post = new Post();
        $post->setUser($user);
        $post->setText($text);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($post);
        $entityManager->flush();

        $posts = $postRepository->findBy([
            'id' => $post->getId()
        ]);

        return $this->render('post/post.html.twig', [
            'posts' => $posts
        ]);
    }
}