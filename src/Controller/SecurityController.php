<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param ValidatorInterface $validator
     *
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, ValidatorInterface $validator): Response
    {
        $lastNickname = $request->get('nickname');
        $error = null;

        if ($request->isMethod(Request::METHOD_POST)) {
            $user = new User();
            $user->setNickname($request->get('nickname') ?: null);
            $user->setPassword($request->get('password') ?: null);
            $errors = $validator->validate($user);

            if ($errors->count() > 0) {
                $error = $errors->get(0);
            }

            if ($errors->count() < 1) {
                $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('login');
            }
        }

        return $this->render('security/register.html.twig', [
            'lastNickname' => $lastNickname,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/login", name="login")
     *
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $lastNickname = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('security/login.html.twig', [
            'lastNickname' => $lastNickname,
            'error' => $error,
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
    }
}
