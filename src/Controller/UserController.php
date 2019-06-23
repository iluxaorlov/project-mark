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
    private static $lastNickname;

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
        // post request
        if ($request->isXmlHttpRequest()) {
            $offset = $request->get('offset');

            if (!$offset) {
                // if there's no offset then return response with code 400
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

        // count all user's posts
        $countPosts = $postRepository->countUserPosts($user);

        $posts = $postRepository->findBy(
            ['user' => $user],
            ['createdAt' => 'DESC'],
            self::LIMIT,
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
     * @param FormatText $formatText
     * @return Response
     *
     * @Route("/{nickname}/settings", name="settings")
     * @IsGranted("ROLE_USER")
     */
    public function settings(User $user, Request $request, FormatText $formatText)
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if ($currentUser !== $user) {
            throw new NotFoundHttpException();
        }

        if (!self::$lastNickname) {
            // saving current user nickname
            self::$lastNickname = $currentUser->getNickname();
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // if form is valid then save changes
            $user->setNickname($formatText->formatNickname($form->get('nickname')->getData()));
            $user->setAbout($formatText->formatText($form->get('about')->getData()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            // and redirect to user's page
            return $this->redirectToRoute('view', [
                'nickname' => $user->getNickname()
            ]);
        } else {
            // else restore user nickname
            $user->setNickname(self::$lastNickname);
        }

        // render settings page
        return $this->render('user/settings.html.twig', [
            'form' => $form->createView()
        ]);
    }
}