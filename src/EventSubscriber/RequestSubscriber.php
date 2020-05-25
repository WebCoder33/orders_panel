<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event)
    {
		if (!$event->getRequest()->isXmlHttpRequest()) {
			throw new BadRequestHttpException('400 Bad Request');
		}
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
