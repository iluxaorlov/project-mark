<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Format;

class UserController extends AbstractController
{
    private const LIMIT = 64;
    private static $tempNickname = null;

    /**
     * @param Request $request
     * @param Format $format
     * @return Response
     *
     * @Route("/settings", name="settings")
     * @IsGranted("ROLE_USER")
     */
    public function settings(Request $request, Format $format)
    {
        /** @var User $user */
        $user = $this->getUser();

        if (self::$tempNickname === null) {
            // saving current user's nickname
            self::$tempNickname = $user->getNickname();
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // if form is valid then save changes
            $user->setNickname($format->formatNickname($form->get('nickname')->getData()));
            $user->setFullName($format->formatFullName($form->get('fullName')->getData()));
            $user->setAbout($format->formatAbout($form->get('about')->getData()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            // and redirect to user's page
            return $this->redirectToRoute('view', [
                'nickname' => $user->getNickname()
            ]);
        } else {
            // else restore user nickname
            $user->setNickname(self::$tempNickname);
        }

        // render settings page
        return $this->render('user/settings.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param User $user
     * @param Request $request
     * @param PostRepository $repository
     * @return Response
     *
     * @Route("/{nickname}", name="view")
     */
    public function view(User $user, Request $request, PostRepository $repository)
    {
        if ($request->isXmlHttpRequest()) {
            return $this->loading($user, $request, $repository);
        }

        // count all user's posts
        $countPosts = $repository->countUserPosts($user);

        $posts = $repository->findBy(
            ['user' => $user],
            ['createdAt' => 'DESC'],
            self::LIMIT
        );

        // render user's page
        return $this->render('user/view.html.twig', [
            'user' => $user,
            'countPosts' => $countPosts,
            'posts' => $posts
        ]);
    }

    /**
     * @param User $user
     * @param Request $request
     * @param PostRepository $postRepository
     * @throws HttpException
     * @return Response
     */
    public function loading(User $user, Request $request, PostRepository $postRepository)
    {
        // number of posts on the page
        $offset = $request->get('offset');

        if (!$offset) {
            // if there's no posts on the page then return response with code 400
            throw new HttpException(400);
        }

        $posts = $postRepository->findBy(
            ['user' => $user],
            ['createdAt' => 'DESC'],
            self::LIMIT,
            $offset
        );

        if (!$posts) {
            // if there's no user's posts then return response with code 204
            throw new HttpException(204);
        }

        // response with list of user's posts
        return $this->render('post/post.html.twig', [
            'posts' => $posts
        ]);
    }
}
