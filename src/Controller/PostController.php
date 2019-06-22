<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use App\Service\FormatText;
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
     * @param FormatText $formatText
     * @throws NotFoundHttpException
     * @throws HttpException
     * @return Response
     *
     * @Route("/{nickname}/create")
     * @IsGranted("ROLE_USER")
     */
    public function create(User $user, Request $request, PostRepository $postRepository, FormatText $formatText)
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
        $post->setText($formatText->formatText($text));

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

    /**
     * @param Post $post
     * @param Request $request
     * @return Response
     *
     * @Route("/{id}/delete", name="delete")
     * @IsGranted("ROLE_USER")
     */
    public function delete(Post $post, Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        $currentUser = $this->getUser();
        $postUser = $post->getUser();

        if ($currentUser !== $postUser) {
            throw new NotFoundHttpException();
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($post);
        $entityManager->flush();

        return new Response();
    }
}