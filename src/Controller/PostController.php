<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_USER")
 */
class PostController extends AbstractController
{
    /**
     * @param User $user
     * @param Request $request
     * @param PostRepository $postRepository
     * @throws NotFoundHttpException
     * @throws HttpException
     * @return Response
     *
     * @Route("/{nickname}/create")
     */
    public function create(User $user, Request $request, PostRepository $postRepository)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if ($currentUser !== $user) {
            throw new NotFoundHttpException();
        }

        $text = $request->get('text');

        if (!$text) {
            throw new HttpException(204);
        }

        $post = new Post();
        $post->setUser($currentUser);
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