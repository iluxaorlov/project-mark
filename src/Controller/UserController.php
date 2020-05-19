<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/settings", name="settings")
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     * @param ValidatorInterface $validator
     *
     * @return Response
     */
    public function settings(Request $request, ValidatorInterface $validator)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var User $user */
        $user = $this->getUser();
        $lastNickname = $user->getNickname();
        $error = null;

        if ($request->getMethod() === Request::METHOD_POST) {
            $user->setNickname($request->get('nickname') ?: null);
            $user->setFullName($request->get('full_name') ?: null);
            $user->setAbout($request->get('about') ?: null);
            $errors = $validator->validate($user);

            if ($errors->count() > 0) {
                $user->setNickname($lastNickname);
                $error = $errors->get(0);
            }

            if ($errors->count() < 1) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('profile', [
                    'nickname' => $user->getNickname(),
                ]);
            }
        }

        return $this->render('user/settings.html.twig', [
            'user' => $user,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/{nickname}", name="profile")
     *
     * @param User $user
     *
     * @return Response
     */
    public function profile(User $user)
    {
        return $this->render('user/profile.html.twig', [
            'user' => $user,
            'posts' => $user->getPosts(),
        ]);
    }
}
