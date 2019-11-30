<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
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
        // post request
        if ($request->isMethod('POST')) {
            return $this->loading($user->getFollowing(), $request);
        }

        $users = $user->getFollowing()->slice(0, self::LIMIT);

        // render following page
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
        // post request
        if ($request->isMethod('POST')) {
            return $this->loading($user->getFollowing(), $request);
        }

        $users = $user->getFollowers()->slice(0, self::LIMIT);

        // render followers page
        return $this->render('follow/followers.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @param User $userToFollow
     * @param Request $request
     * @throws NotFoundHttpException
     * @return Response
     *
     * @Route("/{nickname}/follow")
     */
    public function follow(User $userToFollow, Request $request)
    {
        if (!$request->isMethod('POST')) {
            // if request is not post request then return response with code 404
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

        // return response with action button
        return $this->render('user/action.html.twig', [
            'user' => $userToFollow
        ]);
    }

    /**
     * @param User $userToUnfollow
     * @param Request $request
     * @throws NotFoundHttpException
     * @return Response
     *
     * @Route("/{nickname}/unfollow")
     */
    public function unfollow(User $userToUnfollow, Request $request)
    {
        if (!$request->isMethod('POST')) {
            // if request is not post request then return response with code 404
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

        // return response with action button
        return $this->render('user/action.html.twig', [
            'user' => $userToUnfollow
        ]);
    }

    /**
     * @param ArrayCollection $users
     * @param Request $request
     * @throws HttpException
     * @return Response
     */
    private function loading(ArrayCollection $users, Request $request)
    {
        // number of users on the page
        $offset = $request->get('offset');

        if (!$offset) {
            // if there's no users on the page then return response with code 400
            throw new HttpException(400);
        }

        $users = $users->slice($offset, self::LIMIT);

        if (!$users) {
            // if there's no users then return response with code 204
            throw new HttpException(204);
        }

        // return response with list of users
        return $this->render('user/user.html.twig', [
            'users' => $users
        ]);
    }
}