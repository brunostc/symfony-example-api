<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Interfaces\JWTAuthenticatedControllerInterface;
use App\Service\JWTService;

class JWTSubscriber implements EventSubscriberInterface
{
    public function __construct(
        readonly protected JWTService $JWTService
    )
    {}

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof JWTAuthenticatedControllerInterface) {
            $jwtToken = $event->getRequest()->headers->get('Authorization');

            if (!$jwtToken) {
                throw new AccessDeniedHttpException('This action needs a valid token!');
            }

            $jwtParts = explode(' ', $jwtToken);

            if (count($jwtParts) < 2 || !is_array($jwtParts)) {
                throw new AccessDeniedHttpException('This action needs a valid token!');
            }

            try {
                $this->JWTService->decode($jwtParts[1]);
            } catch (\Exception $e) {
                throw new AccessDeniedHttpException('This action needs a valid token!');
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
