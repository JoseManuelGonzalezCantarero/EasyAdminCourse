<?php

namespace AppBundle\Event;


use AppBundle\Entity\User;
use JavierEguiluz\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{

    private $tokenStorage;
    private $authorizationChecker;

    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }

    public static function getSubscribedEvents()
    {
        return [
            EasyAdminEvents::PRE_UPDATE => 'onPreUpdate',
            EasyAdminEvents::PRE_EDIT => 'onPreEdit',
        ];
    }

    public function onPreEdit(GenericEvent $event)
    {
        $config = $event->getSubject();
        if ($config['class'] == User::class) {
            $this->denyAccessUnlessSuperAdmin();
        }
    }

    public function onPreUpdate(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if ($entity instanceof User) {
            $user = $this->tokenStorage->getToken()->getUser();
            if (!$user instanceof User) {
                $user = null;
            }

            $entity->setLastUpdatedBy($user);
        }
    }

    private function denyAccessUnlessSuperAdmin()
    {
        if (!$this->authorizationChecker->isGranted('ROLE_SUPERADMIN')) {
            throw new AccessDeniedException();
        }
    }

}
