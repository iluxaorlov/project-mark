<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use App\Service\Format;
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
     * @param PostRepository $repository
     * @param Format $format
     * @throws NotFoundHttpException
     * @throws HttpException
     * @return Response
     *
     * @Route("/{nickname}/create")
     * @IsGranted("ROLE_USER")
     */
    public function create(User $user, Request $request, PostRepository $repository, Format $format)
    {
        if (!$request->isXmlHttpRequest()) {
            // if request is not post request then return response with code 404
            throw new NotFoundHttpException();
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if ($currentUser !== $user) {
            throw new NotFoundHttpException();
        }

        $text = $request->get('text');
        $text = $format->formatText($text);

        if ($text === null) {
            throw new HttpException(204);
        }

        $post = new Post();
        $post->setUser($currentUser);
        $post->setText($text);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($post);
        $entityManager->flush();

        // find last insert post
        $posts = $repository->findBy([
            'id' => $post->getId()
        ]);

        // return response with last insert post
        return $this->render('post/post.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @param Post $post
     * @param Request $request
     * @throws NotFoundHttpException
     * @return Response
     *
     * @Route("/{id}/delete", name="delete")
     * @IsGranted("ROLE_USER")
     */
    public function delete(Post $post, Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            // if request is not post request then return response with code 404
            throw new NotFoundHttpException();
        }

        $user = $this->getUser();
        $postUser = $post->getUser();

        if ($user !== $postUser) {
            throw new NotFoundHttpException();
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($post);
        $entityManager->flush();

        // return response with code 200
        return new Response();
    }
}
