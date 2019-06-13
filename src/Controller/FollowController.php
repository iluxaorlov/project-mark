<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class FollowController extends AbstractController
{
    /**
     * @Route("/{nickname}/following", name="following")
     */
    public function following(User $user)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $users = $user->getFollowing();

        return $this->render('follow/following.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @param User $user
     * @return Response
     *
     * @Route("/{nickname}/followers", name="followers")
     */
    public function followers(User $user)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $users = $user->getFollowers();

        return $this->render('follow/followers.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @param User $userToFollow
     * @param Request $request
     * @return Response
     *
     * @Route("/{nickname}/follow")
     */
    public function follow(User $userToFollow, Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if ($currentUser !== $userToFollow) {
            if (!$currentUser->getFollowing()->contains($userToFollow)) {
                $currentUser->getFollowing()->add($userToFollow);
                $this->getDoctrine()->getManager()->flush();
            }
        }

        return $this->render('user/action.html.twig', [
            'user' => $userToFollow
        ]);
    }

    /**
     * @param User $userToUnfollow
     * @param Request $request
     * @return Response
     *
     * @Route("/{nickname}/unfollow")
     */
    public function unfollow(User $userToUnfollow, Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if ($currentUser !== $userToUnfollow) {
            if ($currentUser->getFollowing()->contains($userToUnfollow)) {
                $currentUser->getFollowing()->removeElement($userToUnfollow);
                $this->getDoctrine()->getManager()->flush();
            }
        }

        return $this->render('user/action.html.twig', [
            'user' => $userToUnfollow
        ]);
    }
}