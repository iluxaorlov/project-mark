<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    private const LIMIT = 64;

    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @return Response
     *
     * @Route("/search", name="search")
     * @IsGranted("ROLE_USER")
     */
    public function search(Request $request, UserRepository $userRepository)
    {
        if ($request->isXmlHttpRequest()) {
            $offset = $request->get('offset');

            if (!$offset) {
                $users = $userRepository->search(
                    $request->get('query'),
                    self::LIMIT,
                );

                if (!$users) {
                    throw new HttpException(204);
                }

                return $this->render('user/user.html.twig', [
                    'users' => $users
                ]);
            }

            $users = $userRepository->search(
                $request->get('query'),
                self::LIMIT,
                $offset
            );

            if (!$users) {
                throw new HttpException(204);
            }

            return $this->render('user/user.html.twig', [
                'users' => $users
            ]);
        }

        return $this->render('search/search.html.twig');
    }
}