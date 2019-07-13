<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @IsGranted("ROLE_USER")
     */
    public function like(Post $post, Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            // if request is not post request then return response with code 404
            throw new NotFoundHttpException();
        }

        /** @var User $user */
        $user = $this->getUser();

        if (!$post->getLikes()->contains($user)) {
            // if post haven't like from current user
            $post->getLikes()->add($user);
            $this->getDoctrine()->getManager()->flush();
        }

        // return response with like button
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
     * @IsGranted("ROLE_USER")
     */
    public function unlike(Post $post, Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            // if request is not post request then return response with code 404
            throw new NotFoundHttpException();
        }

        /** @var User $user */
        $user = $this->getUser();

        if ($post->getLikes()->contains($user)) {
            // if post have like from current user
            $post->getLikes()->removeElement($user);
            $this->getDoctrine()->getManager()->flush();
        }

        // return response with like button
        return $this->render('post/like.html.twig', [
            'post' => $post
        ]);
    }
}
