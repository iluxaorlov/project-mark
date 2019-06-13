<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/edit")
     */
    public function edit(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('user', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param User $user
     * @param PostRepository $postRepository
     * @return Response
     *
     * @Route("/{id}", name="user")
     */
    public function view(User $user, PostRepository $postRepository)
    {
        $posts = $postRepository->findBy(
            ['user' => $user],
            ['createdAt' => 'DESC']
        );

        return $this->render('user/view.html.twig', [
            'user' => $user,
            'posts' => $posts
        ]);
    }
}