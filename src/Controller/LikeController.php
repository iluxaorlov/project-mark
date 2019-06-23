<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    /**
     * @param Post $post
     * @param Request $request
     * @throws NotFoundHttpException
     * @return Response
     *
     * @Route("/{id}/like")
     */
    public function like(Post $post, Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        $user = $this->getUser();

        if (!$post->getLikes()->contains($user)) {
            $post->getLikes()->add($user);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('post/like.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @param Post $post
     * @param Request $request
     * @throws NotFoundHttpException
     * @return Response
     *
     * @Route("/{id}/unlike")
     */
    public function unlike(Post $post, Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        $user = $this->getUser();

        if ($post->getLikes()->contains($user)) {
            $post->getLikes()->removeElement($user);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('post/like.html.twig', [
            'post' => $post
        ]);
    }
}