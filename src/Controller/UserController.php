<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/{username}", name="profile")
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

    /**
     * @Route("/settings", name="settings")
     *
     * @param Request $request
     * @param ValidatorInterface $validator
     *
     * @return Response
     */
    public function settings(Request $request, ValidatorInterface $validator)
    {
        /** @var User $user */
        $user = $this->getUser();
        $error = null;

        if ($request->getMethod() === Request::METHOD_POST) {
            $user->setUsername($request->get('username'));
            $user->setFullName($request->get('full_name'));
            $user->setAbout($request->get('about'));
            $errors = $validator->validate($user);

            if ($errors->count() > 0) {
                $error = $errors->get(0);
            }

            if ($errors->count() < 0) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('profile', [
                    'username' => $user->getUsername(),
                ]);
            }
        }

        return $this->render('user/settings.html.twig', [
            'user' => $user,
            'error' => $error,
        ]);
    }
}
