<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FormatText;

class UserController extends AbstractController
{
    private const LIMIT = 64;
    private static $lastNickname = null;

    /**
     * @param User $user
     * @param Request $request
     * @param PostRepository $postRepository
     * @return Response
     *
     * @Route("/{nickname}", name="view")
     */
    public function view(User $user, Request $request, PostRepository $postRepository)
    {
        if ($request->isXmlHttpRequest()) {
            $offset = $request->get('offset');

            if (!$offset) {
                throw new HttpException(400);
            }

            $posts = $postRepository->findBy(
                ['user' => $user],
                ['createdAt' => 'DESC'],
                self::LIMIT,
                $offset
            );

            if (!$posts) {
                throw new HttpException(204);
            }

            return $this->render('post/post.html.twig', [
                'posts' => $posts
            ]);
        }

        $countPosts = $postRepository->countUserPosts($user);
        $posts = $postRepository->findBy(
            ['user' => $user],
            ['createdAt' => 'DESC'],
            self::LIMIT
        );

        return $this->render('user/view.html.twig', [
            'user' => $user,
            'countPosts' => $countPosts,
            'posts' => $posts
        ]);
    }

    /**
     * @param User $user
     * @param Request $request
     * @param FormatText $formatText
     * @return Response
     *
     * @Route("/{nickname}/settings", name="settings")
     * @IsGranted("ROLE_USER")
     */
    public function settings(User $user, Request $request, FormatText $formatText, UserRepository $userRepository)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if ($currentUser !== $user) {
            throw new NotFoundHttpException();
        }

        if (!self::$lastNickname) {
            self::$lastNickname = $currentUser->getNickname();
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setNickname($formatText->formatNickname($form->get('nickname')->getData()));
            $user->setAbout($formatText->formatText($form->get('about')->getData()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('view', [
                'nickname' => $user->getNickname()
            ]);
        } else {
            $user->setNickname(self::$lastNickname);
        }

        return $this->render('user/settings.html.twig', [
            'form' => $form->createView()
        ]);
    }
}