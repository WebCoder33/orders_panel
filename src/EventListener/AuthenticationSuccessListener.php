<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class AuthenticationSuccessListener
 * @package App\EventListener
 */
class AuthenticationSuccessListener
{
    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData();
        $user = $event->getUser();

        if(!$user instanceof UserInterface) {
            return;
        }

        $data['user'] = [
            'id' => $user->getId(),
            'fullName' => $user->getFullName(),
            'roles' => $user->getRoles(),
            'isActive' => $user->getIsActive()
        ];

        $event->setData($data);
    }
}