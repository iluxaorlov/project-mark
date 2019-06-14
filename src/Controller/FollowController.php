<?php

namespace App\Controller;

use App\Entity\User;
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
class FollowController extends AbstractController
{
    private const LIMIT = 64;

    /**
     * @param User $user
     * @param Request $request
     * @return Response
     *
     * @Route("/{nickname}/following", name="following")
     */
    public function following(User $user, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $offset = $request->get('offset');

            if (!$offset) {
                throw new HttpException(400);
            }

            $users = $user->getFollowing()->slice($offset, self::LIMIT);

            if (!$users) {
                throw new HttpException(204);
            }

            return $this->render('user/user.html.twig', [
                'users' => $users
            ]);
        }

        $users = $user->getFollowing()->slice(0, self::LIMIT);

        return $this->render('follow/following.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return Response
     *
     * @Route("/{nickname}/followers", name="followers")
     */
    public function followers(User $user, Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $offset = $request->get('offset');

            if (!$offset) {
                throw new HttpException(400);
            }

            $users = $user->getFollowers()->slice($offset, self::LIMIT);

            if (!$users) {
                throw new HttpException(204);
            }

            return $this->render('user/user.html.twig', [
                'users' => $users
            ]);
        }

        $users = $user->getFollowers()->slice(0, self::LIMIT);

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