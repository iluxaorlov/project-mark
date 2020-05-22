<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class SubscribeActionController extends AbstractController
{
    /**
     * @Route("/{nickname}/subscribe", name="subscribe", methods={"post"})
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function subscribe(User $user, Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST) === false) {
            throw new NotFoundHttpException();
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if ($currentUser !== $user && $currentUser->getSubscriptions()->contains($user) === false) {
            $currentUser->getSubscriptions()->add($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currentUser);
            $entityManager->flush();
        }

        return $this->render('user/action.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{nickname}/unsubscribe", name="unsubscribe", methods={"post"})
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function unsubscribe(User $user, Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST) === false) {
            throw new NotFoundHttpException();
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if ($currentUser !== $user && $currentUser->getSubscriptions()->contains($user) === true) {
            $currentUser->getSubscriptions()->removeElement($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currentUser);
            $entityManager->flush();
        }

        return $this->render('user/action.html.twig', [
            'user' => $user,
        ]);
    }
}
