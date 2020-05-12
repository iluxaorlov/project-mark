<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        ]);
    }
}
