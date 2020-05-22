<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubscribeController extends AbstractController
{
    /**
     * @Route("/{nickname}/subscribers", name="subscribers")
     * @param User $user
     * @return Response
     */
    public function subscribers(User $user): Response
    {
        $subscribers = $user->getSubscribers();

        return $this->render('subscribe/subscribe.html.twig', [
            'title' => 'Подписчики',
            'users' => $subscribers,
        ]);
    }

    /**
     * @Route("/{nickname}/subscriptions", name="subscriptions")
     * @param User $user
     * @return Response
     */
    public function subscriptions(User $user): Response
    {
        $subscriptions = $user->getSubscriptions();

        return $this->render('subscribe/subscribe.html.twig', [
            'title' => 'Подписки',
            'users' => $subscriptions,
        ]);
    }
}
