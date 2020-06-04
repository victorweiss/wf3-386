<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private $tokenStorage;
    private $router;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        UrlGeneratorInterface $router
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->router = $router;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$token = $this->tokenStorage->getToken()) return;
        if (!$user = $token->getUser()) return;
        if (!$user instanceof User) return;
        if ($user->getActive() == 1) return;

        $response = new RedirectResponse($this->router->generate('app_logout'));
        $event->setResponse($response);


        // $token = $this->tokenStorage->getToken();
        // if ($token) {
        //     $user = $token->getUser();
        //     if ($user instanceof User) {
        //         if ($user->getActive() != 1) {
        //             $response = new RedirectResponse($this->router->generate('app_logout'));
        //             $event->setResponse($response);
        //         }
        //     }
        // }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
